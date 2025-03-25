<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
          $categories = Category::all();
          return $this->ok('categories fetched successfully', $categories);
        } catch (Throwable $th) {
          return $this->error($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
