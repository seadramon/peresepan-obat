<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\HasilPemeriksaanRepositoryInterface;
use App\Repositories\TandaVitalRepositoryInterface;
use App\Repositories\PasienRepositoryInterface;
use App\Models\HasilPemeriksaan;

use DB;
use Log;
use Session;
use Storage;
use File;
use Validator;

class HasilPemeriksaanController extends Controller
{
    private $hasilPemeriksaanRepository;
    private $tandaVitalRepository;
    private $pasienRepository;

    public function __construct(HasilPemeriksaanRepositoryInterface $hasilPemeriksaanRepository, 
        TandaVitalRepositoryInterface $tandaVitalRepository,
        PasienRepositoryInterface $pasienRepository
    )
    {
        $this->hasilPemeriksaanRepository = $hasilPemeriksaanRepository;
        $this->tandaVitalRepository = $tandaVitalRepository;
        $this->pasienRepository = $pasienRepository;
    }

    public function index(Request $request)
    {
        $data = $this->hasilPemeriksaanRepository->getHasilPemeriksaanDokter(10, $request->search);
        
        return view('hasilpemeriksaan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = null;

        $tandavitals = $this->tandaVitalRepository->getTandaVital();
        $pasiens = $this->pasienRepository->getPasien();

        return view('hasilpemeriksaan.create', compact('tandavitals', 'data', 'pasiens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'tgl_pemeriksaan' => 'required',
            'hasil_pemeriksaan' => 'required',
            'resep' => 'required'
        ],
        [
            '*.required' => 'kolom ini wajib diisi',
            '*.string' => 'inputan harus berupa text'
        ]);

        $tandavitals = json_decode($request->tanda_vital, true);

        if ($validator->fails()) {
            if (count($tandavitals) < 1 ) {
                $validator->getMessageBag()->add('tandavital', 'Tanda-tanda vital wajib diisi');
            }
            return response()->json([
                'result' => 'failed',
                'errors' => $validator->errors()
            ]);
        } else {
            if (count($tandavitals) < 1 ) {
                $validator->getMessageBag()->add('tandavital', 'Tanda-tanda vital wajib diisi');

                return response()->json([
                    'result' => 'failed',
                    'errors' => $validator->errors()
                ]);
            }
        }
        // end:Validasi
        
        $posts = $request->all();

        if ($request->hasFile('berkas')) {
            $berkas = $request->file('berkas');
            $berkasName = time() . '.' . $berkas->getClientOriginalExtension();
            
            $berkas->storeAs('berkas', $berkasName);
            $fullpath = 'berkas/' . $berkasName;

            $posts['berkas'] = $fullpath;
        }

        try {
            if (!empty($request->id)) {
                $tanda = $this->hasilPemeriksaanRepository->updateHasilPemeriksaan($request->id, $posts);
            } else {
                $posts['dokter_id'] = \Auth::user()->account->id;
                $tanda = $this->hasilPemeriksaanRepository->createHasilPemeriksaan($posts);
            }

            Session::flash('success', 'Data berhasil disimpan');

            return response()->json(['result' => 'success']);
        } catch (\Exception $e) {
            Log::error('Hasil Pemeriksaan gagal disimpan: ' . $e->getMessage());

            Session::flash('error', 'Data gagal disimpan');
            return response()->json(['result' => 'failed'], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HasilPemeriksaan $hasil_pemeriksaan)
    {
        $tandavitals = $this->tandaVitalRepository->getTandaVital();

        $data = $hasil_pemeriksaan;

        return view('hasilpemeriksaan.create', compact('tandavitals', 'data'));
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
