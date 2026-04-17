<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShippingZone;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShippingZoneController extends Controller
{
    public function index(Store $store): JsonResponse
    {
        return response()->json(['data' => $store->shippingZones]);
    }

    public function store(Request $request, Store $store): JsonResponse
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'governorates'   => 'required|array|min:1',
            'governorates.*' => 'string',
            'rate'           => 'required|numeric|min:0',
            'free_above'     => 'nullable|numeric|min:0',
            'estimated_days' => 'nullable|integer|min:0',
            'is_active'      => 'nullable|boolean',
        ]);

        $data['store_id'] = $store->id;
        $zone = ShippingZone::create($data);

        return response()->json(['data' => $zone], 201);
    }

    public function update(Request $request, Store $store, ShippingZone $zone): JsonResponse
    {
        $data = $request->validate([
            'name'           => 'sometimes|string|max:255',
            'governorates'   => 'sometimes|array|min:1',
            'governorates.*' => 'string',
            'rate'           => 'sometimes|numeric|min:0',
            'free_above'     => 'nullable|numeric|min:0',
            'estimated_days' => 'nullable|integer|min:0',
            'is_active'      => 'nullable|boolean',
        ]);

        $zone->update($data);

        return response()->json(['data' => $zone]);
    }

    public function destroy(Store $store, ShippingZone $zone): JsonResponse
    {
        $zone->delete();
        return response()->json(['message' => 'تم حذف منطقة الشحن بنجاح']);
    }
}
