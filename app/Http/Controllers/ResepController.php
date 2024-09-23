<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\HasilPemeriksaanRepositoryInterface;
use App\Repositories\ObatRepositoryInterface;
use App\Repositories\ResepRepositoryInterface;
use App\Models\HasilPemeriksaan;
use App\Models\Resep;
use Barryvdh\DomPDF\Facade\Pdf;

use DB;
use Log;
use Session;
use Storage;
use File;
use Validator;

class ResepController extends Controller
{
    private $hasilPemeriksaanRepository;
    private $obatRepository;
    private $resepRepository;

    public function __construct(HasilPemeriksaanRepositoryInterface $hasilPemeriksaanRepository, 
        ObatRepositoryInterface $obatRepository,
        ResepRepositoryInterface $resepRepository,
    )
    {
        $this->hasilPemeriksaanRepository = $hasilPemeriksaanRepository;
        $this->obatRepository = $obatRepository;
        $this->resepRepository = $resepRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->hasilPemeriksaanRepository->getAllHasilPemeriksaan(10, $request->search);
        
        return view('resep.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (count($request->reseps) > 0) {
            try {
                $this->resepRepository->deleteResepByPemeriksaan($request->id);

                $this->resepRepository->createMassResep($request->reseps);

                $this->hasilPemeriksaanRepository->updateHasilPemeriksaan($request->id, [
                    'apoteker_id' => \Auth::user()->account->id,
                    'status' => \App\Enum\ResepStatus::DILAYANI
                ]);

                Session::flash('success', 'Data berhasil disimpan');

                return response()->json(['result' => 'success']);
            } catch (\Exception $e) {
                Log::error('Resep gagal disimpan: ' . $e->getMessage());

                Session::flash('error', 'Data gagal disimpan');
                return response()->json(['result' => 'failed'], 422);
            }
        }

        return response()->json(['result' => 'failed'], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $auth = $this->obatRepository->authenticate();
        $medicines = $this->obatRepository->getListObat($auth->access_token);
        $medicines = $medicines['medicines'];

        $data = $this->hasilPemeriksaanRepository->getHasilPemeriksaanById($id);
        $reseps = $this->resepRepository->getAllResepByPemeriksaan($id);
        $total = $reseps->sum('harga');

        $arrMedicine = [];
        foreach ($reseps as $row) {
            $arrMedicine[] = [
                'hasil_pemeriksaan_id' => $row->hasil_pemeriksaan_id,
                'obat_id' => $row->obat_id,
                'obat' => $row->obat,
                'jumlah' => $row->jumlah, 
                'harga_satuan' => $row->harga_satuan,
                'harga' => $row->harga
            ];
        }

        return view('resep.show', compact('medicines', 'data', 'arrMedicine', 'total'));
    }

    public function getmedicinePrice(Request $request, $id)
    {
        $tglPeriksa = date('Y-m-d', strtotime($request->tgl_pemeriksaan));
        $price = 0;

        $auth = $this->obatRepository->authenticate();
        $medicinePrices = $this->obatRepository->getHargaObat($auth->access_token, $id);
        $medicinePrices = $medicinePrices['prices'];
        
        foreach ($medicinePrices as $row) {
            if (isBetweenDates($tglPeriksa, $row['start_date']['value'], $row['end_date']['value'])) {
                $price = $row['unit_price'];
            }
        }

        return $price;
    }

    public function cetakResi($id)
    {
        $data = $this->hasilPemeriksaanRepository->getHasilPemeriksaanById($id);

        $pdf = Pdf::loadView('resep.resi', [
            'data' => $data
        ]);

        $filename = "resi-pembayaran";

        return $pdf->setPaper('a4', 'landscape')
            ->stream($filename . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
