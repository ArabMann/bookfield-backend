<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public $externalApiService;

    // public function __construct(ExternalApiService $externalApiService) {
    //     $this->externalApiService= $externalApiService;
    // }

    public function getAll()
    {
        $categories = Category::all();
        return $categories;
    }

    public function categoryStore(array $data)
    {
        if (Auth::check() && Auth::user()->role->name === "Admin") {
            $response = DB::transaction(function () use ($data) {

                $categoryStore = Category::create($data);
                // $categoryStore = DB::table('categories')->insert($data);

                return $categoryStore;
            });
        }

        return $response;
    }

    public function categoryUpdate(array $data, $category)
    {
        $response = DB::transaction(function () use ($data, $category) {
            $categoryUpdate = $category->update($data);
            return $category;
        });
        return $response;
    }

    public function categoryDelete($category)
    {
        if (Auth::check() && Auth::user()->role->name === "Admin") {
            DB::beginTransaction();
            try {
                $category->delete();
                DB::commit();
                return response()->json([
                    "success" => true,
                    "message" => "Data Category berhasil dihapus"
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollBack();
                return response()->json([
                    "success" => false,
                    "message" => "Data Category Tidak Berhasil dihapus"
                ]);
            }
        }
    }
}
