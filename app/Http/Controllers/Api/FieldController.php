<?php

namespace App\Http\Controllers\Api;

use App\Models\Field;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\FieldService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FieldResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;
use Illuminate\Support\Facades\Log;

class FieldController extends Controller
{
    //
    protected $fieldService;

    public function __construct(FieldService $fieldService)
    {
        $this->fieldService = $fieldService;
    }

    public function index()
    {
        $fields = $this->fieldService->getAll();
        return (FieldResource::collection($fields))->additional([
            "success" => true,
            "message" => "Data Field Berhasil Ditampilkan",
        ]);
    }

    public function store(StoreFieldRequest $request)
    {
        // if (Auth::check() && Auth::user()->role->name !== "Admin") {
        //     return response()->json([
        //         "success" => false,
        //         "message" => "Anda Bukan Admin"
        //     ]);
        // }
        $validation = $request->validated();

        $image = $request->hasFile("image");
        if ($image) {
            $imagePath = $request->file("image")->store("images", "public");
            $validation["image"] = $imagePath;
        }
        $validation["slug"] = Str::slug($validation["name"]);

        $field = $this->fieldService->fieldStore($validation);
        return (new FieldResource($field))->additional([
            "success" => true,
            "message" => "Data Field berhasil ditambahkan",
        ]);
    }

    public function show(Field $field)
    {
        $start = microtime(true);
        $field->load("days.schedules");
        $end = microtime(true);
        
        $executionTimeMs = round(($end - $start) * 1000, 2); // dalam ms, dibulatkan 2 angka
        Log::info("Waktu Request Field Show" . $executionTimeMs);
        return (new FieldResource($field))->additional([
            "success" => true,
            "name" => "Data Field Berhasil di Show",
        ]);
    }


    public function update(UpdateFieldRequest $request, Field $field)
    {
        // if (Auth::check() && Auth::user()->role->name !== "Admin") {
        //     return response()->json([
        //         "success" => false,
        //         "message" => "Anda Bukan Admin"
        //     ]);
        // }
        $validation = $request->validated();
        $image = $request->hasFile("image");
        // dd($field->image);
        if ($image) {
            Storage::disk('public')->delete($field->image);
            $imagePath = $request->file("image")->store("images", "public");
            $validation['image'] = $imagePath;
        }
        $validation["slug"] = Str::slug($validation["name"]);

        $field = $this->fieldService->fieldUpdate($validation, $field);
        return (new FieldResource($field))->additional([
            "success" => true,
            "message" => "Data Field berhasil ditambahkan",
        ]);
    }

    public function destroy(Field $field)
    {
        // dd($field);
        return $this->fieldService->fieldDelete($field);
    }
}
