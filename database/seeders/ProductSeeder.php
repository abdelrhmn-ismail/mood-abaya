<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

/**
 * Mood Abaya catalog (EN/AR + SAR). Product media paths are fixed strings under public/media —
 * deploy those files to production; the seeder only writes DB rows (no scanning or copying).
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $winter = Category::where('slug', 'luxury-winter-abayas')->first();
        $evening = Category::where('slug', 'evening-occasion-abayas')->first();
        $ramadan = Category::where('slug', 'ramadan-oriental-collection')->first();
        if (! $winter?->id || ! $evening?->id || ! $ramadan?->id) {
            return;
        }

        $media = $this->explicitProductMedia();
        $products = $this->catalogProducts($winter->id, $evening->id, $ramadan->id);

        foreach ($products as $data) {
            $slug = $data['slug'];
            $paths = $media[$slug] ?? null;
            if ($paths === null) {
                throw new \LogicException("Missing explicit media paths for product slug: {$slug}");
            }

            $gallery = $paths['gallery'];
            unset($paths['gallery']);
            $data = array_merge($data, $paths);
            $data['active'] = true;

            $product = Product::updateOrCreate(
                [
                    'category_id' => $data['category_id'],
                    'slug' => $slug,
                ],
                $data
            );

            $this->syncProductGalleryImages($product, $gallery);
        }
    }

    /**
     * Full URLs on site: /media/... — files must exist at public/media/...
     *
     * @return array<string, array{image: string, video: ?string, gallery: array<int, string>}>
     */
    private function explicitProductMedia(): array
    {
        return [
            'suede-fur-winter-abaya' => [
                'image' => 'media/products/suede-fur-winter-abaya/main.jpg',
                'video' => null,
                'gallery' => [
                    'media/products/suede-fur-winter-abaya/gallery-1.jpg',
                    'media/products/suede-fur-winter-abaya/gallery-2.jpg',
                    'media/products/suede-fur-winter-abaya/gallery-3.jpg',
                ],
            ],
            'velvet-abaya-side-shawl-sleeve-detailing' => [
                'image' => 'media/products/velvet-abaya-side-shawl-sleeve-detailing/main.jpg',
                'video' => null,
                'gallery' => [
                    'media/products/velvet-abaya-side-shawl-sleeve-detailing/gallery-1.jpg',
                    'media/products/velvet-abaya-side-shawl-sleeve-detailing/gallery-2.jpg',
                    'media/products/velvet-abaya-side-shawl-sleeve-detailing/gallery-3.jpg',
                ],
            ],
            'heavy-crepe-winter-abaya-shine-inner-dress' => [
                'image' => 'media/products/heavy-crepe-winter-abaya-shine-inner-dress/main.jpg',
                'video' => null,
                'gallery' => [
                    'media/products/heavy-crepe-winter-abaya-shine-inner-dress/gallery-1.jpg',
                    'media/products/heavy-crepe-winter-abaya-shine-inner-dress/gallery-2.jpg',
                    'media/products/heavy-crepe-winter-abaya-shine-inner-dress/gallery-3.jpg',
                ],
            ],
            'wide-cut-crepe-abaya-back-pleats-lace' => [
                'image' => 'media/products/wide-cut-crepe-abaya-back-pleats-lace/main.jpg',
                'video' => null,
                'gallery' => [
                    'media/products/wide-cut-crepe-abaya-back-pleats-lace/gallery-1.jpg',
                    'media/products/wide-cut-crepe-abaya-back-pleats-lace/gallery-2.jpg',
                    'media/products/wide-cut-crepe-abaya-back-pleats-lace/gallery-3.jpg',
                ],
            ],
            'velvet-abaya-luxurious-bodice-embellishments' => [
                'image' => 'media/products/velvet-abaya-luxurious-bodice-embellishments/main.jpg',
                'video' => null,
                'gallery' => [
                    'media/products/velvet-abaya-luxurious-bodice-embellishments/gallery-1.jpg',
                    'media/products/velvet-abaya-luxurious-bodice-embellishments/gallery-2.jpg',
                    'media/products/velvet-abaya-luxurious-bodice-embellishments/gallery-3.jpg',
                ],
            ],
            'velvet-abaya-side-pearl-embellishments' => [
                'image' => 'media/products/velvet-abaya-side-pearl-embellishments/main.jpg',
                'video' => null,
                'gallery' => [
                    'media/products/velvet-abaya-side-pearl-embellishments/gallery-1.jpg',
                    'media/products/velvet-abaya-side-pearl-embellishments/gallery-2.jpg',
                    'media/products/velvet-abaya-side-pearl-embellishments/gallery-3.jpg',
                ],
            ],
            'elegant-ramadan-abaya' => [
                'image' => 'media/products/elegant-ramadan-abaya/main.jpg',
                'video' => null,
                'gallery' => [
                    'media/products/elegant-ramadan-abaya/gallery-1.jpg',
                    'media/products/elegant-ramadan-abaya/gallery-2.jpg',
                    'media/products/elegant-ramadan-abaya/gallery-3.jpg',
                ],
            ],
            'elegant-ramadan-occasion-dress' => [
                'image' => 'media/products/elegant-ramadan-occasion-dress/main.jpg',
                'video' => null,
                'gallery' => [
                    'media/products/elegant-ramadan-occasion-dress/gallery-1.jpg',
                    'media/products/elegant-ramadan-occasion-dress/gallery-2.jpg',
                    'media/products/elegant-ramadan-occasion-dress/gallery-3.jpg',
                ],
            ],
            'elegant-makhawar' => [
                'image' => 'media/products/elegant-makhawar/main.jpg',
                'video' => null,
                'gallery' => [
                    'media/products/elegant-makhawar/gallery-1.jpg',
                    'media/products/elegant-makhawar/gallery-2.jpg',
                    'media/products/elegant-makhawar/gallery-3.jpg',
                ],
            ],
            'ramadan-makhawar' => [
                'image' => 'media/products/ramadan-makhawar/main.jpg',
                'video' => null,
                'gallery' => [
                    'media/products/ramadan-makhawar/gallery-1.jpg',
                    'media/products/ramadan-makhawar/gallery-2.jpg',
                    'media/products/ramadan-makhawar/gallery-3.jpg',
                ],
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function catalogProducts(int $winterId, int $eveningId, int $ramadanId): array
    {
        return [
            [
                'category_id' => $winterId,
                'name' => [
                    'en' => 'Suede & Fur Winter Abaya',
                    'ar' => 'عباية شتوية شامواه وفرو',
                ],
                'slug' => 'suede-fur-winter-abaya',
                'description' => [
                    'en' => $this->paragraphsToHtml(
                        "An elegant winter design crafted from soft suede, offering a warm touch and a refined drape perfectly suited for colder days.\n\n".
                        "This piece features chic fur accents on the sleeves, collar, or edges, adding a luxurious touch and extra warmth with effortless sophistication.\n\n".
                        'Its balanced cut beautifully combines practicality with femininity, making it an ideal choice for elevated everyday wear and special winter occasions.'."\n\n".
                        'Effortlessly easy to style with your favorite accessories.'
                    ),
                    'ar' => $this->paragraphsToHtml(
                        "عباية شتوية عملية مصممة من قماش الشامواه الناعم، بملمس دافئ وانسيابية راقية تناسب الأجواء الباردة.\n\n".
                        "تتميز القطعة بتفاصيل فرو أنيقة على الأكمام أو الياقة أو الحواف، تضيف لمسة فاخرة وإحساسًا إضافيًا بالدفء دون مبالغة.\n\n".
                        'القصة متوازنة تجمع بين العملية والأنوثة، مما يجعلها خيارًا مثاليًا للإطلالات اليومية الراقية والمناسبات الشتوية، مع سهولة تنسيقها مع مختلف الإكسسوارات.'
                    ),
                ],
                'short_description' => 'Winter abaya in soft suede with fur accents — warm, refined, and easy to style.',
                'price' => 600.00,
                'compare_at_price' => null,
                'stock' => 20,
                'sku' => 'MD-001',
                'featured' => true,
            ],
            [
                'category_id' => $eveningId,
                'name' => [
                    'en' => 'Velvet Abaya with Side Shawl & Sleeve Detailing',
                    'ar' => 'عباية مخمل مع شال جانبي وتفاصيل أكمام',
                ],
                'slug' => 'velvet-abaya-side-shawl-sleeve-detailing',
                'description' => [
                    'en' => $this->paragraphsToHtml(
                        "An elegant piece crafted from soft velvet, featuring a rich texture and a refined shine that reflects undeniable luxury.\n\n".
                        'The design is distinguished by a flowing side shawl that adds graceful movement and a balanced dramatic touch, complemented by harmonious details on the sleeves that enhance femininity.'."\n\n".
                        'The seamless silhouette maintains a majestic presence while highlighting the beauty of the fabric, making it perfect for special occasions and evening events.'
                    ),
                    'ar' => $this->paragraphsToHtml(
                        "عباية مخمل مع شال جانبي وانسيابية على الأكمام.\n\n".
                        "قطعة أنيقة مصنوعة من قماش المخمل الناعم، بملمس غني ولمعة راقية تعكس إحساسًا عاليًا بالفخامة.\n\n".
                        "يتميز التصميم بشال جانبي ينسدل بانسيابية ليضفي حركة ناعمة ولمسة درامية متزنة، إلى جانب تفاصيل متناغمة على الأكمام تعزز أنوثة الإطلالة.\n\n".
                        'تحافظ القصة الانسيابية على حضور مهيب مع إبراز جمال القماش، مما يجعلها خيارًا مثاليًا للمناسبات الخاصة والسهرات.'
                    ),
                ],
                'short_description' => 'Soft velvet abaya with flowing side shawl and detailed sleeves.',
                'price' => 300.00,
                'compare_at_price' => null,
                'stock' => 20,
                'sku' => 'MD-002',
                'featured' => true,
            ],
            [
                'category_id' => $winterId,
                'name' => [
                    'en' => 'Heavy Crepe Winter Abaya with Subtle Shine & Inner Dress',
                    'ar' => 'عباية شتوية كريب ثقيل بلمعة ناعمة مع فستان داخلي',
                ],
                'slug' => 'heavy-crepe-winter-abaya-shine-inner-dress',
                'description' => [
                    'en' => $this->paragraphsToHtml(
                        "A winter staple crafted from heavy crepe fabric with a soft radiant finish, offering structure, warmth, and refined elegance.\n\n".
                        'It includes a coordinating inner dress, creating an effortlessly elegant and feminine look without extra styling.'."\n\n".
                        'The subtle shimmer adds understated luxury, making it ideal for various winter occasions.'
                    ),
                    'ar' => $this->paragraphsToHtml(
                        "عباية شتوية من قماش كريب ثقيل بلمعة ناعمة، تمنح مظهرًا راقيًا مع إحساس بالدفء والراحة.\n\n".
                        "تتميز بقصة متوازنة تجمع بين الفخامة والعملية، وتأتي مع فستان داخلي متناسق يمنح إطلالة أنيقة دون الحاجة لتنسيق إضافي.\n\n".
                        'اللمعة الخفيفة تضيف لمسة فاخرة هادئة، مما يجعلها مناسبة لمختلف المناسبات الشتوية.'
                    ),
                ],
                'short_description' => 'Heavy crepe winter abaya with soft shine and matching inner dress.',
                'price' => 250.00,
                'compare_at_price' => null,
                'stock' => 20,
                'sku' => 'MD-003',
                'featured' => true,
            ],
            [
                'category_id' => $winterId,
                'name' => [
                    'en' => 'Wide-Cut Crepe Abaya with Back Pleats & Lace',
                    'ar' => 'عباية كريب بقصة واسعة مع كسرات خلفية ودانتيل',
                ],
                'slug' => 'wide-cut-crepe-abaya-back-pleats-lace',
                'description' => [
                    'en' => $this->paragraphsToHtml(
                        "An elegant design crafted from high-quality crepe fabric with a comfortable wide cut.\n\n".
                        'Soft back pleats add graceful movement, while delicate lace detailing enhances the luxurious yet subtle touch.'."\n\n".
                        'Perfectly blends comfort with elegance for everyday wear.'
                    ),
                    'ar' => $this->paragraphsToHtml(
                        "عباية كريب بقصة واسعة مع كسرات خلفية وتفاصيل دانتيل.\n\n".
                        "تصميم أنيق من قماش كريب عالي الجودة، يتميز بقصة مريحة وانسيابية مع الحركة.\n\n".
                        "الكسرات الخلفية تضيف لمسة أنثوية ناعمة، بينما يضيف الدانتيل تفاصيل فاخرة هادئة.\n\n".
                        'يجمع التصميم بين الراحة والأناقة ليكون مناسبًا للاستخدام اليومي بإطلالة راقية.'
                    ),
                ],
                'short_description' => 'Wide-cut crepe abaya with back pleats and lace details.',
                'price' => 200.00,
                'compare_at_price' => null,
                'stock' => 20,
                'sku' => 'MD-004',
                'featured' => false,
            ],
            [
                'category_id' => $eveningId,
                'name' => [
                    'en' => 'Velvet Abaya with Luxurious Bodice Embellishments',
                    'ar' => 'عباية مخمل مزينة بتفاصيل فاخرة على الصدر',
                ],
                'slug' => 'velvet-abaya-luxurious-bodice-embellishments',
                'description' => [
                    'en' => $this->paragraphsToHtml(
                        "A luxurious velvet piece offering warmth and sophistication.\n\n".
                        'Features elegant bodice embellishments that add refined detail without being overstated.'."\n\n".
                        'Ideal for evening events and formal occasions.'
                    ),
                    'ar' => $this->paragraphsToHtml(
                        "عباية مخمل مزينة بتفاصيل فاخرة على الصدر.\n\n".
                        "قطعة أنيقة من المخمل الناعم بملمس غني ولمعة راقية تمنح إحساسًا بالفخامة.\n\n".
                        "التفاصيل المزخرفة على الصدر تضيف بعدًا أنيقًا دون مبالغة، مما يعزز حضور القطعة وأناقتها.\n\n".
                        'مثالية للمناسبات الرسمية والسهرات.'
                    ),
                ],
                'short_description' => 'Velvet abaya with refined bodice embellishments for formal occasions.',
                'price' => 300.00,
                'compare_at_price' => null,
                'stock' => 20,
                'sku' => 'MD-005',
                'featured' => false,
            ],
            [
                'category_id' => $eveningId,
                'name' => [
                    'en' => 'Velvet Abaya with Side Pearl Embellishments',
                    'ar' => 'عباية مخمل مزينة باللؤلؤ على الجانب',
                ],
                'slug' => 'velvet-abaya-side-pearl-embellishments',
                'description' => [
                    'en' => $this->paragraphsToHtml(
                        "A luxurious velvet design with refined shine and rich texture.\n\n".
                        'Adorned with elegant pearl details on the side in an asymmetrical style, adding a modern feminine flair.'."\n\n".
                        'Ideal for special occasions.'
                    ),
                    'ar' => $this->paragraphsToHtml(
                        "عباية مخمل مزينة باللؤلؤ على الجانب.\n\n".
                        "تصميم فاخر بملمس غني ولمعة راقية يعكس إحساسًا بالفخامة.\n\n".
                        "مزينة بتفاصيل لؤلؤ أنيقة بأسلوب جانبي غير متماثل يضيف لمسة عصرية وأنثوية.\n\n".
                        'مثالية للمناسبات الخاصة.'
                    ),
                ],
                'short_description' => 'Velvet abaya with asymmetrical pearl embellishments.',
                'price' => 300.00,
                'compare_at_price' => null,
                'stock' => 20,
                'sku' => 'MD-006',
                'featured' => false,
            ],
            [
                'category_id' => $ramadanId,
                'name' => [
                    'en' => 'Elegant Ramadan Abaya',
                    'ar' => 'عباية رمضانية أنيقة',
                ],
                'slug' => 'elegant-ramadan-abaya',
                'description' => [
                    'en' => $this->paragraphsToHtml(
                        "A beautifully designed piece offering understated elegance with soft feminine details.\n\n".
                        'Perfect for Ramadan gatherings and quiet evenings, with a comfortable silhouette and refined look.'
                    ),
                    'ar' => $this->paragraphsToHtml(
                        "عباية أنيقة مناسبة لأجواء رمضان، تتميز بلمسة هادئة وتفاصيل ناعمة تجمع بين البساطة والفخامة.\n\n".
                        'قصة مريحة تسمح بحرية الحركة مع الحفاظ على أناقة متوازنة تناسب تجمعات رمضان والسهرات الهادئة.'
                    ),
                ],
                'short_description' => 'Understated Ramadan abaya — soft details, comfortable silhouette.',
                'price' => 200.00,
                'compare_at_price' => null,
                'stock' => 20,
                'sku' => 'MD-007',
                'featured' => true,
            ],
            [
                'category_id' => $ramadanId,
                'name' => [
                    'en' => 'Elegant Ramadan Occasion Dress',
                    'ar' => 'فستان مناسبات رمضاني أنيق',
                ],
                'slug' => 'elegant-ramadan-occasion-dress',
                'description' => [
                    'en' => $this->paragraphsToHtml(
                        "An elegant design inspired by the enchanting atmosphere of Ramadan.\n\n".
                        'Blends sophistication with simplicity, featuring refined feminine details perfect for Ramadan evenings and special occasions.'
                    ),
                    'ar' => $this->paragraphsToHtml(
                        "فستان أنيق مستوحى من أجواء رمضان الساحرة، يجمع بين الفخامة والبساطة.\n\n".
                        'مزين بتفاصيل أنثوية جذابة تمنح إطلالة راقية تناسب السهرات الرمضانية والمناسبات الخاصة.'
                    ),
                ],
                'short_description' => 'Ramadan occasion dress — refined details for evenings and events.',
                'price' => 200.00,
                'compare_at_price' => null,
                'stock' => 20,
                'sku' => 'MD-008',
                'featured' => false,
            ],
            [
                'category_id' => $ramadanId,
                'name' => [
                    'en' => 'Elegant Makhawar',
                    'ar' => 'مخور أنيق',
                ],
                'slug' => 'elegant-makhawar',
                'description' => [
                    'en' => $this->paragraphsToHtml(
                        "An elegant design capturing Oriental charm with a modern soft touch.\n\n".
                        'Features refined details and a flowing silhouette, suitable for both everyday wear and special occasions.'
                    ),
                    'ar' => $this->paragraphsToHtml(
                        "تصميم أنيق يعكس روح الأناقة الشرقية بلمسة عصرية ناعمة.\n\n".
                        'يتميز بتفاصيل راقية تضيف عمقًا وجاذبية للإطلالة، مع قصة مريحة تجمع بين الأناقة والراحة.'
                    ),
                ],
                'short_description' => 'Elegant makhawar — Oriental charm with a modern soft touch.',
                'price' => 170.00,
                'compare_at_price' => null,
                'stock' => 20,
                'sku' => 'MD-009',
                'featured' => false,
            ],
            [
                'category_id' => $ramadanId,
                'name' => [
                    'en' => 'Ramadan Makhawar',
                    'ar' => 'مخور رمضاني',
                ],
                'slug' => 'ramadan-makhawar',
                'description' => [
                    'en' => $this->paragraphsToHtml(
                        "An elegant design inspired by Ramadan’s warm atmosphere.\n\n".
                        'Combines Oriental charm with modern elegance, featuring luxurious details and a flowing silhouette ideal for family gatherings and special occasions.'
                    ),
                    'ar' => $this->paragraphsToHtml(
                        "تصميم مستوحى من أجواء رمضان الدافئة، يجمع بين الطابع الشرقي واللمسة العصرية.\n\n".
                        'يتميز بتفاصيل فاخرة تضيف إحساسًا بالنعومة والرقي، مناسب للتجمعات العائلية والمناسبات خلال الشهر الكريم.'
                    ),
                ],
                'short_description' => 'Ramadan makhawar — warm atmosphere, refined details.',
                'price' => 170.00,
                'compare_at_price' => null,
                'stock' => 20,
                'sku' => 'MD-010',
                'featured' => false,
            ],
        ];
    }

    private function syncProductGalleryImages(Product $product, array $paths): void
    {
        $product->images()->delete();
        foreach ($paths as $i => $path) {
            ProductImage::create([
                'product_id' => $product->id,
                'sort_order' => $i + 1,
                'image' => $path,
            ]);
        }
    }

    private function paragraphsToHtml(string $text): string
    {
        if (trim($text) === '') {
            return '';
        }
        $paragraphs = preg_split('/\n\s*\n/', trim($text), -1, PREG_SPLIT_NO_EMPTY);
        $wrapped = array_map(fn ($p) => '<p>'.nl2br(e(trim($p))).'</p>', $paragraphs);

        return implode('', $wrapped);
    }
}
