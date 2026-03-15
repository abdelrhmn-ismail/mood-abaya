<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class PageContentSeeder extends Seeder
{
    public function run(): void
    {
        $aboutEn = '<p>We are dedicated to offering a carefully curated selection of abayas, jilbabs, and hijabs that combine modesty with contemporary style.</p>
<h2>Our story</h2>
<p>From the beginning, we wanted to create a place where you can find quality modest wear without compromise. We source fabrics and designs that last, and we take care of every detail so you can shop with confidence.</p>
<p>Whether you are looking for a classic abaya, a comfortable jilbab, or a versatile hijab, our collection is updated regularly to bring you the best in modest fashion.</p>
<h2>Our values</h2>
<p><strong>Quality</strong> — We choose durable materials and careful craftsmanship so every piece meets your expectations.</p>
<p><strong>Style &amp; modesty</strong> — We believe you can look elegant and stay true to your values. Our designs reflect that balance.</p>
<p><strong>Customer first</strong> — Your satisfaction matters. We are here to help with orders, sizing, and any questions.</p>
<p><strong>Reliable delivery</strong> — We ship with care and keep you updated so your order reaches you safely and on time.</p>
<h2>Why choose us</h2>
<ul>
<li>Wide range of abayas, jilbabs, and hijabs for every occasion.</li>
<li>Premium fabrics and finishes for comfort and durability.</li>
<li>Secure payment and hassle-free returns.</li>
<li>Friendly customer support before and after your purchase.</li>
</ul>';

        $aboutAr = '<p>نلتزم بتقديم تشكيلة مختارة بعناية من العبايات والجلابيب والحجاب تجمع بين الاحتشام والأناقة العصرية.</p>
<h2>قصتنا</h2>
<p>من البداية أردنا أن نكون وجهة تجدين فيها ملابس محتشمة ذات جودة دون تنازلات. نختار أقمشة وتصاميم تدوم ونعتني بكل التفاصيل لتسوقي بثقة.</p>
<p>سواء كنت تبحثين عن عباية كلاسيكية أو جلباب مريح أو حجاب متعدد الاستخدام، تشكيلتنا تُحدَّث بانتظام لتقديم الأفضل في الأزياء المحتشمة.</p>
<h2>قيمنا</h2>
<p><strong>الجودة</strong> — نختار مواد متينة وصناعة متقنة حتى تلبي كل قطعة توقعاتك.</p>
<p><strong>الأناقة والاحتشام</strong> — نؤمن بأنك تستطيعين أن تبدين أنيقة ومخلصة لقيمك. تصاميمنا تعكس هذا التوازن.</p>
<p><strong>العميلة أولاً</strong> — رضاك يهمنا. نحن هنا لمساعدتك في الطلبات والمقاسات وأي استفسار.</p>
<p><strong>توصيل موثوق</strong> — نشحن بعناية ونبقيك على اطلاع ليصل طلبك بأمان وفي الوقت المحدد.</p>
<h2>لماذا تختاريننا</h2>
<ul>
<li>تشكيلة واسعة من العبايات والجلابيب والحجاب لكل مناسبة.</li>
<li>أقمشة وتشطيبات عالية للراحة والمتانة.</li>
<li>دفع آمن وإرجاع بدون متاعب.</li>
<li>دعم عملاء ودود قبل الشراء وبعده.</li>
</ul>';

        $pages = [
            ['page_name' => 'About Us', 'page_slug' => 'about', 'page_content_en' => $aboutEn, 'page_content_ar' => $aboutAr],
            ['page_name' => 'Terms & Conditions', 'page_slug' => 'terms'],
            ['page_name' => 'Privacy Policy', 'page_slug' => 'privacy'],
            ['page_name' => 'Shipping Policy', 'page_slug' => 'shipping'],
            ['page_name' => 'Return & Refund Policy', 'page_slug' => 'return-refund'],
        ];

        foreach ($pages as $page) {
            $data = [
                'page_name' => $page['page_name'],
                'page_slug' => $page['page_slug'],
                'page_content_en' => $page['page_content_en'] ?? null,
                'page_content_ar' => $page['page_content_ar'] ?? null,
            ];
            PageContent::updateOrCreate(
                ['page_slug' => $page['page_slug']],
                $data
            );
        }
    }
}
