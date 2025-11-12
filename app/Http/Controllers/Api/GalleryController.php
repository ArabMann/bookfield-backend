<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use App\Services\GalleryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    //
    public $galleryService;

    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
    }

    public function index()
    {
        $galleries = $this->galleryService->getGalleries();
        return (GalleryResource::collection($galleries))->additional([
            "success" => true,
            "message" => "Data Gallery Berhasil Ditampilkan",
        ]);
    }

    public function store(StoreGalleryRequest $request)
    {
        if (Auth::check() && Auth::user()->role->name !== "Admin") {
            return response()->json([
                "success" => false,
                "message" => "Anda Bukan Admin"
            ]);
        }
        $gallery = $this->galleryService->storeGallery($request);
        return (new GalleryResource($gallery))->additional([
            "success" => true,
            "message" => "Data Gallery Berhasil Ditambahkan",
        ]);
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        if (Auth::check() && Auth::user()->role->name !== "Admin") {
            return response()->json([
                "success" => false,
                "message" => "Anda Bukan Admin",
            ]);
        }
        $this->galleryService->updateGallery($request, $gallery);
        return (new GalleryResource($gallery))->additional([
            "success" => true,
            "message" => "Data Gallery Berhasil Ditambahkan",
        ]);
    }

    public function destroy(Gallery $gallery)
    {
        return $this->galleryService->destroyGallery($gallery);
    }
}
