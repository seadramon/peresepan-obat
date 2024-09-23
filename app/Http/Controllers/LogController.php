<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LogRepositoryInterface;
use Session;
use Validator;
use Log;

class LogController extends Controller
{
    private $logRepository;

    public function __construct(LogRepositoryInterface $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->logRepository->getAllLog(10, $request->search);

        return view('log.index', compact('data'));
    }
}
