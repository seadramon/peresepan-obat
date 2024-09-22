<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TandaVitalRepositoryInterface;
use Session;
use Validator;
use Log;

class TandaVitalController extends Controller
{
    private $tandaVitalRepository;

    public function __construct(TandaVitalRepositoryInterface $tandaVitalRepository)
    {
        $this->tandaVitalRepository = $tandaVitalRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->tandaVitalRepository->getAllTandaVital(10, $request->search);

        return view('tandavital.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('tandavital.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanda' => 'required|string|max:100'  
        ]);

        try {
            $tanda = $this->tandaVitalRepository->createTandaVital($request->all());

            Session::flash('success', 'Data berhasil disimpan');

            return redirect()->route('tanda-vital.index');
        } catch (\Exception $e) {
            Log::error('Tanda vital gagal disimpan: ' . $e->getMessage());

            Session::flash('error', 'Data gagal disimpan');
            return redirect()->route('tanda-vital.index');
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
        $data = $this->tandaVitalRepository->getTandaVitalById($id);

        return view('tandavital.edit', compact('data', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'tanda' => 'required|string|max:100'  
        ]);

        try {
            $tanda = $this->tandaVitalRepository->updateTandaVital($id, $request->except(['_method', '_token']));

            Session::flash('success', 'Data berhasil disimpan');

            return redirect()->route('tanda-vital.index');
        } catch (\Exception $e) {
            Log::error('Tanda vital gagal disimpan: ' . $e->getMessage());

            Session::flash('error', 'Data gagal disimpan');
            return redirect()->route('tanda-vital.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->tandaVitalRepository->deleteTandaVital($id);

        Session::flash('success', 'Data berhasil dihapus');
        return redirect()->route('tanda-vital.index');
    }
}
