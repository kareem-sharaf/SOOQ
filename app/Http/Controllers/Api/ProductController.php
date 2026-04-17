<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request, Store $store): JsonResponse
    {
        $query = $store->products()->with(['category', 'images', 'variants', 'tags']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($q) => $q->where('title_ar', 'like', "%{$search}%")->orWhere('title_en', 'like', "%{$search}%"));
        }

        $products = $query->latest()->paginate($request->integer('per_page', 15));

        return response()->json($products);
    }

    public function store(Request $request, Store $store): JsonResponse
    {
        $data = $request->validate([
            'title_ar'         => 'required|string|max:255',
            'title_en'         => 'nullable|string|max:255',
            'description_ar'   => 'nullable|string',
            'description_en'   => 'nullable|string',
            'slug'             => 'nullable|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'base_price'       => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'currency_code'    => 'nullable|string|max:3',
            'status'           => 'nullable|in:DRAFT,ACTIVE,ARCHIVED',
            'variants'         => 'nullable|array',
            'variants.*.sku'       => 'required_with:variants|string',
            'variants.*.name_ar'   => 'required_with:variants|string',
            'variants.*.price'     => 'required_with:variants|numeric|min:0',
            'variants.*.stock_qty' => 'nullable|integer|min:0',
            'images'           => 'nullable|array',
            'images.*.url'         => 'required_with:images|string',
            'images.*.alt_text_ar' => 'nullable|string',
            'images.*.is_primary'  => 'nullable|boolean',
            'tag_ids'          => 'nullable|array',
            'tag_ids.*'        => 'exists:product_tags,id',
        ]);

        $data['store_id'] = $store->id;
        $data['slug'] = $data['slug'] ?? Str::slug($data['title_en'] ?? $data['title_ar']) . '-' . Str::random(4);

        $product = Product::create(collect($data)->except(['variants', 'images', 'tag_ids'])->toArray());

        if (!empty($data['variants'])) {
            foreach ($data['variants'] as $v) {
                $product->variants()->create($v);
            }
        }

        if (!empty($data['images'])) {
            foreach ($data['images'] as $i => $img) {
                $product->images()->create(array_merge($img, ['sort_order' => $i]));
            }
        }

        if (!empty($data['tag_ids'])) {
            $product->tags()->sync($data['tag_ids']);
        }

        return response()->json(['data' => $product->load(['variants', 'images', 'tags', 'category'])], 201);
    }

    public function show(Store $store, Product $product): JsonResponse
    {
        $product->load(['category', 'variants', 'images', 'tags']);
        return response()->json(['data' => $product]);
    }

    public function update(Request $request, Store $store, Product $product): JsonResponse
    {
        $data = $request->validate([
            'title_ar'         => 'sometimes|string|max:255',
            'title_en'         => 'nullable|string|max:255',
            'description_ar'   => 'nullable|string',
            'description_en'   => 'nullable|string',
            'slug'             => 'nullable|string|max:255',
            'category_id'      => 'nullable|exists:categories,id',
            'base_price'       => 'sometimes|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'currency_code'    => 'nullable|string|max:3',
            'status'           => 'nullable|in:DRAFT,ACTIVE,ARCHIVED',
            'tag_ids'          => 'nullable|array',
            'tag_ids.*'        => 'exists:product_tags,id',
        ]);

        $product->update(collect($data)->except('tag_ids')->toArray());

        if (array_key_exists('tag_ids', $data)) {
            $product->tags()->sync($data['tag_ids'] ?? []);
        }

        return response()->json(['data' => $product->load(['variants', 'images', 'tags', 'category'])]);
    }

    public function destroy(Store $store, Product $product): JsonResponse
    {
        $product->delete();
        return response()->json(['message' => 'تم حذف المنتج بنجاح']);
    }
}
