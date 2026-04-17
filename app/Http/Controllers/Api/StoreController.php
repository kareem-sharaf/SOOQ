<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'storeName'           => 'required|string|max:255',
            'slug'                => 'required|string|max:255|unique:stores,slug|regex:/^[a-z0-9-]+$/',
            'storeCategory'       => 'required|string',
            'primaryCurrencyCode' => 'required|string|in:SYP,USD,EUR,TRY',
            'themeCode'           => 'nullable|string',
        ]);

        $store = Store::create([
            'user_id'               => $request->user()->id,
            'store_name'            => $data['storeName'],
            'slug'                  => $data['slug'],
            'store_category'        => $data['storeCategory'],
            'primary_currency_code' => $data['primaryCurrencyCode'],
            'theme_code'            => $data['themeCode'] ?? 'DEFAULT',
        ]);

        return response()->json([
            'message' => 'تم إنشاء المتجر بنجاح',
            'data'    => $store,
        ], 201);
    }

    public function index(Request $request): JsonResponse
    {
        $stores = $request->user()->stores;

        return response()->json([
            'data' => $stores,
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $store = Store::where('slug', $slug)->firstOrFail();

        return response()->json([
            'data' => $store,
        ]);
    }
}
