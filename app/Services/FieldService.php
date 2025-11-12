<?php

namespace App\Services;

use App\Models\Day;
use App\Models\Field;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FieldService
{
    public function getAll()
    {
        $start = microtime(true);
        $fields = Field::all();
        $end = microtime(true);

        $executionTimeMs = round(($end - $start) * 1000, 2); // dalam ms, dibulatkan 2 angka
        Log::info("Waktu Request Field Index" . $executionTimeMs);
        return $fields;
    }

    public function fieldStore(array $data)
    {
        $response = DB::transaction(function () use ($data) {
            $storeField = Field::create($data);
            return $storeField;
        });

        return $response;
    }

    public function fieldUpdate(array $data, $field)
    {
        $response = DB::transaction(function () use ($data, $field) {
            $updateField = $field->update($data);
            return $field;
        });

        return $response;
    }

    public function fieldDelete($field)
    {
        DB::beginTransaction();
        try {
            Storage::disk("public")->delete($field->image);
            
            $field->delete();
            DB::commit();
            return response()->json([
                "success" => true,
                "message" => "Data Field Berhasil Dihapus"
            ]);
        } catch (Exception) {
            DB::rollBack();
            return response()->json([
                "success" => true,
                "message" => "Data Field Berhasil Dihapus"
            ]);
        }
    }
}
