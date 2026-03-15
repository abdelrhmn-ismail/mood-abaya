<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * Seeds blog posts for Mood Abaya (abayas, jilbabs, hijabs, modest fashion).
 * Content in English and Arabic. Each post has a placeholder image.
 */
class PostSeeder extends Seeder
{
    use CreatesTestImages;

    public function run(): void
    {
        $posts = [
            [
                'title' => [
                    'en' => 'How to Care for Your Abaya: Washing, Storage & Longevity',
                    'ar' => 'كيف تعتنين بعبايتك: الغسيل والتخزين والبقاء طويلاً',
                ],
                'slug' => 'how-to-care-for-your-abaya',
                'excerpt' => [
                    'en' => 'Simple tips to keep your abaya looking new: fabric care, washing, and storage so it lasts for years.',
                    'ar' => 'نصائح بسيطة لإبقاء عبايتك كالجديدة: العناية بالقماش والغسيل والتخزين لتدوم سنوات.',
                ],
                'body' => [
                    'en' => '<p>Your abaya is an investment in both style and modesty. With the right care, it can stay elegant and durable for many seasons.</p>
<h2>Washing your abaya</h2>
<p>Always check the care label first. Most abayas benefit from <strong>cold or lukewarm water</strong> and a gentle cycle. Use a mild detergent and avoid bleach. For delicate embroidery or embellishments, hand washing or a delicate machine cycle is best. Turn the abaya inside out to protect the outer surface.</p>
<h2>Drying and ironing</h2>
<p>Air-dry away from direct sunlight to prevent fading. If you use a dryer, choose a low heat setting. Iron on the reverse side or use a pressing cloth to avoid shine on dark fabrics.</p>
<h2>Storage</h2>
<p>Store in a cool, dry place. Use padded hangers to keep the shape, or fold neatly in a drawer. Avoid overcrowding so the fabric can breathe and creases stay minimal.</p>
<p>With these steps, your abaya will remain a staple of your wardrobe for years to come.</p>',
                    'ar' => '<p>عبايتك استثمار في الأناقة والاحتشام. بالعناية الصحيحة تبقى أنيقة ومتينة لعدة مواسم.</p>
<h2>غسل العباية</h2>
<p>تحققي دائماً من بطاقة العناية أولاً. معظم العبايات تناسبها <strong>الماء البارد أو الفاتر</strong> ودورة غسيل لطيفة. استخدمي منظفاً لطيفاً وتجنبي المبيض. للتطريز أو الزخارف الحساسة، الغسل اليدوي أو دورة delicate في الغسالة أفضل. اقلبي العباية على ظهرها لحماية السطح الخارجي.</p>
<h2>التجفيف والكوي</h2>
<p>جففيها في الهواء بعيداً عن أشعة الشمس المباشرة لمنع البهوت. إن استخدمت المجفف فاختاري حرارة منخفضة. اكتوي على الجهة الداخلية أو استخدمي قطعة قماش للكوي لتجنب اللمعة على الأقمشة الداكنة.</p>
<h2>التخزين</h2>
<p>خزنيها في مكان بارد وجاف. استخدمي علاقات مبطنة للحفاظ على الشكل، أو اطويها بدقة في درج. تجنبي الازدحام حتى يتنفس القماش وتقل التجاعيد.</p>
<p>بهذه الخطوات ستبقى عبايتك أساسية في خزانتك لسنوات.</p>',
                ],
                'meta_title' => [
                    'en' => 'Abaya Care Guide – Washing, Drying & Storage | Mood Abaya',
                    'ar' => 'دليل العناية بالعباية – الغسيل والتجفيف والتخزين | مود عباية',
                ],
                'meta_description' => [
                    'en' => 'Learn how to wash, dry, and store your abaya so it stays in great condition. Simple care tips for modest wear.',
                    'ar' => 'تعلمي كيف تغسلين وتجففين وتخزنين عبايتك لتبقى بحالة ممتازة. نصائح عناية بسيطة للملابس المحتشمة.',
                ],
            ],
            [
                'title' => [
                    'en' => '5 Styling Ideas for Your Jilbab This Season',
                    'ar' => '5 أفكار لانتقاء جلبابك هذا الموسم',
                ],
                'slug' => '5-styling-ideas-for-your-jilbab',
                'excerpt' => [
                    'en' => 'From casual to occasion wear: easy ways to style your jilbab with hijabs and accessories.',
                    'ar' => 'من الكاجوال إلى المناسبات: طرق سهلة لانتقاء جلبابك مع الحجاب والإكسسوارات.',
                ],
                'body' => [
                    'en' => '<p>The jilbab is one of the most versatile pieces in modest fashion. Here are five ways to wear it for different occasions.</p>
<h2>1. Casual everyday look</h2>
<p>Pair a neutral or pastel jilbab with a simple undercap and a matching hijab. Add minimal jewellery and comfortable flats for a relaxed, put-together look.</p>
<h2>2. Office-ready</h2>
<p>Choose a tailored jilbab in a solid colour. A structured hijab style and a small handbag keep the look professional and modest.</p>
<h2>3. Evening and events</h2>
<p>Opt for a jilbab in a rich fabric or subtle print. Layer with a decorative hijab and understated accessories for an elegant evening outfit.</p>
<h2>4. Layered for cooler weather</h2>
<p>Wear a long-sleeve top underneath and add a lightweight scarf or shawl. Boots and a crossbody bag complete the look.</p>
<h2>5. Minimal and modern</h2>
<p>Stick to one colour from jilbab to hijab. Clean lines and simple accessories give a modern, modest aesthetic.</p>
<p>Mix and match these ideas to suit your personal style and the season.</p>',
                    'ar' => '<p>الجلباب من أكثر القطع تنوعاً في الأزياء المحتشمة. إليك خمس طرق لارتدائه في مناسبات مختلفة.</p>
<h2>1. إطلالة كاجوال يومية</h2>
<p>زوجي جلباباً بلون محايد أو pastel مع غطاء رأس بسيط وحجاب متناسق. أضيفي إكسسوارات قليلة وفلوت مريح لمظهر مرتاح ومنسق.</p>
<h2>2. جاهز للمكتب</h2>
<p>اختاري جلباباً بتفصيل أنيق ولون واحد. طراز حجاب منظم وحقيبة يد صغيرة يبقيان المظهر مهنياً ومحتشماً.</p>
<h2>3. المساء والمناسبات</h2>
<p>اختاري جلباباً من قماش غني أو طباعة خفيفة. طبقي مع حجاب زخرفي وإكسسوارات بسيطة لإطلالة مسائية أنيقة.</p>
<h2>4. متعدد الطبقات للطقس البارد</h2>
<p>ارتدي بلوزة طويلة الأكمام تحته وأضيفي وشاحاً أو شالاً خفيفاً. الحذاء الطويل وحقيبة الكتف تكملان الإطلالة.</p>
<h2>5. بسيط وعصري</h2>
<p>التزمي بلون واحد من الجلباب إلى الحجاب. خطوط نظيفة وإكسسوارات بسيطة تعطي جمالية عصرية محتشمة.</p>
<p>امزجي هذه الأفكار وطابقيها مع أسلوبك الشخصي والموسم.</p>',
                ],
                'meta_title' => [
                    'en' => '5 Jilbab Styling Ideas – Casual to Occasion | Mood Abaya',
                    'ar' => '5 أفكار لانتقاء الجلباب – من الكاجوال للمناسبات | مود عباية',
                ],
                'meta_description' => [
                    'en' => 'Discover five easy ways to style your jilbab for everyday, work, and special occasions. Modest fashion tips.',
                    'ar' => 'اكتشفي خمس طرق سهلة لانتقاء جلبابك لليومي والعمل والمناسبات. نصائح أزياء محتشمة.',
                ],
            ],
            [
                'title' => [
                    'en' => 'Modest Fashion Trends: What\'s In for Abayas & Hijabs',
                    'ar' => 'اتجاهات الأزياء المحتشمة: ما هو رائج للعبايات والحجاب',
                ],
                'slug' => 'modest-fashion-trends-abayas-hijabs',
                'excerpt' => [
                    'en' => 'A quick look at this season\'s modest fashion trends: colours, cuts, and hijab styles that are in demand.',
                    'ar' => 'نظرة سريعة على اتجاهات الأزياء المحتشمة هذا الموسم: الألوان والقصات وطرز الحجاب المطلوبة.',
                ],
                'body' => [
                    'en' => '<p>Modest fashion continues to evolve with new colours, silhouettes, and details. Here\'s what\'s trending for abayas and hijabs right now.</p>
<h2>Colours and fabrics</h2>
<p><strong>Earthy tones</strong>—olive, terracotta, sand, and muted greens—are everywhere. They pair well with classic black and navy. Lightweight, breathable fabrics like linen blends and soft cotton are favoured for comfort and durability.</p>
<h2>Abaya silhouettes</h2>
<p>Relaxed, flowing cuts remain popular, along with slightly fitted options that define the waist. Details like side slits, subtle pleats, and minimal embroidery add interest without overwhelming the design.</p>
<h2>Hijab styles</h2>
<p>Wide, draped styles and voluminous wraps are in. So are neutral and tonal looks: hijab and outfit in the same colour family for a clean, modern feel. Understated pins and caps keep the focus on the fabric and drape.</p>
<h2>Accessories</h2>
<p>Simple belts, structured bags, and quality footwear complete the look. Less is often more in modest fashion—one or two well-chosen pieces make a strong statement.</p>
<p>At Mood Abaya we keep our collection aligned with these trends while staying true to modesty and quality.</p>',
                    'ar' => '<p>الأزياء المحتشمة تتطور بألوان وتخليلات وتفاصيل جديدة. هذا ما ينتشر الآن للعبايات والحجاب.</p>
<h2>الألوان والأقمشة</h2>
<p><strong>الألوان الأرضية</strong>—الزيتوني والتراكوتا والرملي والأخضر الهادئ—في كل مكان. تتوافق جيداً مع الأسود والأزرق البحري الكلاسيكيين. أقمشة خفيفة وتنفس مثل مزيج الكتان والقطن الناعم مفضلة للراحة والمتانة.</p>
<h2>تخليلات العباية</h2>
<p>القطع المريحة المتدفقة لا تزال رائجة، مع خيارات شبه ملتصقة تحدد الخصر. تفاصيل مثل الشقوق الجانبية والطيات الخفيفة والتطريز البسيط تضيف اهتماماً دون إثقال التصميم.</p>
<h2>طرز الحجاب</h2>
<p>الطرز الواسعة المتدلية واللفات الضخمة رائجة. وكذلك المظهر المحايد واللوني: حجاب وملابس من نفس العائلة اللونية لمظهر نظيف وعصري. دبابيس وقبعات بسيطة تبقي التركيز على القماش وال drape.</p>
<h2>الإكسسوارات</h2>
<p>أحزمة بسيطة وحقائب منظمة وأحذية ذات جودة تكمل الإطلالة. الأقل غالباً أفضل في الأزياء المحتشمة—قطعة أو اثنتان مختارتان جيداً تقدمان رسالة قوية.</p>
<p>في مود عباية نحافظ على توافق مجموعتنا مع هذه الاتجاهات مع الالتزام بالاحتشام والجودة.</p>',
                ],
                'meta_title' => [
                    'en' => 'Modest Fashion Trends – Abayas & Hijabs | Mood Abaya',
                    'ar' => 'اتجاهات الأزياء المحتشمة – العبايات والحجاب | مود عباية',
                ],
                'meta_description' => [
                    'en' => 'Explore current modest fashion trends: colours, silhouettes, and hijab styles. Stay stylish and modest with Mood Abaya.',
                    'ar' => 'استكشفي اتجاهات الأزياء المحتشمة الحالية: الألوان والتخليلات وطرز الحجاب. كوني أنيقة ومحتشمة مع مود عباية.',
                ],
            ],
            [
                'title' => [
                    'en' => 'Hijab Styling Tips: Drapes, Colours & Occasions',
                    'ar' => 'نصائح لانتقاء الحجاب: الطيات والألوان والمناسبات',
                ],
                'slug' => 'hijab-styling-tips-drapes-colours',
                'excerpt' => [
                    'en' => 'Practical hijab styling tips: how to choose colours, achieve neat drapes, and match your outfit.',
                    'ar' => 'نصائح عملية لانتقاء الحجاب: كيف تختارين الألوان وتحققين طيات أنيقة وتطابقين ملابسك.',
                ],
                'body' => [
                    'en' => '<p>Whether you\'re new to hijab or looking to refresh your style, these tips will help you feel confident and put-together.</p>
<h2>Choosing the right colour</h2>
<p>Match your hijab to your outfit for a cohesive look, or use a complementary shade for contrast. Neutrals (black, grey, beige, navy) go with almost everything. For a pop of colour, try one bold hijab with an otherwise neutral outfit.</p>
<h2>Fabric and drape</h2>
<p>Lightweight jersey and chiffon are easy to drape and comfortable for long wear. For a fuller, more structured look, use a slightly larger piece and experiment with folds. A good undercap keeps the hijab in place and adds volume if you like it.</p>
<h2>Neat and secure</h2>
<p>Pin at the shoulder or under the chin to avoid slipping. Use pins that match the fabric so they stay discreet. Adjust the drape so it\'s even on both sides for a balanced look.</p>
<h2>By occasion</h2>
<p><strong>Everyday:</strong> Simple wrap, neutral colour, minimal pins.<br><strong>Work:</strong> Tidy drape, solid colours, professional and polished.<br><strong>Special events:</strong> Softer drapes, subtle prints or textures, and accessories that don\'t overwhelm.</p>
<p>With a bit of practice, you\'ll find the styles that suit you best.</p>',
                    'ar' => '<p>سواء كنت جديدة في الحجاب أو تريدين تجديد إطلالتك، هذه النصائح ستساعدك على الشعور بالثقة والأناقة.</p>
<h2>اختيار اللون المناسب</h2>
<p>طابقي حجابك مع ملابسك لمظهر متجانس، أو استخدمي لوناً مكملاً للتباين. المحايدات (أسود، رمادي، بيج، أزرق بحري) تناسب كل شيء تقريباً. للمسة لون جريئة، جربي حجاباً واحداً بلون قوي مع ملابس محايدة.</p>
<h2>القماش والطيات</h2>
<p>الجيرسي والشيفون الخفيفان سهلان في التشكيل ومريحان للارتداء الطويل. لمظهر أكثر امتلاءً وبنية، استخدمي قطعة أكبر قليلاً وجربي الطيات. غطاء رأس جيد يثبت الحجاب ويضيف حجماً إن أحببت.</p>
<h2>أنيق وثابت</h2>
<p>ثبتي عند الكتف أو تحت الذقن لتجنب الانزلاق. استخدمي دبابيس تتناسب مع القماش لتبقى غير لافتة. عدلي الطية لتكون متساوية من الجانبين لمظهر متوازن.</p>
<h2>حسب المناسبة</h2>
<p><strong>يومي:</strong> لف بسيط، لون محايد، دبابيس قليلة.<br><strong>عمل:</strong> طية مرتبة، ألوان solid، مظهر مهني مصقول.<br><strong>مناسبات خاصة:</strong> طيات أنعم، طباعات أو ملمس خفيف، وإكسسوارات لا تطغى.</p>
<p>بقليل من الممارسة ستجدين الطرز التي تناسبك أكثر.</p>',
                ],
                'meta_title' => [
                    'en' => 'Hijab Styling Tips – Drapes, Colours & Occasions | Mood Abaya',
                    'ar' => 'نصائح انتقاء الحجاب – الطيات والألوان والمناسبات | مود عباية',
                ],
                'meta_description' => [
                    'en' => 'Hijab styling guide: colours, fabrics, draping, and looks for everyday, work, and special occasions.',
                    'ar' => 'دليل انتقاء الحجاب: الألوان والأقمشة والطيات وإطلالات لليومي والعمل والمناسبات.',
                ],
            ],
            [
                'title' => [
                    'en' => 'Why Choose a Quality Abaya? Quality vs. Fast Fashion',
                    'ar' => 'لماذا تختارين عباية عالية الجودة؟ الجودة مقابل الموضة السريعة',
                ],
                'slug' => 'why-choose-quality-abaya-vs-fast-fashion',
                'excerpt' => [
                    'en' => 'Investing in a well-made abaya pays off in fit, fabric, and longevity. Here\'s why quality matters.',
                    'ar' => 'الاستثمار في عباية مصنوعة جيداً ينجح في المقاس والقماش والبقاء. لماذا الجودة مهمة.',
                ],
                'body' => [
                    'en' => '<p>Not all abayas are created equal. Choosing a quality piece can mean better fit, comfort, and durability—and often better value over time.</p>
<h2>Fabric and construction</h2>
<p>Quality abayas use fabrics that hold their shape and colour after washing. Stitching is even and secure; hems and finishes are neat. This means fewer loose threads, less pilling, and a garment that looks good wear after wear.</p>
<h2>Fit and comfort</h2>
<p>Well-designed abayas consider ease of movement and coverage. The cut is consistent, and sizing is reliable. You spend less time returning or exchanging and more time feeling confident.</p>
<h2>Longevity and cost per wear</h2>
<p>A single quality abaya can last for years with proper care. Cheaper options may need replacing every season. When you divide the price by the number of times you wear it, a higher initial cost often works out better in the long run.</p>
<h2>Sustainability</h2>
<p>Buying fewer, better-made pieces reduces waste and supports more responsible production. At Mood Abaya we focus on durable materials and careful craftsmanship so you can build a modest wardrobe that lasts.</p>
<p>When you choose quality, you invest in both your style and your values.</p>',
                    'ar' => '<p>ليست كل العبايات متساوية. اختيار قطعة عالية الجودة يعني مقاساً أفضل وراحة ومتانة—وفي الغالب قيمة أفضل مع الوقت.</p>
<h2>القماش والصناعة</h2>
<p>العبايات الجيدة تستخدم أقمشة تحافظ على شكلها ولونها بعد الغسيل. الخياطة متسقة وآمنة؛ الهيم والتشطيبات أنيقة. هذا يعني خيوطاً أقل تفككاً وأقل تكوّن كرات، وقطعة تبدو جيدة ارتداء بعد ارتداء.</p>
<h2>المقاس والراحة</h2>
<p>العبايات المصممة جيداً تراعي سهولة الحركة والغطاء. القص متناسق والمقاسات موثوقة. تقضين وقتاً أقل في الإرجاع والاستبدال ووقتاً أكثر في الشعور بالثقة.</p>
<h2>البقاء وتكلفة كل ارتداء</h2>
<p>عباية واحدة عالية الجودة يمكن أن تدوم سنوات مع العناية الصحيحة. الخيارات الأرخص قد تحتاج استبدالاً كل موسم. عندما تقسمين السعر على عدد مرات الارتداء، التكلفة الأولية الأعلى غالباً أفضل على المدى الطويل.</p>
<h2>الاستدامة</h2>
<p>شراء قطع أقل وأفضل صنعة يقلل الهدر ويدعم إنتاجاً أكثر مسؤولية. في مود عباية نركز على مواد متينة وصناعة متقنة لتتمكني من بناء خزانة محتشمة تدوم.</p>
<p>عندما تختارين الجودة، تستثمرين في أسلوبك وقيمك معاً.</p>',
                ],
                'meta_title' => [
                    'en' => 'Why Choose a Quality Abaya? | Mood Abaya',
                    'ar' => 'لماذا تختارين عباية عالية الجودة؟ | مود عباية',
                ],
                'meta_description' => [
                    'en' => 'Quality vs fast fashion: why a well-made abaya is worth the investment. Fabric, fit, and longevity.',
                    'ar' => 'الجودة مقابل الموضة السريعة: لماذا عباية مصنوعة جيداً تستحق الاستثمار. القماش والمقاس والبقاء.',
                ],
            ],
        ];

        foreach ($posts as $data) {
            $slug = $data['slug'];
            $imagePath = $this->createTestImage('posts', $slug);
            $post = Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'body' => $data['body'],
                    'image' => $imagePath,
                    'published_at' => now()->subDays(rand(5, 90)),
                    'meta_title' => $data['meta_title'],
                    'meta_description' => $data['meta_description'],
                ]
            );
        }
    }
}
