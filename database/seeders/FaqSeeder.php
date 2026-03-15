<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'question_en' => 'How long does shipping take?',
                'question_ar' => 'كم يستغرق التوصيل؟',
                'answer_en' => 'We ship across the region within 3–7 business days. You will receive a tracking link once your order is dispatched.',
                'answer_ar' => 'نشحن في أنحاء المنطقة خلال 3–7 أيام عمل. ستستلمين رابط التتبع بعد شحن طلبك.',
                'sort_order' => 0,
            ],
            [
                'question_en' => 'What is your return policy?',
                'question_ar' => 'ما سياسة الإرجاع؟',
                'answer_en' => 'You can return unworn items in original condition within 14 days of delivery. Contact us to start a return and we will guide you through the process.',
                'answer_ar' => 'يمكنك إرجاع القطع غير المستخدمة وبحالة أصلية خلال 14 يوماً من الاستلام. تواصلي معنا لبدء الإرجاع وسنرشدك خلال الخطوات.',
                'sort_order' => 1,
            ],
            [
                'question_en' => 'How can I pay for my order?',
                'question_ar' => 'كيف أدفع ثمن طلبي؟',
                'answer_en' => 'We accept payment by card at checkout and bank transfer. For bank transfer you will receive our account details after placing the order.',
                'answer_ar' => 'نقبل الدفع بالبطاقة عند إتمام الطلب والتحويل البنكي. للتحويل البنكي ستستلمين تفاصيل الحساب بعد تقديم الطلب.',
                'sort_order' => 2,
            ],
            [
                'question_en' => 'Do you ship internationally?',
                'question_ar' => 'هل تشحنون دولياً؟',
                'answer_en' => 'We currently ship within the Kingdom and the Gulf region. If you are elsewhere, contact us and we will do our best to arrange delivery.',
                'answer_ar' => 'نشحن حالياً داخل المملكة ومنطقة الخليج. إن كنتي من مكان آخر، تواصلي معنا وسنبذل جهدنا لترتيب التوصيل.',
                'sort_order' => 3,
            ],
        ];

        foreach ($items as $item) {
            Faq::updateOrCreate(
                ['question_en' => $item['question_en']],
                array_merge($item, ['is_active' => true])
            );
        }
    }
}
