<?php
namespace App\Repositories;

use App\Models\LogActivity;
use DB;

class LogRepository implements LogRepositoryInterface
{
    public function getAllLog($limit, $search = null)
    {
        if (!empty($search)) {
            $data = LogActivity::where(DB::raw("LOWER(menu)"), 'like', '%'.strtolower($search).'%')
                ->orWhere(DB::raw("LOWER(activity)"), 'like', '%'.strtolower($search).'%')
                ->paginate($limit);
        } else {
           $data = LogActivity::paginate($limit);
        }

        return $data;
    }

    public function createLog(array $logDetails)
    {
        return DB::transaction(function () use ($logDetails) {
            $log = LogActivity::create($logDetails);
            
            return $log;
        });
    }
}