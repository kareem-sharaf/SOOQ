<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Store $store): JsonResponse
    {
        $categories = $store->categories()
            ->withCount('products')
            ->with('children')
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return response()->json(['data' => $categories]);
    }

    public function store(Request $request, Store $store): JsonResponse
    {
        $data = $request->validate([
            'name_ar'   => 'required|string|max:255',
            'name_en'   => 'nullable|string|max:255',
            'slug'      => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image'     => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data['store_id'] = $store->id;
        $data['slug'] = $data['slug'] ?? Str::slug($data['name_en'] ?? $data['name_ar']);

        $category = Category::create($data);

        return response()->json(['data' => $category], 201);
    }

    public function show(Store $store, Category $category): JsonResponse
    {
        $category->loadCount('products')->load('children');
        return response()->json(['data' => $category]);
    }

    public function update(Request $request, Store $store, Category $category): JsonResponse
    {
        $data = $request->validate([
            'name_ar'    => 'sometimes|string|max:255',
            'name_en'    => 'nullable|string|max:255',
            'slug'       => 'nullable|string|max:255',
            'parent_id'  => 'nullable|exists:categories,id',
            'image'      => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);

        $category->update($data);

        return response()->json(['data' => $category]);
    }

    public function destroy(Store $store, Category $category): JsonResponse
    {
        $category->delete();
        return response()->json(['message' => 'تم حذف الفئة بنجاح']);
    }
}
