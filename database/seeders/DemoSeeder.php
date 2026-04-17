<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ShippingZone;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // ===== 1. Demo Merchant =====
        $merchant = User::firstOrCreate(
            ['email' => 'merchant@sooq.test'],
            ['name' => 'كريم التاجر', 'password' => Hash::make('password123')]
        );

        // ===== 2. Demo Store =====
        $store = Store::firstOrCreate(
            ['slug' => 'jasmine-store'],
            [
                'user_id'               => $merchant->id,
                'store_name'            => 'متجر الياسمين',
                'store_category'        => 'FASHION',
                'primary_currency_code' => 'SYP',
                'theme_code'            => 'DEFAULT',
                'status'                => 'active',
            ]
        );

        // ===== 3. Categories =====
        $categories = [
            ['name_ar' => 'ملابس رجالية', 'name_en' => 'Men Clothing',   'slug' => 'men-clothing',   'sort_order' => 1],
            ['name_ar' => 'ملابس نسائية', 'name_en' => 'Women Clothing', 'slug' => 'women-clothing', 'sort_order' => 2],
            ['name_ar' => 'أحذية',       'name_en' => 'Shoes',          'slug' => 'shoes',          'sort_order' => 3],
            ['name_ar' => 'إكسسوارات',   'name_en' => 'Accessories',    'slug' => 'accessories',    'sort_order' => 4],
            ['name_ar' => 'حقائب',       'name_en' => 'Bags',           'slug' => 'bags',           'sort_order' => 5],
        ];

        $catModels = [];
        foreach ($categories as $cat) {
            $catModels[$cat['slug']] = Category::firstOrCreate(
                ['store_id' => $store->id, 'slug' => $cat['slug']],
                array_merge($cat, ['store_id' => $store->id])
            );
        }

        // ===== 4. Products =====
        $products = [
            [
                'category' => 'men-clothing',
                'title_ar' => 'قميص صيفي قطني',
                'title_en' => 'Cotton Summer Shirt',
                'description_ar' => 'قميص صيفي مريح مصنوع من القطن الطبيعي 100%، مثالي للأجواء الحارة',
                'slug' => 'cotton-summer-shirt',
                'base_price' => 150000,
                'compare_at_price' => 200000,
                'images' => ['https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=600&h=600&fit=crop', 'https://images.unsplash.com/photo-1598033129183-c4f50c736c10?w=600&h=600&fit=crop'],
                'variants' => [
                    ['name_ar' => 'S - أبيض', 'sku' => 'CSS-S-W', 'price' => 150000, 'stock_qty' => 25],
                    ['name_ar' => 'M - أبيض', 'sku' => 'CSS-M-W', 'price' => 150000, 'stock_qty' => 30],
                    ['name_ar' => 'L - أبيض', 'sku' => 'CSS-L-W', 'price' => 155000, 'stock_qty' => 20],
                ],
            ],
            [
                'category' => 'men-clothing',
                'title_ar' => 'بنطلون جينز كلاسيكي',
                'title_en' => 'Classic Jeans',
                'description_ar' => 'بنطلون جينز كلاسيكي بقصة مستقيمة، مناسب لجميع المناسبات',
                'slug' => 'classic-jeans',
                'base_price' => 280000,
                'images' => ['https://images.unsplash.com/photo-1542272604-787c3835535d?w=600&h=600&fit=crop', 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?w=600&h=600&fit=crop'],
                'variants' => [
                    ['name_ar' => '32 - أزرق', 'sku' => 'CJ-32-B', 'price' => 280000, 'stock_qty' => 15],
                    ['name_ar' => '34 - أزرق', 'sku' => 'CJ-34-B', 'price' => 280000, 'stock_qty' => 20],
                ],
            ],
            [
                'category' => 'women-clothing',
                'title_ar' => 'فستان سهرة أنيق',
                'title_en' => 'Elegant Evening Dress',
                'description_ar' => 'فستان سهرة أنيق بتصميم عصري، مناسب للمناسبات الخاصة',
                'slug' => 'elegant-evening-dress',
                'base_price' => 450000,
                'compare_at_price' => 550000,
                'images' => ['https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=600&h=600&fit=crop', 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=600&h=600&fit=crop'],
                'variants' => [
                    ['name_ar' => 'S - أسود', 'sku' => 'EED-S-BK', 'price' => 450000, 'stock_qty' => 10],
                    ['name_ar' => 'M - أحمر', 'sku' => 'EED-M-R',  'price' => 460000, 'stock_qty' => 8],
                ],
            ],
            [
                'category' => 'women-clothing',
                'title_ar' => 'بلوزة حرير',
                'title_en' => 'Silk Blouse',
                'description_ar' => 'بلوزة حرير ناعمة بألوان هادئة، مثالية للعمل والمناسبات',
                'slug' => 'silk-blouse',
                'base_price' => 180000,
                'images' => ['https://images.unsplash.com/photo-1564257631407-4deb1f99d992?w=600&h=600&fit=crop'],
                'variants' => [
                    ['name_ar' => 'M - بيج', 'sku' => 'SB-M-BG', 'price' => 180000, 'stock_qty' => 18],
                    ['name_ar' => 'L - بيج', 'sku' => 'SB-L-BG', 'price' => 180000, 'stock_qty' => 12],
                ],
            ],
            [
                'category' => 'shoes',
                'title_ar' => 'حذاء رياضي خفيف',
                'title_en' => 'Lightweight Sneakers',
                'description_ar' => 'حذاء رياضي خفيف الوزن مع نعل مريح، مثالي للمشي اليومي',
                'slug' => 'lightweight-sneakers',
                'base_price' => 320000,
                'compare_at_price' => 400000,
                'images' => ['https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&h=600&fit=crop', 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=600&h=600&fit=crop'],
                'variants' => [
                    ['name_ar' => '42 - رمادي', 'sku' => 'LS-42-G', 'price' => 320000, 'stock_qty' => 22],
                    ['name_ar' => '43 - رمادي', 'sku' => 'LS-43-G', 'price' => 320000, 'stock_qty' => 18],
                    ['name_ar' => '44 - أسود',  'sku' => 'LS-44-B', 'price' => 330000, 'stock_qty' => 14],
                ],
            ],
            [
                'category' => 'shoes',
                'title_ar' => 'صندل جلد طبيعي',
                'title_en' => 'Natural Leather Sandals',
                'description_ar' => 'صندل من الجلد الطبيعي بتصميم كلاسيكي مريح',
                'slug' => 'leather-sandals',
                'base_price' => 220000,
                'images' => ['https://images.unsplash.com/photo-1603487742131-4160ec999306?w=600&h=600&fit=crop'],
                'variants' => [
                    ['name_ar' => '41 - بني', 'sku' => 'NLS-41-BR', 'price' => 220000, 'stock_qty' => 16],
                    ['name_ar' => '42 - بني', 'sku' => 'NLS-42-BR', 'price' => 220000, 'stock_qty' => 20],
                ],
            ],
            [
                'category' => 'accessories',
                'title_ar' => 'ساعة يد كلاسيكية',
                'title_en' => 'Classic Wristwatch',
                'description_ar' => 'ساعة يد أنيقة بتصميم كلاسيكي وسوار جلدي',
                'slug' => 'classic-wristwatch',
                'base_price' => 500000,
                'images' => ['https://images.unsplash.com/photo-1524592094714-0f0654e20314?w=600&h=600&fit=crop', 'https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?w=600&h=600&fit=crop'],
                'variants' => [
                    ['name_ar' => 'ذهبي', 'sku' => 'CW-GOLD', 'price' => 500000, 'stock_qty' => 8],
                    ['name_ar' => 'فضي',  'sku' => 'CW-SILV', 'price' => 480000, 'stock_qty' => 12],
                ],
            ],
            [
                'category' => 'accessories',
                'title_ar' => 'نظارة شمسية',
                'title_en' => 'Sunglasses',
                'description_ar' => 'نظارة شمسية عصرية مع حماية UV400',
                'slug' => 'sunglasses',
                'base_price' => 120000,
                'images' => ['https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=600&h=600&fit=crop', 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=600&h=600&fit=crop'],
                'variants' => [
                    ['name_ar' => 'أسود',  'sku' => 'SG-BK', 'price' => 120000, 'stock_qty' => 30],
                    ['name_ar' => 'بني',   'sku' => 'SG-BR', 'price' => 120000, 'stock_qty' => 25],
                ],
            ],
            [
                'category' => 'bags',
                'title_ar' => 'حقيبة ظهر عملية',
                'title_en' => 'Practical Backpack',
                'description_ar' => 'حقيبة ظهر عملية مقاومة للماء مع جيب للابتوب',
                'slug' => 'practical-backpack',
                'base_price' => 250000,
                'compare_at_price' => 300000,
                'images' => ['https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&h=600&fit=crop', 'https://images.unsplash.com/photo-1581605405669-fcdf81165afa?w=600&h=600&fit=crop'],
                'variants' => [
                    ['name_ar' => 'أسود', 'sku' => 'PB-BK', 'price' => 250000, 'stock_qty' => 15],
                    ['name_ar' => 'كحلي', 'sku' => 'PB-NV', 'price' => 250000, 'stock_qty' => 10],
                ],
            ],
            [
                'category' => 'bags',
                'title_ar' => 'حقيبة يد نسائية',
                'title_en' => 'Women Handbag',
                'description_ar' => 'حقيبة يد نسائية أنيقة من الجلد الصناعي عالي الجودة',
                'slug' => 'women-handbag',
                'base_price' => 350000,
                'images' => ['https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=600&h=600&fit=crop', 'https://images.unsplash.com/photo-1566150905458-1bf1fc113f0d?w=600&h=600&fit=crop'],
                'variants' => [
                    ['name_ar' => 'أسود',  'sku' => 'WH-BK', 'price' => 350000, 'stock_qty' => 12],
                    ['name_ar' => 'أحمر',  'sku' => 'WH-RD', 'price' => 360000, 'stock_qty' => 8],
                ],
            ],
        ];

        foreach ($products as $pData) {
            $product = Product::firstOrCreate(
                ['store_id' => $store->id, 'slug' => $pData['slug']],
                [
                    'store_id'         => $store->id,
                    'category_id'      => $catModels[$pData['category']]->id,
                    'title_ar'         => $pData['title_ar'],
                    'title_en'         => $pData['title_en'] ?? null,
                    'description_ar'   => $pData['description_ar'] ?? null,
                    'slug'             => $pData['slug'],
                    'base_price'       => $pData['base_price'],
                    'compare_at_price' => $pData['compare_at_price'] ?? null,
                    'currency_code'    => 'SYP',
                    'status'           => 'ACTIVE',
                ]
            );

            // Variants
            foreach ($pData['variants'] as $vData) {
                ProductVariant::firstOrCreate(
                    ['sku' => $vData['sku']],
                    array_merge($vData, ['product_id' => $product->id])
                );
            }

            // Images
            foreach (($pData['images'] ?? []) as $i => $url) {
                ProductImage::firstOrCreate(
                    ['product_id' => $product->id, 'url' => $url],
                    [
                        'product_id'  => $product->id,
                        'url'         => $url,
                        'alt_text_ar' => $pData['title_ar'],
                        'sort_order'  => $i,
                        'is_primary'  => $i === 0,
                    ]
                );
            }
        }

        // ===== 5. Shipping Zones (14 Syrian Governorates) =====
        $zones = [
            ['name' => 'دمشق',        'governorates' => ['دمشق'],          'rate' => 5000,  'estimated_days' => 1],
            ['name' => 'ريف دمشق',    'governorates' => ['ريف دمشق'],      'rate' => 7000,  'estimated_days' => 2],
            ['name' => 'حلب',         'governorates' => ['حلب'],           'rate' => 10000, 'estimated_days' => 3],
            ['name' => 'حمص',         'governorates' => ['حمص'],           'rate' => 8000,  'estimated_days' => 2],
            ['name' => 'حماة',        'governorates' => ['حماة'],          'rate' => 9000,  'estimated_days' => 2],
            ['name' => 'اللاذقية',    'governorates' => ['اللاذقية'],      'rate' => 9000,  'estimated_days' => 2],
            ['name' => 'طرطوس',       'governorates' => ['طرطوس'],         'rate' => 9000,  'estimated_days' => 2],
            ['name' => 'إدلب',        'governorates' => ['إدلب'],          'rate' => 12000, 'estimated_days' => 4],
            ['name' => 'دير الزور',   'governorates' => ['دير الزور'],     'rate' => 15000, 'estimated_days' => 4],
            ['name' => 'الحسكة',      'governorates' => ['الحسكة'],        'rate' => 15000, 'estimated_days' => 4],
            ['name' => 'الرقة',       'governorates' => ['الرقة'],         'rate' => 15000, 'estimated_days' => 4],
            ['name' => 'السويداء',    'governorates' => ['السويداء'],      'rate' => 8000,  'estimated_days' => 2],
            ['name' => 'درعا',        'governorates' => ['درعا'],          'rate' => 8000,  'estimated_days' => 2],
            ['name' => 'القنيطرة',    'governorates' => ['القنيطرة'],      'rate' => 10000, 'estimated_days' => 3],
        ];

        foreach ($zones as $zone) {
            ShippingZone::firstOrCreate(
                ['store_id' => $store->id, 'name' => $zone['name']],
                array_merge($zone, ['store_id' => $store->id])
            );
        }

        // ===== 6. Templates =====
        $this->call(TemplateSeeder::class);

        $this->command->info('Demo data seeded successfully!');
        $this->command->info("Merchant login: merchant@sooq.test / password123");
        $this->command->info("Store: {$store->store_name} ({$store->slug})");
    }
}
