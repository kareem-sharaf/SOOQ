<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductTag;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductTagController extends Controller
{
    public function index(Store $store): JsonResponse
    {
        $tags = $store->load('products')->find($store->id)
            ? ProductTag::where('store_id', $store->id)->withCount('products')->get()
            : collect();

        return response()->json(['data' => $tags]);
    }

    public function store(Request $request, Store $store): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
        ]);

        $data['store_id'] = $store->id;
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        $tag = ProductTag::create($data);

        return response()->json(['data' => $tag], 201);
    }

    public function update(Request $request, Store $store, ProductTag $tag): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'nullable|string|max:255',
        ]);

        $tag->update($data);

        return response()->json(['data' => $tag]);
    }

    public function destroy(Store $store, ProductTag $tag): JsonResponse
    {
        $tag->delete();
        return response()->json(['message' => 'تم حذف الوسم بنجاح']);
    }
}
