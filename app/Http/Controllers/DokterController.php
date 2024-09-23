<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DokterRepositoryInterface;
use Session;
use Validator;
use Log;
use Hash;

class DokterController extends Controller
{
    private $dokterRepository;

    public function __construct(DokterRepositoryInterface $dokterRepository)
    {
        $this->dokterRepository = $dokterRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->dokterRepository->getAllDokter(10, $request->search);

        return view('dokter.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('dokter.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'alamat' => 'required|string|max:20',  
            'spesialisasi' => 'required|string|max:20',  
            'email' => 'required|string|max:20',  
            'password' => 'required|string|max:20',
        ]);

        try {
            $posts = $request->all();
            $users = [
                'email' => $posts['email'],
                'password' => Hash::make($posts['password']),
                'name' => $posts['nama']
            ];
            unset($posts['email']);
            unset($posts['password']);

            $tanda = $this->dokterRepository->createDokter($posts, $users);

            Session::flash('success', 'Data berhasil disimpan');

            return redirect()->route('dokter.index');
        } catch (\Exception $e) {
            Log::error('Tanda vital gagal disimpan: ' . $e->getMessage());

            Session::flash('error', 'Data gagal disimpan');
            return redirect()->route('dokter.index');
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
        $data = $this->dokterRepository->getDokterById($id);

        $user = $data->account;

        return view('dokter.edit', compact('data', 'id', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nohp' => 'required|string|max:20',
            'alamat' => 'required|string|max:20',  
            'spesialisasi' => 'required|string|max:20'
        ]);

        try {
            $posts = $request->all();
            $users = [
                'password' => Hash::make($posts['password']),
                'name' => $posts['nama']
            ];
            unset($posts['email']);
            unset($posts['password']);
            unset($posts['_method']);
            unset($posts['_token']);

            $tanda = $this->dokterRepository->updateDokter($id, $posts, $users);

            Session::flash('success', 'Data berhasil disimpan');

            return redirect()->route('dokter.index');
        } catch (\Exception $e) {
            Log::error('Data Dokter gagal disimpan: ' . $e->getMessage());

            Session::flash('error', 'Data gagal disimpan');
            return redirect()->route('dokter.index');
        }
    }
}
