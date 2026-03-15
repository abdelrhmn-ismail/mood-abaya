<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    use CreatesTestImages;

    /** Number of gallery images to seed per product (in addition to main image). */
    private const GALLERY_IMAGES_PER_PRODUCT = 3;

    /** Path to Salla store import data (full product data from https://salla.sa/moodabaya). */
    private const SALLA_DATA_PATH = 'database/data/salla-moodabaya-products.json';

    /** Folder for Mood Abaya product photos (place 01.png–12.png here to use real images). */
    private const MOODABAYA_IMAGES_DIR = 'products/moodabaya';

    public function run(): void
    {
        $abaya = Category::where('slug', 'abayas')->first();
        $jilbab = Category::where('slug', 'jilbabs')->first();
        $hijab = Category::where('slug', 'hijabs')->first();

        $sallaProducts = $this->loadSallaProducts($abaya, $jilbab, $hijab);
        $moodabayaProducts = $this->moodabayaCatalogProducts($abaya);

        $products = array_merge($sallaProducts, $moodabayaProducts, [
            // —— Abayas (fallback if not in Salla data) ——
            [
                'category_id' => $abaya?->id,
                'name' => ['en' => 'Classic Black Abaya', 'ar' => 'عباية سوداء كلاسيكية'],
                'slug' => 'classic-black-abaya',
                'description' => [
                    'en' => 'Elegant classic black abaya, perfect for daily wear. Timeless cut and quality fabric.',
                    'ar' => 'عباية سوداء كلاسيكية أنيقة، مثالية للارتداء اليومي. قصة خالدة وقماش عالي الجودة.',
                ],
                'short_description' => 'Classic black abaya for daily wear.',
                'price' => 199.00,
                'compare_at_price' => 249.00,
                'stock' => 25,
                'sku' => 'ABY-001',
                'featured' => true,
            ],
            [
                'category_id' => $abaya?->id,
                'name' => ['en' => 'Embroidered Abaya', 'ar' => 'عباية مطرزة'],
                'slug' => 'embroidered-abaya',
                'description' => [
                    'en' => 'Beautiful embroidered abaya for special occasions. Delicate details and premium finish.',
                    'ar' => 'عباية مطرزة جميلة للمناسبات الخاصة. تفاصيل دقيقة وتشطيب مميز.',
                ],
                'short_description' => 'Embroidered abaya for special occasions.',
                'price' => 349.00,
                'compare_at_price' => 399.00,
                'stock' => 15,
                'sku' => 'ABY-002',
            ],
            [
                'category_id' => $abaya?->id,
                'name' => [
                    'en' => 'Open front abaya with buttons',
                    'ar' => 'عباية مفتوحة أمامية بأزرار',
                ],
                'slug' => 'open-front-abaya-buttons',
                'description' => [
                    'en' => 'Open front abaya with delicate buttons. Easy to wear and layer over your outfit.',
                    'ar' => 'عباية مفتوحة من الأمام بأزرار أنيقة. سهلة الارتداء والطبقة فوق ملابسك.',
                ],
                'short_description' => 'Open front abaya with buttons.',
                'price' => 279.00,
                'compare_at_price' => null,
                'stock' => 18,
                'sku' => 'ABY-003',
            ],
            [
                'category_id' => $abaya?->id,
                'name' => [
                    'en' => 'Chiffon abaya with lace sleeves',
                    'ar' => 'عباية شيفون بأكمام دانتيل',
                ],
                'slug' => 'chiffon-abaya-lace-sleeves',
                'description' => [
                    'en' => 'Light chiffon abaya with lace sleeve details. Ideal for warmer days and evening occasions.',
                    'ar' => 'عباية شيفون خفيفة بتفاصيل دانتيل على الأكمام. مثالية للأيام الدافئة والمناسبات المسائية.',
                ],
                'short_description' => 'Chiffon abaya with lace sleeves.',
                'price' => 320.00,
                'compare_at_price' => 360.00,
                'stock' => 12,
                'sku' => 'ABY-004',
                'featured' => true,
            ],
            [
                'category_id' => $abaya?->id,
                'name' => [
                    'en' => 'Navy blue abaya with side slits',
                    'ar' => 'عباية زرقاء بحرية بشقوق جانبية',
                ],
                'slug' => 'navy-abaya-side-slits',
                'description' => [
                    'en' => 'Navy blue abaya with subtle side slits for ease of movement. Versatile for work and outings.',
                    'ar' => 'عباية زرقاء بحرية بشقوق جانبية خفيفة لسهولة الحركة. متعددة الاستخدام للعمل والخروج.',
                ],
                'short_description' => 'Navy abaya with side slits.',
                'price' => 229.00,
                'compare_at_price' => null,
                'stock' => 22,
                'sku' => 'ABY-005',
            ],
            [
                'category_id' => $abaya?->id,
                'name' => [
                    'en' => 'Burgundy abaya with belt',
                    'ar' => 'عباية عنابية مع حزام',
                ],
                'slug' => 'burgundy-abaya-belt',
                'description' => [
                    'en' => 'Burgundy abaya with optional belt to define the waist. Elegant and modern.',
                    'ar' => 'عباية عنابية مع حزام اختياري لتحديد الخصر. أنيقة وعصرية.',
                ],
                'short_description' => 'Burgundy abaya with belt.',
                'price' => 269.00,
                'compare_at_price' => null,
                'stock' => 14,
                'sku' => 'ABY-006',
            ],
            [
                'category_id' => $abaya?->id,
                'name' => [
                    'en' => 'Beige abaya with minimal embroidery',
                    'ar' => 'عباية بيج بتطريز بسيط',
                ],
                'slug' => 'beige-abaya-minimal-embroidery',
                'description' => [
                    'en' => 'Soft beige abaya with minimal embroidery at the cuffs and neckline. Perfect for daily elegance.',
                    'ar' => 'عباية بيج ناعمة بتطريز بسيط عند الأكمام والرقبة. مثالية للأناقة اليومية.',
                ],
                'short_description' => 'Beige abaya with minimal embroidery.',
                'price' => 289.00,
                'compare_at_price' => null,
                'stock' => 16,
                'sku' => 'ABY-007',
            ],
            // —— Jilbabs ——
            [
                'category_id' => $jilbab?->id,
                'name' => ['en' => 'Casual Jilbab', 'ar' => 'جلباب كاجوال'],
                'slug' => 'casual-jilbab',
                'description' => [
                    'en' => 'Comfortable casual jilbab in soft fabric. Perfect for everyday wear.',
                    'ar' => 'جلباب كاجوال مريح من قماش ناعم. مثالي للارتداء اليومي.',
                ],
                'short_description' => 'Comfortable casual jilbab.',
                'price' => 129.00,
                'compare_at_price' => 159.00,
                'stock' => 30,
                'sku' => 'JLB-001',
                'featured' => true,
            ],
            [
                'category_id' => $jilbab?->id,
                'name' => [
                    'en' => 'Two-piece jilbab set',
                    'ar' => 'طقم جلباب من قطعتين',
                ],
                'slug' => 'two-piece-jilbab-set',
                'description' => [
                    'en' => 'Two-piece jilbab: top and skirt. Easy to mix and match, comfortable fit.',
                    'ar' => 'جلباب من قطعتين: بلوزة وتنورة. سهل التنسيق ومريح في المقاس.',
                ],
                'short_description' => 'Two-piece jilbab set.',
                'price' => 169.00,
                'compare_at_price' => null,
                'stock' => 20,
                'sku' => 'JLB-002',
            ],
            [
                'category_id' => $jilbab?->id,
                'name' => [
                    'en' => 'Long sleeve jilbab in olive',
                    'ar' => 'جلباب بأكمام طويلة بلون زيتوني',
                ],
                'slug' => 'long-sleeve-jilbab-olive',
                'description' => [
                    'en' => 'Long sleeve jilbab in olive green. Relaxed cut and breathable fabric.',
                    'ar' => 'جلباب بأكمام طويلة بلون زيتوني. قصة مريحة وقماش ينفس.',
                ],
                'short_description' => 'Long sleeve olive jilbab.',
                'price' => 149.00,
                'compare_at_price' => 179.00,
                'stock' => 24,
                'sku' => 'JLB-003',
            ],
            [
                'category_id' => $jilbab?->id,
                'name' => [
                    'en' => 'Jilbab with hood',
                    'ar' => 'جلباب بقبعة',
                ],
                'slug' => 'jilbab-with-hood',
                'description' => [
                    'en' => 'Practical jilbab with attached hood. Ideal for cooler days and extra modesty.',
                    'ar' => 'جلباب عملي مع قبعة مرفقة. مثالي للأيام الباردة والاحتشام الإضافي.',
                ],
                'short_description' => 'Jilbab with hood.',
                'price' => 189.00,
                'compare_at_price' => null,
                'stock' => 15,
                'sku' => 'JLB-004',
            ],
            [
                'category_id' => $jilbab?->id,
                'name' => [
                    'en' => 'Plain grey jilbab',
                    'ar' => 'جلباب رمادي سادة',
                ],
                'slug' => 'plain-grey-jilbab',
                'description' => [
                    'en' => 'Plain grey jilbab for a clean, versatile look. Pairs well with any hijab colour.',
                    'ar' => 'جلباب رمادي سادة لمظهر نظيف ومتعدد الاستخدام. يتناسق مع أي لون حجاب.',
                ],
                'short_description' => 'Plain grey jilbab.',
                'price' => 119.00,
                'compare_at_price' => null,
                'stock' => 28,
                'sku' => 'JLB-005',
            ],
            [
                'category_id' => $jilbab?->id,
                'name' => [
                    'en' => 'Terracotta jilbab',
                    'ar' => 'جلباب تراكوتا',
                ],
                'slug' => 'terracotta-jilbab',
                'description' => [
                    'en' => 'Terracotta coloured jilbab. On-trend shade and soft fabric for all-day comfort.',
                    'ar' => 'جلباب بلون تراكوتا. لون عصري وقماش ناعم لراحة طوال اليوم.',
                ],
                'short_description' => 'Terracotta jilbab.',
                'price' => 139.00,
                'compare_at_price' => null,
                'stock' => 18,
                'sku' => 'JLB-006',
            ],
            // —— Hijabs ——
            [
                'category_id' => $hijab?->id,
                'name' => ['en' => 'Premium Hijab Set', 'ar' => 'طقم حجاب مميز'],
                'slug' => 'premium-hijab-set',
                'description' => [
                    'en' => 'Set of three premium quality hijabs. Versatile colours for everyday styling.',
                    'ar' => 'طقم من ثلاثة حجابات عالية الجودة. ألوان متعددة الاستخدام للانتقاء اليومي.',
                ],
                'short_description' => 'Set of three premium hijabs.',
                'price' => 59.00,
                'compare_at_price' => 79.00,
                'stock' => 50,
                'sku' => 'HIJ-001',
                'featured' => true,
            ],
            [
                'category_id' => $hijab?->id,
                'name' => [
                    'en' => 'Jersey hijab – black',
                    'ar' => 'حجاب جيرسي – أسود',
                ],
                'slug' => 'jersey-hijab-black',
                'description' => [
                    'en' => 'Soft jersey hijab in black. Stretch and easy to drape, no slip.',
                    'ar' => 'حجاب جيرسي ناعم باللون الأسود. مرن وسهل التشكيل ولا ينزلق.',
                ],
                'short_description' => 'Black jersey hijab.',
                'price' => 35.00,
                'compare_at_price' => null,
                'stock' => 60,
                'sku' => 'HIJ-002',
            ],
            [
                'category_id' => $hijab?->id,
                'name' => [
                    'en' => 'Chiffon hijab – nude',
                    'ar' => 'حجاب شيفون – لون نود',
                ],
                'slug' => 'chiffon-hijab-nude',
                'description' => [
                    'en' => 'Light chiffon hijab in nude. Elegant drape and suitable for all seasons.',
                    'ar' => 'حجاب شيفون خفيف بلون نود. طية أنيقة ومناسب لجميع الفصول.',
                ],
                'short_description' => 'Nude chiffon hijab.',
                'price' => 42.00,
                'compare_at_price' => null,
                'stock' => 45,
                'sku' => 'HIJ-003',
            ],
            [
                'category_id' => $hijab?->id,
                'name' => [
                    'en' => 'Printed hijab – floral',
                    'ar' => 'حجاب مطبوع – زهري',
                ],
                'slug' => 'printed-hijab-floral',
                'description' => [
                    'en' => 'Subtle floral print hijab. Adds a touch of style to neutral outfits.',
                    'ar' => 'حجاب مطبوع بزخارف زهرية خفيفة. يضيف لمسة أناقة للملابس المحايدة.',
                ],
                'short_description' => 'Floral print hijab.',
                'price' => 48.00,
                'compare_at_price' => 55.00,
                'stock' => 35,
                'sku' => 'HIJ-004',
            ],
            [
                'category_id' => $hijab?->id,
                'name' => [
                    'en' => 'Under cap – multipack',
                    'ar' => 'بونيه – متعدد القطع',
                ],
                'slug' => 'under-cap-multipack',
                'description' => [
                    'en' => 'Pack of under caps in neutral colours. Keeps hijab in place and adds volume.',
                    'ar' => 'طقم بونيهات بألوان محايدة. يثبت الحجاب ويضيف حجماً عند الرغبة.',
                ],
                'short_description' => 'Under cap multipack.',
                'price' => 25.00,
                'compare_at_price' => null,
                'stock' => 80,
                'sku' => 'HIJ-005',
            ],
            [
                'category_id' => $hijab?->id,
                'name' => [
                    'en' => 'Silk touch hijab – burgundy',
                    'ar' => 'حجاب لمسة حرير – عنابي',
                ],
                'slug' => 'silk-touch-hijab-burgundy',
                'description' => [
                    'en' => 'Silk-touch hijab in burgundy. Luxurious feel and rich colour for special occasions.',
                    'ar' => 'حجاب بلمسة حريرية بلون عنابي. ملمس فاخر ولون غني للمناسبات الخاصة.',
                ],
                'short_description' => 'Burgundy silk touch hijab.',
                'price' => 65.00,
                'compare_at_price' => null,
                'stock' => 22,
                'sku' => 'HIJ-006',
            ],
        ]);

        foreach ($products as $data) {
            if (empty($data['category_id'])) {
                continue;
            }
            $slug = $data['slug'];
            $moodabayaIndices = $data['moodabaya_images'] ?? null;
            unset($data['moodabaya_images']);

            if (is_array($moodabayaIndices) && $moodabayaIndices !== []) {
                $mainIndex = (int) array_shift($moodabayaIndices);
                $data['image'] = $this->getMoodabayaImagePath($mainIndex, $slug);
            } else {
                $data['image'] = $this->createTestImage('products', $slug);
            }
            $data['active'] = true;
            $product = Product::updateOrCreate(
                [
                    'category_id' => $data['category_id'],
                    'slug' => $slug,
                ],
                $data
            );

            if (is_array($moodabayaIndices) && $moodabayaIndices !== []) {
                $this->seedProductGalleryFromMoodabaya($product, $moodabayaIndices, $slug);
            } else {
                $this->seedProductGallery($product, $slug);
            }
        }
    }

    private function seedProductGallery(Product $product, string $slug): void
    {
        if ($product->images()->count() >= self::GALLERY_IMAGES_PER_PRODUCT) {
            return;
        }
        for ($i = 1; $i <= self::GALLERY_IMAGES_PER_PRODUCT; $i++) {
            $key = "{$slug}-gallery-{$i}";
            $path = $this->createTestImage('products', $key);
            ProductImage::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'sort_order' => $i,
                ],
                ['image' => $path]
            );
        }
    }

    /**
     * Load products from Salla store import data (database/data/salla-moodabaya-products.json).
     * Data is from https://salla.sa/moodabaya – add more products to the JSON as you export them.
     *
     * @return array<int, array<string, mixed>>
     */
    private function loadSallaProducts(?Category $abaya, ?Category $jilbab, ?Category $hijab): array
    {
        $path = base_path(self::SALLA_DATA_PATH);
        if (! File::exists($path)) {
            return [];
        }
        $json = File::get($path);
        $data = json_decode($json, true);
        if (! isset($data['products']) || ! is_array($data['products'])) {
            return [];
        }
        $categoryMap = [
            'abayas' => $abaya?->id,
            'jilbabs' => $jilbab?->id,
            'hijabs' => $hijab?->id,
        ];
        $out = [];
        foreach ($data['products'] as $row) {
            $catSlug = $row['category_slug'] ?? 'abayas';
            $categoryId = $categoryMap[$catSlug] ?? $abaya?->id;
            if (! $categoryId) {
                continue;
            }
            $descAr = $row['description_ar'] ?? '';
            $descEn = $row['description_en'] ?? '';
            $out[] = [
                'category_id' => $categoryId,
                'name' => [
                    'en' => $row['name_en'] ?? $row['name_ar'] ?? '',
                    'ar' => $row['name_ar'] ?? $row['name_en'] ?? '',
                ],
                'slug' => $row['slug'] ?? \Illuminate\Support\Str::slug($row['name_en'] ?? $row['name_ar'] ?? 'product'),
                'description' => [
                    'en' => $this->paragraphsToHtml($descEn),
                    'ar' => $this->paragraphsToHtml($descAr),
                ],
                'short_description' => $row['short_description'] ?? (is_string($descEn) ? substr(strip_tags($descEn), 0, 120) . '…' : ''),
                'price' => (float) ($row['price'] ?? 0),
                'compare_at_price' => isset($row['compare_at_price']) && $row['compare_at_price'] !== null ? (float) $row['compare_at_price'] : null,
                'stock' => (int) ($row['stock'] ?? 0),
                'sku' => $row['sku'] ?? 'SALLA-' . substr(uniqid(), -6),
                'featured' => (bool) ($row['featured'] ?? true),
                'moodabaya_images' => $row['moodabaya_images'] ?? null,
            ];
        }
        return $out;
    }

    /**
     * Mood Abaya catalog products (from moodabaya.com product photos).
     * Image indices 1–12 refer to files 01.png–12.png in storage/app/public/products/moodabaya/.
     *
     * @return array<int, array<string, mixed>>
     */
    private function moodabayaCatalogProducts(?Category $abaya): array
    {
        if (! $abaya?->id) {
            return [];
        }
        $catId = $abaya->id;
        return [
            [
                'category_id' => $catId,
                'name' => [
                    'en' => 'Black abaya with subtle sparkle',
                    'ar' => 'عباية سوداء بلمعة خفيفة',
                ],
                'slug' => 'black-abaya-sparkle',
                'description' => [
                    'en' => '<p>Elegant black abaya with subtle sparkling details. Soft fabric with a refined shimmer, perfect for evening or special occasions.</p>',
                    'ar' => '<p>عباية سوداء أنيقة بتفاصيل لامعة خفيفة. قماش ناعم مع لمعان راقٍ، مثالية للمساء أو المناسبات الخاصة.</p>',
                ],
                'short_description' => 'Black abaya with subtle sparkle.',
                'price' => 380.00,
                'compare_at_price' => null,
                'stock' => 15,
                'sku' => 'ABY-MOOD-01',
                'featured' => true,
                'moodabaya_images' => [1],
            ],
            [
                'category_id' => $catId,
                'name' => [
                    'en' => 'Beige abaya with faux fur trim',
                    'ar' => 'عباية بيج بطراز فرو',
                ],
                'slug' => 'beige-abaya-fur-trim',
                'description' => [
                    'en' => '<p>Chic light beige abaya with luxurious faux fur trim along the front and cuffs. Soft drape and warm touch for cooler days.</p>',
                    'ar' => '<p>عباية بيج أنيقة بطراز فرو فاخر على الأمام والأكمام. طية ناعمة ولمسة دافئة للأيام الباردة.</p>',
                ],
                'short_description' => 'Beige abaya with faux fur trim.',
                'price' => 450.00,
                'compare_at_price' => 499.00,
                'stock' => 12,
                'sku' => 'ABY-MOOD-02',
                'featured' => true,
                'moodabaya_images' => [2, 3],
            ],
            [
                'category_id' => $catId,
                'name' => [
                    'en' => 'Black velvet abaya with pearl-embellished skirt',
                    'ar' => 'عباية سوداء مخملية مع تنورة مرصعة باللؤلؤ',
                ],
                'slug' => 'black-velvet-abaya-pearl-skirt',
                'description' => [
                    'en' => '<p>Two-part design: velvet top with V-neck and flared sleeves, layered skirt with delicate white pearl embellishments. Modest and elegant.</p>',
                    'ar' => '<p>تصميم من قطعتين: أعلى مخملي بخط رقبة V وأكمام متسعة، تنورة متعددة الطبقات مرصعة باللؤلؤ الأبيض. محتشمة وأنيقة.</p>',
                ],
                'short_description' => 'Black velvet abaya with pearl-embellished skirt.',
                'price' => 420.00,
                'compare_at_price' => null,
                'stock' => 10,
                'sku' => 'ABY-MOOD-03',
                'featured' => true,
                'moodabaya_images' => [4, 12],
            ],
            [
                'category_id' => $catId,
                'name' => [
                    'en' => 'Black abaya with grey panels and silver embellishment',
                    'ar' => 'عباية سوداء بلوحات رمادية وتطريز فضي',
                ],
                'slug' => 'black-abaya-grey-silver-embellishment',
                'description' => [
                    'en' => '<p>Black velvet abaya with muted blue-grey panels and intricate silver beadwork on the front. Modern geometric detail and white piping.</p>',
                    'ar' => '<p>عباية سوداء مخملية بلوحات رمادية مزرقة وتطريز فضيّ على الأمام. تفاصيل هندسية عصرية وتفصيل أبيض.</p>',
                ],
                'short_description' => 'Black abaya with grey panels and silver embellishment.',
                'price' => 399.00,
                'compare_at_price' => null,
                'stock' => 14,
                'sku' => 'ABY-MOOD-04',
                'featured' => true,
                'moodabaya_images' => [5, 9],
            ],
            [
                'category_id' => $catId,
                'name' => [
                    'en' => 'Black open abaya with sequin detail',
                    'ar' => 'عباية سوداء مفتوحة بتفاصيل لامعة',
                ],
                'slug' => 'black-open-abaya-sequin',
                'description' => [
                    'en' => '<p>Open-front black abaya with notched lapels and subtle sequin shimmer. Blazer-style cut, easy to layer.</p>',
                    'ar' => '<p>عباية سوداء مفتوحة الأمام بياقات ولمعة خفيفة من الترتر. قصة شبيهة بالبلازر، سهلة الطبقة.</p>',
                ],
                'short_description' => 'Black open abaya with sequin detail.',
                'price' => 359.00,
                'compare_at_price' => null,
                'stock' => 18,
                'sku' => 'ABY-MOOD-05',
                'featured' => false,
                'moodabaya_images' => [6],
            ],
            [
                'category_id' => $catId,
                'name' => [
                    'en' => 'Black abaya with grey pleated panel',
                    'ar' => 'عباية سوداء بلوحة رمادية مكسرّة',
                ],
                'slug' => 'black-abaya-grey-pleated',
                'description' => [
                    'en' => '<p>Black abaya with a distinct dark grey pleated section and MOOD DESIGN branding. High collar, long sleeves, refined silhouette.</p>',
                    'ar' => '<p>عباية سوداء بلوحة رمادية داكنة مكسرّة وعلامة MOOD DESIGN. ياقة عالية وأكمام طويلة، سيلويت أنيق.</p>',
                ],
                'short_description' => 'Black abaya with grey pleated panel.',
                'price' => 385.00,
                'compare_at_price' => null,
                'stock' => 16,
                'sku' => 'ABY-MOOD-06',
                'featured' => true,
                'moodabaya_images' => [7, 8],
            ],
            [
                'category_id' => $catId,
                'name' => [
                    'en' => 'Black abaya with fuzzy front panel',
                    'ar' => 'عباية سوداء بلوحة أمامية فروية',
                ],
                'slug' => 'black-abaya-fuzzy-panel',
                'description' => [
                    'en' => '<p>Black abaya with a textured fuzzy or fur-like panel on the front and sleeves. Layered look with smooth black base and plush detail.</p>',
                    'ar' => '<p>عباية سوداء بلوحة أمامية وأكمام ذات ملمس فروي. إطلالة متعددة الطبقات مع قاعدة سوداء ناعمة وتفصيل فاخر.</p>',
                ],
                'short_description' => 'Black abaya with fuzzy front panel.',
                'price' => 395.00,
                'compare_at_price' => null,
                'stock' => 11,
                'sku' => 'ABY-MOOD-07',
                'featured' => false,
                'moodabaya_images' => [11],
            ],
        ];
    }

    private function getMoodabayaImagePath(int $index, string $fallbackKey): string
    {
        $filename = sprintf('%02d.png', max(1, min(12, $index)));
        $path = self::MOODABAYA_IMAGES_DIR . '/' . $filename;
        $fullPath = Storage::disk('public')->path($path);
        if (File::exists($fullPath)) {
            return $path;
        }
        return $this->createTestImage('products', $fallbackKey);
    }

    private function seedProductGalleryFromMoodabaya(Product $product, array $moodabayaIndices, string $slug): void
    {
        $order = 0;
        foreach ($moodabayaIndices as $index) {
            $order++;
            $path = $this->getMoodabayaImagePath((int) $index, $slug . '-gallery-' . $order);
            ProductImage::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'sort_order' => $order,
                ],
                ['image' => $path]
            );
        }
        while ($product->images()->count() < self::GALLERY_IMAGES_PER_PRODUCT) {
            $order++;
            $path = $this->createTestImage('products', $slug . '-gallery-' . $order);
            ProductImage::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'sort_order' => $order,
                ],
                ['image' => $path]
            );
        }
    }

    private function paragraphsToHtml(string $text): string
    {
        if (trim($text) === '') {
            return '';
        }
        $paragraphs = preg_split('/\n\s*\n/', trim($text), -1, PREG_SPLIT_NO_EMPTY);
        $wrapped = array_map(fn ($p) => '<p>' . nl2br(e(trim($p))) . '</p>', $paragraphs);

        return implode('', $wrapped);
    }
}
