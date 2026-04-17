<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index(Store $store, Product $product): JsonResponse
    {
        return response()->json(['data' => $product->variants]);
    }

    public function store(Request $request, Store $store, Product $product): JsonResponse
    {
        $data = $request->validate([
            'sku'                 => 'required|string|unique:product_variants,sku',
            'name_ar'             => 'required|string|max:255',
            'price'               => 'required|numeric|min:0',
            'compare_at_price'    => 'nullable|numeric|min:0',
            'stock_qty'           => 'nullable|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'is_active'           => 'nullable|boolean',
        ]);

        $variant = $product->variants()->create($data);

        return response()->json(['data' => $variant], 201);
    }

    public function update(Request $request, Store $store, Product $product, ProductVariant $variant): JsonResponse
    {
        $data = $request->validate([
            'sku'                 => 'sometimes|string|unique:product_variants,sku,' . $variant->id,
            'name_ar'             => 'sometimes|string|max:255',
            'price'               => 'sometimes|numeric|min:0',
            'compare_at_price'    => 'nullable|numeric|min:0',
            'stock_qty'           => 'nullable|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'is_active'           => 'nullable|boolean',
        ]);

        $variant->update($data);

        return response()->json(['data' => $variant]);
    }

    public function destroy(Store $store, Product $product, ProductVariant $variant): JsonResponse
    {
        $variant->delete();
        return response()->json(['message' => 'تم حذف المتغير بنجاح']);
    }
}
