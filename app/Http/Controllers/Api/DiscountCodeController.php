<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiscountCodeController extends Controller
{
    public function index(Store $store): JsonResponse
    {
        return response()->json(['data' => $store->discountCodes]);
    }

    public function store(Request $request, Store $store): JsonResponse
    {
        $data = $request->validate([
            'code'             => 'required|string|max:50',
            'type'             => 'required|in:PERCENTAGE,FIXED,FREE_SHIPPING',
            'value'            => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit'      => 'nullable|integer|min:1',
            'starts_at'        => 'nullable|date',
            'expires_at'       => 'nullable|date|after:starts_at',
            'is_active'        => 'nullable|boolean',
        ]);

        $data['store_id'] = $store->id;
        $discount = DiscountCode::create($data);

        return response()->json(['data' => $discount], 201);
    }

    public function update(Request $request, Store $store, DiscountCode $discount): JsonResponse
    {
        $data = $request->validate([
            'code'             => 'sometimes|string|max:50',
            'type'             => 'sometimes|in:PERCENTAGE,FIXED,FREE_SHIPPING',
            'value'            => 'sometimes|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit'      => 'nullable|integer|min:1',
            'starts_at'        => 'nullable|date',
            'expires_at'       => 'nullable|date',
            'is_active'        => 'nullable|boolean',
        ]);

        $discount->update($data);

        return response()->json(['data' => $discount]);
    }

    public function destroy(Store $store, DiscountCode $discount): JsonResponse
    {
        $discount->delete();
        return response()->json(['message' => 'تم حذف كود الخصم بنجاح']);
    }
}
