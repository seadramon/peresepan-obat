<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ApotekerRepositoryInterface;
use Session;
use Validator;
use Log;
use Hash;

class ApotekerController extends Controller
{
    private $apotekerRepository;

    public function __construct(ApotekerRepositoryInterface $apotekerRepository)
    {
        $this->apotekerRepository = $apotekerRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->apotekerRepository->getAllApoteker(10, $request->search);

        return view('apoteker.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('apoteker.create');
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
            'nomor_stra' => 'required|string|max:20',  
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

            $tanda = $this->apotekerRepository->createApoteker($posts, $users);

            Session::flash('success', 'Data berhasil disimpan');

            return redirect()->route('apoteker.index');
        } catch (\Exception $e) {
            Log::error('Apoteker gagal disimpan: ' . $e->getMessage());

            Session::flash('error', 'Data gagal disimpan');
            return redirect()->route('apoteker.index');
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
        $data = $this->apotekerRepository->getApotekerById($id);
        $user = $data->account;

        return view('apoteker.edit', compact('data', 'id', 'user'));
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
            'nomor_stra' => 'required|string|max:20'
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

            $tanda = $this->apotekerRepository->updateApoteker($id, $posts, $users);

            Session::flash('success', 'Data berhasil disimpan');

            return redirect()->route('apoteker.index');
        } catch (\Exception $e) {
            Log::error('Apoteker gagal disimpan: ' . $e->getMessage());

            Session::flash('error', 'Data gagal disimpan');
            return redirect()->route('apoteker.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->apotekerRepository->deleteApoteker($id);

        Session::flash('success', 'Data berhasil dihapus');
        return redirect()->route('apoteker.index');
    }
}
