<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            // ==============================
            // 1. Fashion / Clothing
            // ==============================
            [
                'name_ar' => 'أناقة — متجر أزياء',
                'name_en' => 'Elegance — Fashion Store',
                'slug' => 'elegance-fashion',
                'category' => 'FASHION',
                'description_ar' => 'قالب أنيق لمتاجر الملابس والأزياء مع عرض احترافي للمنتجات',
                'description_en' => 'Elegant template for clothing and fashion stores',
                'thumbnail' => 'https://placehold.co/400x300/122640/fff?text=Fashion',
                'sort_order' => 1,
                'store_config' => [
                    'theme' => [
                        'primaryColor' => '#122640',
                        'secondaryColor' => '#BA7B1B',
                        'accentColor' => '#E8D5B7',
                        'fontFamily' => 'Cairo',
                        'borderRadius' => '12px',
                    ],
                    'pages' => [
                        [
                            'id' => 'page-home',
                            'slug' => '/',
                            'sections' => [
                                [
                                    'id' => 'hero',
                                    'style' => ['backgroundColor' => '#122640', 'paddingTop' => '64px', 'paddingBottom' => '64px'],
                                    'blocks' => [
                                        ['id' => 'h1', 'type' => 'heading', 'props' => ['level' => 'h1', 'text' => 'اكتشف أحدث صيحات الموضة', 'align' => 'center'], 'style' => ['fontSize' => '42px', 'fontWeight' => '800', 'color' => '#ffffff']],
                                        ['id' => 'h1-sub', 'type' => 'text', 'props' => ['content' => 'تشكيلة مميزة من الملابس والإكسسوارات بأفضل الأسعار'], 'style' => ['fontSize' => '18px', 'color' => '#E8D5B7', 'textAlign' => 'center', 'marginTop' => '12px']],
                                        ['id' => 'h1-btn', 'type' => 'button', 'props' => ['label' => 'تسوق الآن', 'link' => '/products', 'variant' => 'primary'], 'style' => ['marginTop' => '24px', 'textAlign' => 'center']],
                                    ],
                                ],
                                [
                                    'id' => 'categories',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px'],
                                    'blocks' => [
                                        ['id' => 'cat-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'تسوق حسب الفئة', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'cat-list', 'type' => 'categoryList', 'props' => ['variant' => 'grid', 'showImage' => true, 'columns' => 4], 'style' => []],
                                    ],
                                ],
                                [
                                    'id' => 'featured',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px', 'backgroundColor' => '#FAFAF8'],
                                    'blocks' => [
                                        ['id' => 'feat-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'الأكثر مبيعاً', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'feat-grid', 'type' => 'productGrid', 'props' => ['source' => 'featured', 'columns' => 4, 'limit' => 8], 'style' => []],
                                    ],
                                ],
                                [
                                    'id' => 'new-arrivals',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px'],
                                    'blocks' => [
                                        ['id' => 'new-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'وصل حديثاً', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'new-grid', 'type' => 'productGrid', 'props' => ['source' => 'latest', 'columns' => 3, 'limit' => 6], 'style' => []],
                                    ],
                                ],
                                [
                                    'id' => 'footer-cta',
                                    'style' => ['backgroundColor' => '#BA7B1B', 'paddingTop' => '40px', 'paddingBottom' => '40px'],
                                    'blocks' => [
                                        ['id' => 'cta-text', 'type' => 'heading', 'props' => ['level' => 'h3', 'text' => 'اشترك في نشرتنا واحصل على خصم 10%', 'align' => 'center'], 'style' => ['color' => '#ffffff', 'fontSize' => '24px']],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // ==============================
            // 2. Electronics
            // ==============================
            [
                'name_ar' => 'تقنية — متجر إلكترونيات',
                'name_en' => 'TechZone — Electronics Store',
                'slug' => 'techzone-electronics',
                'category' => 'ELECTRONICS',
                'description_ar' => 'قالب عصري لمتاجر الإلكترونيات والأجهزة الذكية',
                'description_en' => 'Modern template for electronics and gadgets stores',
                'thumbnail' => 'https://placehold.co/400x300/1a1a2e/00d4ff?text=Tech',
                'sort_order' => 2,
                'store_config' => [
                    'theme' => [
                        'primaryColor' => '#1a1a2e',
                        'secondaryColor' => '#00d4ff',
                        'accentColor' => '#e94560',
                        'fontFamily' => 'Cairo',
                        'borderRadius' => '8px',
                    ],
                    'pages' => [
                        [
                            'id' => 'page-home',
                            'slug' => '/',
                            'sections' => [
                                [
                                    'id' => 'hero',
                                    'style' => ['backgroundColor' => '#1a1a2e', 'paddingTop' => '72px', 'paddingBottom' => '72px'],
                                    'blocks' => [
                                        ['id' => 'h1', 'type' => 'heading', 'props' => ['level' => 'h1', 'text' => 'أحدث الأجهزة بين يديك', 'align' => 'center'], 'style' => ['fontSize' => '44px', 'fontWeight' => '800', 'color' => '#ffffff']],
                                        ['id' => 'h1-sub', 'type' => 'text', 'props' => ['content' => 'اكتشف أحدث الهواتف والحواسيب والإكسسوارات التقنية'], 'style' => ['fontSize' => '18px', 'color' => '#00d4ff', 'textAlign' => 'center', 'marginTop' => '12px']],
                                        ['id' => 'h1-btn', 'type' => 'button', 'props' => ['label' => 'استكشف المنتجات', 'link' => '/products', 'variant' => 'primary'], 'style' => ['marginTop' => '28px']],
                                    ],
                                ],
                                [
                                    'id' => 'deals',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px', 'backgroundColor' => '#f0f4f8'],
                                    'blocks' => [
                                        ['id' => 'deals-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'عروض اليوم 🔥', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'deals-grid', 'type' => 'productGrid', 'props' => ['source' => 'featured', 'columns' => 4, 'limit' => 4], 'style' => []],
                                    ],
                                ],
                                [
                                    'id' => 'categories',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px'],
                                    'blocks' => [
                                        ['id' => 'cat-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'الأقسام', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'cat-list', 'type' => 'categoryList', 'props' => ['variant' => 'grid', 'showImage' => true, 'columns' => 3], 'style' => []],
                                    ],
                                ],
                                [
                                    'id' => 'all-products',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px', 'backgroundColor' => '#FAFAFA'],
                                    'blocks' => [
                                        ['id' => 'all-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'جميع المنتجات', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'all-grid', 'type' => 'productGrid', 'props' => ['source' => 'all', 'columns' => 4, 'limit' => 12], 'style' => []],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // ==============================
            // 3. Food / Restaurant
            // ==============================
            [
                'name_ar' => 'مذاق — متجر طعام',
                'name_en' => 'Taste — Food Store',
                'slug' => 'taste-food',
                'category' => 'FOOD',
                'description_ar' => 'قالب شهي لمتاجر المأكولات والمطاعم والحلويات',
                'description_en' => 'Appetizing template for food stores and restaurants',
                'thumbnail' => 'https://placehold.co/400x300/c0392b/fff?text=Food',
                'sort_order' => 3,
                'store_config' => [
                    'theme' => [
                        'primaryColor' => '#c0392b',
                        'secondaryColor' => '#f39c12',
                        'accentColor' => '#27ae60',
                        'fontFamily' => 'Cairo',
                        'borderRadius' => '16px',
                    ],
                    'pages' => [
                        [
                            'id' => 'page-home',
                            'slug' => '/',
                            'sections' => [
                                [
                                    'id' => 'hero',
                                    'style' => ['backgroundColor' => '#c0392b', 'paddingTop' => '64px', 'paddingBottom' => '64px'],
                                    'blocks' => [
                                        ['id' => 'h1', 'type' => 'heading', 'props' => ['level' => 'h1', 'text' => 'أشهى المأكولات إلى باب بيتك 🍕', 'align' => 'center'], 'style' => ['fontSize' => '40px', 'fontWeight' => '800', 'color' => '#ffffff']],
                                        ['id' => 'h1-sub', 'type' => 'text', 'props' => ['content' => 'اطلب الآن واستمتع بأطيب الوجبات الطازجة'], 'style' => ['fontSize' => '18px', 'color' => '#ffeaa7', 'textAlign' => 'center', 'marginTop' => '12px']],
                                        ['id' => 'h1-btn', 'type' => 'button', 'props' => ['label' => 'اطلب الآن', 'link' => '/products', 'variant' => 'primary'], 'style' => ['marginTop' => '24px']],
                                    ],
                                ],
                                [
                                    'id' => 'menu',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px'],
                                    'blocks' => [
                                        ['id' => 'menu-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'قائمة الطعام', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'cat-list', 'type' => 'categoryList', 'props' => ['variant' => 'horizontal-scroll', 'showImage' => true], 'style' => []],
                                    ],
                                ],
                                [
                                    'id' => 'popular',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px', 'backgroundColor' => '#FFF9F0'],
                                    'blocks' => [
                                        ['id' => 'pop-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'الأكثر طلباً 🔥', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'pop-grid', 'type' => 'productGrid', 'props' => ['source' => 'featured', 'columns' => 3, 'limit' => 6], 'style' => []],
                                    ],
                                ],
                                [
                                    'id' => 'delivery',
                                    'style' => ['backgroundColor' => '#27ae60', 'paddingTop' => '40px', 'paddingBottom' => '40px'],
                                    'blocks' => [
                                        ['id' => 'del-text', 'type' => 'heading', 'props' => ['level' => 'h3', 'text' => '🚚 توصيل مجاني للطلبات فوق 100,000 ل.س', 'align' => 'center'], 'style' => ['color' => '#ffffff', 'fontSize' => '22px']],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // ==============================
            // 4. Beauty / Cosmetics
            // ==============================
            [
                'name_ar' => 'جمال — متجر تجميل',
                'name_en' => 'Glow — Beauty Store',
                'slug' => 'glow-beauty',
                'category' => 'BEAUTY',
                'description_ar' => 'قالب راقي لمتاجر مستحضرات التجميل والعناية',
                'description_en' => 'Luxury template for cosmetics and beauty stores',
                'thumbnail' => 'https://placehold.co/400x300/E8B4C8/fff?text=Beauty',
                'sort_order' => 4,
                'store_config' => [
                    'theme' => [
                        'primaryColor' => '#9B2C5E',
                        'secondaryColor' => '#E8B4C8',
                        'accentColor' => '#D4AF37',
                        'fontFamily' => 'Cairo',
                        'borderRadius' => '20px',
                    ],
                    'pages' => [
                        [
                            'id' => 'page-home',
                            'slug' => '/',
                            'sections' => [
                                [
                                    'id' => 'hero',
                                    'style' => ['backgroundColor' => '#FDF2F8', 'paddingTop' => '72px', 'paddingBottom' => '72px'],
                                    'blocks' => [
                                        ['id' => 'h1', 'type' => 'heading', 'props' => ['level' => 'h1', 'text' => 'لأنك تستحقين الأفضل ✨', 'align' => 'center'], 'style' => ['fontSize' => '40px', 'fontWeight' => '800', 'color' => '#9B2C5E']],
                                        ['id' => 'h1-sub', 'type' => 'text', 'props' => ['content' => 'مستحضرات تجميل أصلية وعناية فاخرة بالبشرة والشعر'], 'style' => ['fontSize' => '18px', 'color' => '#666', 'textAlign' => 'center', 'marginTop' => '12px']],
                                        ['id' => 'h1-btn', 'type' => 'button', 'props' => ['label' => 'اكتشفي المنتجات', 'link' => '/products', 'variant' => 'primary'], 'style' => ['marginTop' => '24px']],
                                    ],
                                ],
                                [
                                    'id' => 'categories',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px'],
                                    'blocks' => [
                                        ['id' => 'cat-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'تسوقي حسب القسم', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'cat-list', 'type' => 'categoryList', 'props' => ['variant' => 'grid', 'showImage' => true, 'columns' => 4], 'style' => []],
                                    ],
                                ],
                                [
                                    'id' => 'bestsellers',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px', 'backgroundColor' => '#FDF2F8'],
                                    'blocks' => [
                                        ['id' => 'best-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'الأكثر مبيعاً 💄', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'best-grid', 'type' => 'productGrid', 'props' => ['source' => 'featured', 'columns' => 4, 'limit' => 8], 'style' => []],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // ==============================
            // 5. General / Multi-purpose
            // ==============================
            [
                'name_ar' => 'سوق — متجر عام',
                'name_en' => 'Market — General Store',
                'slug' => 'market-general',
                'category' => 'GENERAL',
                'description_ar' => 'قالب متعدد الاستخدامات يناسب أي نوع من المتاجر',
                'description_en' => 'Multi-purpose template for any type of store',
                'thumbnail' => 'https://placehold.co/400x300/2d3436/dfe6e9?text=General',
                'sort_order' => 5,
                'store_config' => [
                    'theme' => [
                        'primaryColor' => '#2d3436',
                        'secondaryColor' => '#0984e3',
                        'accentColor' => '#00b894',
                        'fontFamily' => 'Cairo',
                        'borderRadius' => '10px',
                    ],
                    'pages' => [
                        [
                            'id' => 'page-home',
                            'slug' => '/',
                            'sections' => [
                                [
                                    'id' => 'hero',
                                    'style' => ['backgroundColor' => '#2d3436', 'paddingTop' => '64px', 'paddingBottom' => '64px'],
                                    'blocks' => [
                                        ['id' => 'h1', 'type' => 'heading', 'props' => ['level' => 'h1', 'text' => 'مرحباً بك في متجرنا', 'align' => 'center'], 'style' => ['fontSize' => '42px', 'fontWeight' => '800', 'color' => '#ffffff']],
                                        ['id' => 'h1-sub', 'type' => 'text', 'props' => ['content' => 'كل ما تحتاجه في مكان واحد بأفضل الأسعار'], 'style' => ['fontSize' => '18px', 'color' => '#b2bec3', 'textAlign' => 'center', 'marginTop' => '12px']],
                                        ['id' => 'h1-btn', 'type' => 'button', 'props' => ['label' => 'ابدأ التسوق', 'link' => '/products', 'variant' => 'primary'], 'style' => ['marginTop' => '24px']],
                                    ],
                                ],
                                [
                                    'id' => 'categories',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px'],
                                    'blocks' => [
                                        ['id' => 'cat-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'الأقسام', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'cat-list', 'type' => 'categoryList', 'props' => ['variant' => 'grid', 'showImage' => true, 'columns' => 4], 'style' => []],
                                    ],
                                ],
                                [
                                    'id' => 'featured',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px', 'backgroundColor' => '#f5f6fa'],
                                    'blocks' => [
                                        ['id' => 'feat-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'منتجات مميزة', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'feat-grid', 'type' => 'productGrid', 'props' => ['source' => 'featured', 'columns' => 4, 'limit' => 8], 'style' => []],
                                    ],
                                ],
                                [
                                    'id' => 'latest',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px'],
                                    'blocks' => [
                                        ['id' => 'lat-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'أحدث المنتجات', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'lat-grid', 'type' => 'productGrid', 'props' => ['source' => 'latest', 'columns' => 3, 'limit' => 6], 'style' => []],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // ==============================
            // 6. Sports
            // ==============================
            [
                'name_ar' => 'رياضي — متجر رياضة',
                'name_en' => 'Athletic — Sports Store',
                'slug' => 'athletic-sports',
                'category' => 'SPORTS',
                'description_ar' => 'قالب حيوي لمتاجر الأدوات والملابس الرياضية',
                'description_en' => 'Dynamic template for sports equipment and apparel',
                'thumbnail' => 'https://placehold.co/400x300/e17055/fff?text=Sports',
                'sort_order' => 6,
                'store_config' => [
                    'theme' => [
                        'primaryColor' => '#e17055',
                        'secondaryColor' => '#2d3436',
                        'accentColor' => '#00b894',
                        'fontFamily' => 'Cairo',
                        'borderRadius' => '8px',
                    ],
                    'pages' => [
                        [
                            'id' => 'page-home',
                            'slug' => '/',
                            'sections' => [
                                [
                                    'id' => 'hero',
                                    'style' => ['backgroundColor' => '#2d3436', 'paddingTop' => '72px', 'paddingBottom' => '72px'],
                                    'blocks' => [
                                        ['id' => 'h1', 'type' => 'heading', 'props' => ['level' => 'h1', 'text' => 'تجهز للتحدي 💪', 'align' => 'center'], 'style' => ['fontSize' => '44px', 'fontWeight' => '800', 'color' => '#ffffff']],
                                        ['id' => 'h1-sub', 'type' => 'text', 'props' => ['content' => 'معدات وملابس رياضية لكل الرياضات'], 'style' => ['fontSize' => '18px', 'color' => '#e17055', 'textAlign' => 'center', 'marginTop' => '12px']],
                                        ['id' => 'h1-btn', 'type' => 'button', 'props' => ['label' => 'اكتشف المنتجات', 'link' => '/products', 'variant' => 'primary'], 'style' => ['marginTop' => '28px']],
                                    ],
                                ],
                                [
                                    'id' => 'featured',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px'],
                                    'blocks' => [
                                        ['id' => 'feat-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'الأكثر مبيعاً', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'feat-grid', 'type' => 'productGrid', 'props' => ['source' => 'featured', 'columns' => 4, 'limit' => 8], 'style' => []],
                                    ],
                                ],
                                [
                                    'id' => 'categories',
                                    'style' => ['paddingTop' => '48px', 'paddingBottom' => '48px', 'backgroundColor' => '#f5f6fa'],
                                    'blocks' => [
                                        ['id' => 'cat-title', 'type' => 'heading', 'props' => ['level' => 'h2', 'text' => 'الأقسام', 'align' => 'center'], 'style' => ['fontSize' => '28px', 'fontWeight' => '700', 'marginBottom' => '24px']],
                                        ['id' => 'cat-list', 'type' => 'categoryList', 'props' => ['variant' => 'grid', 'showImage' => true, 'columns' => 3], 'style' => []],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($templates as $t) {
            Template::firstOrCreate(['slug' => $t['slug']], $t);
        }

        $this->command->info('6 templates seeded successfully!');
    }
}
