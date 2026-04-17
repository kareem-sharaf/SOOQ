<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request, Store $store): JsonResponse
    {
        $query = $store->customers()->withCount('orders');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%"));
        }

        $customers = $query->latest()->paginate($request->integer('per_page', 15));

        return response()->json($customers);
    }

    public function store(Request $request, Store $store): JsonResponse
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $data['store_id'] = $store->id;
        $customer = Customer::create($data);

        return response()->json(['data' => $customer], 201);
    }

    public function show(Store $store, Customer $customer): JsonResponse
    {
        $customer->load(['addresses', 'orders'])->loadCount('orders');
        return response()->json(['data' => $customer]);
    }

    public function update(Request $request, Store $store, Customer $customer): JsonResponse
    {
        $data = $request->validate([
            'name'  => 'sometimes|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $customer->update($data);

        return response()->json(['data' => $customer]);
    }

    public function destroy(Store $store, Customer $customer): JsonResponse
    {
        $customer->delete();
        return response()->json(['message' => 'تم حذف العميل بنجاح']);
    }
}
