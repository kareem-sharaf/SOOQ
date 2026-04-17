<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Store $store, Customer $customer): JsonResponse
    {
        return response()->json(['data' => $customer->addresses]);
    }

    public function store(Request $request, Store $store, Customer $customer): JsonResponse
    {
        $data = $request->validate([
            'governorate' => 'required|string|max:255',
            'city'        => 'nullable|string|max:255',
            'street'      => 'nullable|string|max:255',
            'building'    => 'nullable|string|max:255',
            'floor'       => 'nullable|string|max:50',
            'notes'       => 'nullable|string',
            'is_default'  => 'nullable|boolean',
        ]);

        if (!empty($data['is_default'])) {
            $customer->addresses()->update(['is_default' => false]);
        }

        $address = $customer->addresses()->create($data);

        return response()->json(['data' => $address], 201);
    }

    public function update(Request $request, Store $store, Customer $customer, Address $address): JsonResponse
    {
        $data = $request->validate([
            'governorate' => 'sometimes|string|max:255',
            'city'        => 'nullable|string|max:255',
            'street'      => 'nullable|string|max:255',
            'building'    => 'nullable|string|max:255',
            'floor'       => 'nullable|string|max:50',
            'notes'       => 'nullable|string',
            'is_default'  => 'nullable|boolean',
        ]);

        if (!empty($data['is_default'])) {
            $customer->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($data);

        return response()->json(['data' => $address]);
    }

    public function destroy(Store $store, Customer $customer, Address $address): JsonResponse
    {
        $address->delete();
        return response()->json(['message' => 'تم حذف العنوان بنجاح']);
    }
}
