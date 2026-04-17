<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipment;
use App\Models\Store;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $store = Store::where('slug', 'jasmine-store')->first();
        if (!$store) return;

        $products = Product::where('store_id', $store->id)->with('variants')->get();
        if ($products->isEmpty()) return;

        // Create demo customers
        $customers = [
            Customer::firstOrCreate(['store_id' => $store->id, 'phone' => '+963912000001'], ['store_id' => $store->id, 'name' => 'أحمد محمد', 'email' => 'ahmad@test.com', 'phone' => '+963912000001']),
            Customer::firstOrCreate(['store_id' => $store->id, 'phone' => '+963912000002'], ['store_id' => $store->id, 'name' => 'فاطمة حسن', 'email' => 'fatima@test.com', 'phone' => '+963912000002']),
            Customer::firstOrCreate(['store_id' => $store->id, 'phone' => '+963912000003'], ['store_id' => $store->id, 'name' => 'محمد عمر', 'email' => 'mohamad@test.com', 'phone' => '+963912000003']),
            Customer::firstOrCreate(['store_id' => $store->id, 'phone' => '+963912000004'], ['store_id' => $store->id, 'name' => 'ريم أحمد', 'email' => 'reem@test.com', 'phone' => '+963912000004']),
            Customer::firstOrCreate(['store_id' => $store->id, 'phone' => '+963912000005'], ['store_id' => $store->id, 'name' => 'عمر خالد', 'email' => 'omar@test.com', 'phone' => '+963912000005']),
        ];

        $governorates = ['دمشق', 'حلب', 'حمص', 'اللاذقية', 'ريف دمشق'];
        $shippingRates = ['دمشق' => 5000, 'حلب' => 10000, 'حمص' => 8000, 'اللاذقية' => 9000, 'ريف دمشق' => 7000];

        $orders = [
            ['status' => 'DELIVERED',   'payment_status' => 'PAID',   'payment_method' => 'COD',    'days_ago' => 7],
            ['status' => 'DELIVERED',   'payment_status' => 'PAID',   'payment_method' => 'ONLINE', 'days_ago' => 6],
            ['status' => 'SHIPPED',     'payment_status' => 'PAID',   'payment_method' => 'ONLINE', 'days_ago' => 4],
            ['status' => 'PROCESSING',  'payment_status' => 'PAID',   'payment_method' => 'COD',    'days_ago' => 3],
            ['status' => 'CONFIRMED',   'payment_status' => 'UNPAID', 'payment_method' => 'COD',    'days_ago' => 2],
            ['status' => 'PENDING',     'payment_status' => 'UNPAID', 'payment_method' => 'COD',    'days_ago' => 1],
            ['status' => 'DELIVERED',   'payment_status' => 'PAID',   'payment_method' => 'COD',    'days_ago' => 5],
            ['status' => 'CANCELLED',   'payment_status' => 'FAILED', 'payment_method' => 'COD',    'days_ago' => 3],
        ];

        foreach ($orders as $i => $orderData) {
            $customer = $customers[$i % count($customers)];
            $gov = $governorates[$i % count($governorates)];
            $shippingCost = $shippingRates[$gov] ?? 5000;

            // Pick 1-3 random products
            $orderProducts = $products->random(rand(1, 3));
            $subtotal = 0;
            $items = [];

            foreach ($orderProducts as $product) {
                $variant = $product->variants->first();
                $qty = rand(1, 3);
                $price = $variant ? $variant->price : $product->base_price;
                $lineTotal = $price * $qty;
                $subtotal += $lineTotal;

                $items[] = [
                    'product_id'    => $product->id,
                    'variant_id'    => $variant?->id,
                    'product_title' => $product->title_ar,
                    'variant_name'  => $variant?->name_ar,
                    'quantity'      => $qty,
                    'unit_price'    => $price,
                    'total_price'   => $lineTotal,
                ];
            }

            $total = $subtotal + $shippingCost;
            $orderNumber = 'ORD-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            $createdAt = now()->subDays($orderData['days_ago']);

            $order = Order::firstOrCreate(
                ['order_number' => $orderNumber],
                [
                    'store_id'         => $store->id,
                    'customer_id'      => $customer->id,
                    'order_number'     => $orderNumber,
                    'status'           => $orderData['status'],
                    'payment_status'   => $orderData['payment_status'],
                    'payment_method'   => $orderData['payment_method'],
                    'subtotal'         => $subtotal,
                    'shipping_cost'    => $shippingCost,
                    'discount_amount'  => 0,
                    'tax_amount'       => 0,
                    'total'            => $total,
                    'shipping_address' => ['governorate' => $gov, 'city' => $gov, 'street' => 'شارع ' . ($i + 1)],
                    'created_at'       => $createdAt,
                    'updated_at'       => $createdAt,
                ]
            );

            foreach ($items as $item) {
                OrderItem::firstOrCreate(
                    ['order_id' => $order->id, 'product_id' => $item['product_id']],
                    array_merge($item, ['order_id' => $order->id])
                );
            }

            // Payment
            Payment::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'order_id'  => $order->id,
                    'store_id'  => $store->id,
                    'method'    => $orderData['payment_method'] === 'COD' ? 'COD' : 'PAYMERA',
                    'status'    => $orderData['payment_status'] === 'PAID' ? 'COMPLETED' : ($orderData['payment_status'] === 'FAILED' ? 'FAILED' : 'PENDING'),
                    'amount'    => $total,
                    'currency'  => 'SYP',
                    'paid_at'   => $orderData['payment_status'] === 'PAID' ? $createdAt : null,
                ]
            );

            // Shipment
            $shipmentStatus = match($orderData['status']) {
                'DELIVERED'  => 'DELIVERED',
                'SHIPPED'    => 'IN_TRANSIT',
                'PROCESSING' => 'PICKED_UP',
                'CANCELLED'  => 'FAILED',
                default      => 'PENDING',
            };

            Shipment::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'order_id'  => $order->id,
                    'store_id'  => $store->id,
                    'status'    => $shipmentStatus,
                    'cod_amount' => $orderData['payment_method'] === 'COD' ? $total : null,
                    'cod_collected' => $orderData['status'] === 'DELIVERED' && $orderData['payment_method'] === 'COD',
                ]
            );
        }

        $this->command->info('8 demo orders seeded with customers, items, payments & shipments!');
    }
}
