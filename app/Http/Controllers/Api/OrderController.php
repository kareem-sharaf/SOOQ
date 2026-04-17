<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request, Store $store): JsonResponse
    {
        $query = $store->orders()->with(['customer', 'items', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate($request->integer('per_page', 15));

        return response()->json($orders);
    }

    public function store(Request $request, Store $store): JsonResponse
    {
        $data = $request->validate([
            'customer_id'      => 'nullable|exists:customers,id',
            'customer_name'    => 'nullable|string|max:255',
            'customer_phone'   => 'nullable|string|max:20',
            'payment_method'   => 'required|in:COD,ONLINE',
            'shipping_address' => 'required|array',
            'shipping_address.governorate' => 'required|string',
            'notes_customer'   => 'nullable|string',
            'discount_code'    => 'nullable|string',
            'items'            => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        // Calculate totals
        $subtotal = 0;
        $orderItems = [];

        foreach ($data['items'] as $item) {
            $product = $store->products()->findOrFail($item['product_id']);
            $variant = isset($item['variant_id']) ? $product->variants()->find($item['variant_id']) : null;

            $unitPrice = $variant ? $variant->price : $product->base_price;
            $totalPrice = $unitPrice * $item['quantity'];
            $subtotal += $totalPrice;

            $orderItems[] = [
                'product_id'    => $product->id,
                'variant_id'    => $variant?->id,
                'product_title' => $product->title_ar,
                'variant_name'  => $variant?->name_ar,
                'quantity'      => $item['quantity'],
                'unit_price'    => $unitPrice,
                'total_price'   => $totalPrice,
            ];
        }

        // Shipping cost from zone
        $shippingCost = 0;
        $governorate = $data['shipping_address']['governorate'] ?? '';
        $zone = $store->shippingZones()->where('is_active', true)->get()
            ->first(fn ($z) => in_array($governorate, $z->governorates));
        if ($zone) {
            $shippingCost = ($zone->free_above && $subtotal >= $zone->free_above) ? 0 : $zone->rate;
        }

        // Discount
        $discountAmount = 0;
        if (!empty($data['discount_code'])) {
            $discount = $store->discountCodes()
                ->where('code', $data['discount_code'])
                ->where('is_active', true)
                ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
                ->first();

            if ($discount) {
                if ($discount->type === 'PERCENTAGE') {
                    $discountAmount = $subtotal * ($discount->value / 100);
                } elseif ($discount->type === 'FIXED') {
                    $discountAmount = min($discount->value, $subtotal);
                } elseif ($discount->type === 'FREE_SHIPPING') {
                    $shippingCost = 0;
                }
                $discount->increment('used_count');
            }
        }

        $total = $subtotal + $shippingCost - $discountAmount;

        $order = Order::create([
            'store_id'         => $store->id,
            'customer_id'      => $data['customer_id'] ?? null,
            'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
            'status'           => 'PENDING',
            'payment_status'   => 'UNPAID',
            'payment_method'   => $data['payment_method'],
            'subtotal'         => $subtotal,
            'shipping_cost'    => $shippingCost,
            'discount_amount'  => $discountAmount,
            'tax_amount'       => 0,
            'total'            => $total,
            'shipping_address' => $data['shipping_address'],
            'notes_customer'   => $data['notes_customer'] ?? null,
        ]);

        foreach ($orderItems as $item) {
            $order->items()->create($item);
        }

        // Create payment record
        Payment::create([
            'order_id' => $order->id,
            'store_id' => $store->id,
            'method'   => $data['payment_method'] === 'COD' ? 'COD' : 'PAYMERA',
            'status'   => 'PENDING',
            'amount'   => $total,
            'currency' => $store->primary_currency_code,
        ]);

        // Create shipment
        Shipment::create([
            'order_id' => $order->id,
            'store_id' => $store->id,
            'status'   => 'PENDING',
            'cod_amount' => $data['payment_method'] === 'COD' ? $total : null,
        ]);

        return response()->json(['data' => $order->load(['items', 'payment', 'shipment', 'customer'])], 201);
    }

    public function show(Store $store, Order $order): JsonResponse
    {
        $order->load(['items.product', 'customer', 'payment', 'shipment.driver']);
        return response()->json(['data' => $order]);
    }

    public function updateStatus(Request $request, Store $store, Order $order): JsonResponse
    {
        $data = $request->validate([
            'status' => 'required|in:PENDING,CONFIRMED,PROCESSING,SHIPPED,DELIVERED,CANCELLED',
        ]);

        $order->update(['status' => $data['status']]);

        if ($data['status'] === 'CANCELLED') {
            $order->update(['payment_status' => 'FAILED']);
            $order->payment?->update(['status' => 'FAILED']);
        }

        if ($data['status'] === 'DELIVERED' && $order->payment_method === 'COD') {
            $order->update(['payment_status' => 'PAID']);
            $order->payment?->update(['status' => 'COMPLETED', 'paid_at' => now()]);
            $order->shipment?->update(['cod_collected' => true]);
        }

        return response()->json(['data' => $order->load(['items', 'payment', 'shipment'])]);
    }

    public function destroy(Store $store, Order $order): JsonResponse
    {
        $order->delete();
        return response()->json(['message' => 'تم حذف الطلب بنجاح']);
    }
}
