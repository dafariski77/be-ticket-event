<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            "message" => "Success get all categories data!",
            "data" => $categories
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Category::validate($request);

        $createCategory = Category::create([
            "name" => $request->name,
        ]);

        return response()->json([
            "message" => "Category created!",
            "data" => $createCategory
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message" => "Category not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            "message" => "Success find category!",
            "data" => $category
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Category::validate($request);

        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message" => "Category not found!",
            ], Response::HTTP_NOT_FOUND);
        }

        $category->name = $request->name;
        $category->save();

        return response()->json([
            "message" => "Category updated!",
            "data" => $category
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "message" => "Category not found!"
            ], Response::HTTP_NOT_FOUND);
        }

        if ($category->image) {
            Storage::delete('public/images' . $category->image);
        }

        $category->delete();

        return response()->json([
            "message" => "Category deleted!",
        ], Response::HTTP_OK);
    }
}
