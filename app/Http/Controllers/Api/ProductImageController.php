<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function index(Store $store, Product $product): JsonResponse
    {
        return response()->json(['data' => $product->images]);
    }

    public function store(Request $request, Store $store, Product $product): JsonResponse
    {
        $data = $request->validate([
            'url'         => 'required|string',
            'alt_text_ar' => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer',
            'is_primary'  => 'nullable|boolean',
        ]);

        if (!empty($data['is_primary'])) {
            $product->images()->update(['is_primary' => false]);
        }

        $image = $product->images()->create($data);

        return response()->json(['data' => $image], 201);
    }

    public function destroy(Store $store, Product $product, ProductImage $image): JsonResponse
    {
        $image->delete();
        return response()->json(['message' => 'تم حذف الصورة بنجاح']);
    }
}
