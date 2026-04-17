<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Store $store): JsonResponse
    {
        $drivers = $store->drivers()->withCount('shipments')->get();
        return response()->json(['data' => $drivers]);
    }

    public function store(Request $request, Store $store): JsonResponse
    {
        $data = $request->validate([
            'name'                   => 'required|string|max:255',
            'phone'                  => 'required|string|max:20',
            'governorates_coverage'  => 'nullable|array',
            'governorates_coverage.*' => 'string',
            'is_active'              => 'nullable|boolean',
        ]);

        $data['store_id'] = $store->id;
        $data['user_id'] = $request->user()->id;
        $driver = Driver::create($data);

        return response()->json(['data' => $driver], 201);
    }

    public function show(Store $store, Driver $driver): JsonResponse
    {
        $driver->loadCount('shipments');
        return response()->json(['data' => $driver]);
    }

    public function update(Request $request, Store $store, Driver $driver): JsonResponse
    {
        $data = $request->validate([
            'name'                   => 'sometimes|string|max:255',
            'phone'                  => 'sometimes|string|max:20',
            'governorates_coverage'  => 'nullable|array',
            'governorates_coverage.*' => 'string',
            'is_active'              => 'nullable|boolean',
        ]);

        $driver->update($data);

        return response()->json(['data' => $driver]);
    }

    public function destroy(Store $store, Driver $driver): JsonResponse
    {
        $driver->delete();
        return response()->json(['message' => 'تم حذف السائق بنجاح']);
    }
}
