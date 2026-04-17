<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index(Request $request, Store $store): JsonResponse
    {
        $query = Shipment::where('store_id', $store->id)->with(['order.customer', 'driver']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('driver_id')) {
            $query->where('driver_id', $request->driver_id);
        }

        $shipments = $query->latest()->paginate($request->integer('per_page', 15));

        return response()->json($shipments);
    }

    public function show(Store $store, Shipment $shipment): JsonResponse
    {
        $shipment->load(['order.customer', 'order.items', 'driver']);
        return response()->json(['data' => $shipment]);
    }

    public function updateStatus(Request $request, Store $store, Shipment $shipment): JsonResponse
    {
        $data = $request->validate([
            'status' => 'required|in:PENDING,PICKED_UP,IN_TRANSIT,OUT_FOR_DELIVERY,DELIVERED,FAILED',
        ]);

        $shipment->update(['status' => $data['status']]);

        if ($data['status'] === 'DELIVERED') {
            $shipment->order?->update(['status' => 'DELIVERED']);
        }

        return response()->json(['data' => $shipment->load(['order', 'driver'])]);
    }

    public function assignDriver(Request $request, Store $store, Shipment $shipment): JsonResponse
    {
        $data = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        $shipment->update(['driver_id' => $data['driver_id']]);

        return response()->json(['data' => $shipment->load('driver')]);
    }
}
