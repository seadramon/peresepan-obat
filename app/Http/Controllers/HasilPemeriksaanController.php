<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\HasilPemeriksaanRepositoryInterface;
use App\Repositories\TandaVitalRepositoryInterface;
use App\Repositories\PasienRepositoryInterface;
use App\Models\HasilPemeriksaan;
use App\Repositories\LogRepositoryInterface;

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
        PasienRepositoryInterface $pasienRepository,
        LogRepositoryInterface $logRepository
    )
    {
        $this->hasilPemeriksaanRepository = $hasilPemeriksaanRepository;
        $this->tandaVitalRepository = $tandaVitalRepository;
        $this->pasienRepository = $pasienRepository;
        $this->logRepository = $logRepository;
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
            'pasien_id' => 'required',
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
                $mode = 'edit';
                $tanda = $this->hasilPemeriksaanRepository->updateHasilPemeriksaan($request->id, $posts);
            } else {
                $mode = 'tambah';
                $posts['dokter_id'] = \Auth::user()->account->id;

                $tanda = $this->hasilPemeriksaanRepository->createHasilPemeriksaan($posts);
            }

            $this->logRepository->createLog([
                'user_id' => \Auth::user()->id,
                'menu' => 'hasil pemeriksaan',
                'activity' => $mode.' data pemeriksaan',
            ]);

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

        $pasiens = $this->pasienRepository->getPasien();

        $data = $hasil_pemeriksaan;

        return view('hasilpemeriksaan.create', compact('tandavitals', 'data', 'pasiens'));
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
