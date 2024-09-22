<?php
namespace App\Repositories;

use App\Models\TandaVital;
use DB;

class TandaVitalRepository implements TandaVitalRepositoryInterface
{
    public function getAllTandaVital($limit, $search = null)
    {
        if (!empty($search)) {
            $data = TandaVital::where(DB::raw("LOWER(tanda)"), 'like', '%'.strtolower($search).'%')->paginate($limit);
        } else {
           $data = TandaVital::paginate($limit);
        }

        return $data;
    }

    public function getTandaVital()
    {
        return TandaVital::get();
    }

    public function getTandaVitalById($id)
    {
        return TandaVital::findOrFail($id);
    }

    public function deleteTandaVital($id)
    {
        TandaVital::destroy($id);
    }

    public function createTandaVital(array $tandaVitalDetails)
    {
        return DB::transaction(function () use ($tandaVitalDetails) {
            $tandaVital = TandaVital::create($tandaVitalDetails);
            
            return $tandaVital;
        });
    }

    public function updateTandaVital($id, array $newDetails)
    {
        return TandaVital::whereId($id)->update($newDetails);
    }
}