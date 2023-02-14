<?php

namespace App\Http\Controllers;

use App\Services\LogService;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * @var LogService
     */
    public LogService $logService;


    /**
     * @param LogService $logService
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function show(Request $request)
    {
        $log_count = $this->logService->show($request);

        return response()->json([
            'count' => $log_count
        ]);
    }
}
