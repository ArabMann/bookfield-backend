<?php

namespace App\Services;

use App\Models\Gallery;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\GalleryResource;
use Illuminate\Support\Facades\Storage;
use Psy\CodeCleaner\FunctionContextPass;

class GalleryService
{
    public function getGalleries()
    {
        $galleries = Gallery::orderBy('id')->get(); // Jika Menggunakan orderBy jangan satukan dengan method all()
        return $galleries;
    }

    public function storeGallery($request)
    {
        $response = DB::transaction(function () use ($request) {
            $validation = $request->validated();

            if ($request->hasFile("image")) {
                $imagePath = $request->file('image')->store("galleries", "public");
                $validation['image'] = $imagePath;
            }
            return $gallery = Gallery::create($validation);
        });

        return $response;
    }

    public function updateGallery($request, $gallery)
    {
        $response = DB::transaction(function () use ($gallery, $request) {
            $validation = $request->validated();

            if ($request->hasFile("image")) {
                $imagePath = $request->file("image")->store("galleries", "public");
                $validation["image"] = $imagePath;

                Storage::disk("public")->delete($gallery->image);
            }
            $gallery->update($validation);
        });

        return $response;
    }

    public function destroyGallery($gallery)
    {
        DB::beginTransaction();
        try {
            Storage::disk("public")->delete($gallery->name);
            $gallery->delete();
            DB::commit();

            return response()->json([
                "success" => true,
                "message" => "Data Gallery Berhasil Dihapus",
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
            return response()->json([
                "success" => false,
                "message" => "Data Gallery Tidak Berhasil Dihapus",
            ]);
        }
    }
}
