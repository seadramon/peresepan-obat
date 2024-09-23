<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PasienRepositoryInterface;
use Session;
use Validator;
use Log;

class PasienController extends Controller
{
    private $pasienRepository;

    public function __construct(PasienRepositoryInterface $pasienRepository)
    {
        $this->pasienRepository = $pasienRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->pasienRepository->getAllPasien(10, $request->search);

        return view('pasien.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('pasien.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pasien' => 'required|string|max:255',  
            'nohp' => 'required|string|max:255',  
            'alamat' => 'required|string|max:255',  
        ]);

        try {
            $tanda = $this->pasienRepository->createPasien($request->all());

            Session::flash('success', 'Data berhasil disimpan');

            return redirect()->route('pasien.index');
        } catch (\Exception $e) {
            Log::error('Pasien gagal disimpan: ' . $e->getMessage());

            Session::flash('error', 'Data gagal disimpan');
            return redirect()->route('pasien.index');
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
    public function edit(string $id)
    {
        $data = $this->pasienRepository->getPasienById($id);

        return view('pasien.edit', compact('data', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nama_pasien' => 'required|string|max:255',  
            'nohp' => 'required|string|max:255',  
            'alamat' => 'required|string|max:255',  
        ]);

        try {
            $tanda = $this->pasienRepository->updatePasien($id, $request->except(['_method', '_token']));

            Session::flash('success', 'Data berhasil disimpan');

            return redirect()->route('pasien.index');
        } catch (\Exception $e) {
            Log::error('Pasien gagal disimpan: ' . $e->getMessage());

            Session::flash('error', 'Data gagal disimpan');
            return redirect()->route('pasien.index');
        }
    }
}
