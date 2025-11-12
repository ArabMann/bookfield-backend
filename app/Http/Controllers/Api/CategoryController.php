<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class  CategoryController extends Controller
{
    //
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        if (Auth::check() && Auth::user()->role->name !== "Admin") {
            return response()->json([
                "success" => false,
                "message" => "Anda Bukan Admin"
            ]);
        }
        $categories = $this->categoryService->getAll();
        return (CategoryResource::collection($categories))->additional([
            "success" => true,
            "message" => "Date Category Berhasil Ditampilkan",
        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        if (Auth::check() && Auth::user()->role->name !== "Admin") {
            return response()->json([
                "success" => false,
                "message" => "Anda Bukan Admin"
            ]);
        }

        $validation = $request->validated();
        $validation["slug"] = Str::slug($validation["name"]);
        $storeCategory = $this->categoryService->categoryStore($validation);
        return (new CategoryResource($storeCategory))->additional([
            "success" => true,
            "message" => "Berhasil Menambahkan Data Category",
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        if (Auth::check() && Auth::user()->role->name !== "Admin") {
            return response()->json([
                "success" => false,
                "message" => "Anda Bukan Admin"
            ]);
        }
        $validation = $request->validated();
        $validation["slug"] = Str::slug($validation["name"]);

        $updateCategory = $this->categoryService->categoryUpdate($validation, $category);
        return (new CategoryResource($updateCategory))->additional([
            "success" => true,
            "message" => "Berhasil Mengubah Data Category",
        ]);
    }

    public function destroy(Category $category)
    {
        if (Auth::check() && Auth::user()->role->name !== "Admin") {
            return response()->json([
                "success" => false,
                "message" => "Anda Bukan Admin"
            ]);
        }
        return $this->categoryService->categoryDelete($category);
    }
}
