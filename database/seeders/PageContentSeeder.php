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

        $termsEn = '<p>Welcome to Mood Abaya. By using our website and placing orders for abayas, jilbabs, hijabs, and related products, you agree to these Terms &amp; Conditions. Please read them carefully.</p>
<h2>1. Use of the website</h2>
<p>You may use our site only for lawful purposes. You must not use it to distribute harmful content, attempt to gain unauthorised access to our systems, or interfere with other users. We reserve the right to suspend or terminate access if we believe these terms have been breached.</p>
<h2>2. Orders and contract</h2>
<p>When you place an order, you make an offer to buy the selected products. A contract is formed when we send you an order confirmation. We may refuse or cancel orders in case of errors, stock issues, or suspected fraud. Prices and availability are subject to change until the order is confirmed.</p>
<h2>3. Products and descriptions</h2>
<p>We strive to display our modest wear accurately. Colours and details may vary slightly due to your screen or photography. Product descriptions are not intended to be legally binding guarantees unless explicitly stated. Sizing guides are indicative; please refer to our size charts.</p>
<h2>4. Payment and pricing</h2>
<p>Prices are shown in the currency indicated on the site and include VAT where applicable unless stated otherwise. You are responsible for any customs or import duties. We accept the payment methods listed at checkout. Payment is taken at the time of order unless otherwise agreed.</p>
<h2>5. Shipping and delivery</h2>
<p>Delivery terms are set out in our <strong>Shipping Policy</strong>. Risk and ownership of the goods pass to you upon delivery. Delays due to customs or force majeure are outside our control.</p>
<h2>6. Returns and refunds</h2>
<p>Our <strong>Return &amp; Refund Policy</strong> explains your rights to return items and request refunds. By placing an order you acknowledge that you have read and accept that policy.</p>
<h2>7. Intellectual property</h2>
<p>All content on this site (text, images, logos, design) is owned by Mood Abaya or our licensors. You may not copy, reproduce, or use it for commercial purposes without our written permission.</p>
<h2>8. Limitation of liability</h2>
<p>We are not liable for indirect or consequential loss, or for loss of profit or data, arising from your use of the site or products. Our total liability in connection with any order is limited to the amount you paid for that order. Nothing in these terms excludes liability that cannot be excluded by law.</p>
<h2>9. Changes</h2>
<p>We may update these Terms &amp; Conditions from time to time. The version published on the site applies to your order. We encourage you to review this page periodically.</p>
<h2>10. Contact</h2>
<p>For questions about these terms, please use our <strong>Contact</strong> page or the details provided there.</p>';

        $termsAr = '<p>مرحباً بك في مود عباية. باستخدامك لموقعنا وطلب العبايات والجلابيب والحجاب والمنتجات ذات الصلة، فإنك توافق على هذه الشروط والأحكام. يرجى قراءتها بعناية.</p>
<h2>1. استخدام الموقع</h2>
<p>يجوز لك استخدام الموقع لأغراض قانونية فقط. لا يجوز استخدامه لتوزيع محتوى ضار أو محاولة الوصول غير المصرح به إلى أنظمتنا أو إعاقة المستخدمين الآخرين. نحتفظ بحق تعليق أو إنهاء الوصول إذا انتهكت هذه الشروط.</p>
<h2>2. الطلبات والعقد</h2>
<p>عند تقديم طلب، فإنك تقدّم عرضاً لشراء المنتجات المختارة. يتم إبرام العقد عند إرسالنا تأكيد الطلب. يجوز لنا رفض الطلبات أو إلغاؤها في حال وجود أخطاء أو نقص في المخزون أو اشتباه بالاحتيال. الأسعار والتوفر قابلة للتغيير حتى تأكيد الطلب.</p>
<h2>3. المنتجات والوصف</h2>
<p>نسعى لعرض ملابسنا المحتشمة بدقة. قد تختلف الألوان والتفاصيل قليلاً بسبب شاشتك أو التصوير. أوصاف المنتجات ليست ضمانات قانونية ما لم يُنص صراحة. أدلة المقاسات استرشادية؛ يرجى الرجوع إلى جداول المقاسات.</p>
<h2>4. الدفع والأسعار</h2>
<p>تُعرض الأسعار بالعملة المذكورة في الموقع وتشمل ضريبة القيمة المضافة حيث ينطبق ذلك ما لم يُذكر خلاف ذلك. أنت مسؤولة عن أي رسوم جمركية أو استيراد. نقبل طرق الدفع المعروضة عند الدفع. يتم خصم المبلغ عند الطلب ما لم يتفق على غير ذلك.</p>
<h2>5. الشحن والتوصيل</h2>
<p>شروط التوصيل منصوص عليها في <strong>سياسة الشحن</strong>. تنتقل المخاطر وملكية البضاعة إليك عند التسليم. التأخيرات الناتجة عن الجمارك أو القوة القاهرة خارجة عن إرادتنا.</p>
<h2>6. الإرجاع والاسترداد</h2>
<p>توضّح <strong>سياسة الإرجاع والاسترداد</strong> حقوقك في إرجاع المنتجات وطلب الاسترداد. بتقديم الطلب فإنك تقرّ بأنك قرأت تلك السياسة ووافقت عليها.</p>
<h2>7. الملكية الفكرية</h2>
<p>جميع المحتويات على هذا الموقع (نص، صور، شعارات، تصميم) مملوكة لمود عباية أو المرخصين لنا. لا يجوز نسخها أو إعادة إنتاجها أو استخدامها لأغراض تجارية دون إذننا الكتابي.</p>
<h2>8. تحديد المسؤولية</h2>
<p>نحن غير مسؤولين عن الخسائر غير المباشرة أو التبعية أو فقدان الربح أو البيانات الناتجة عن استخدامك للموقع أو المنتجات. مسؤوليتنا الإجمالية فيما يتعلق بأي طلب محدودة بمبلغ الطلب. لا شيء في هذه الشروط يستبعد المسؤولية التي لا يجوز استبعادها قانوناً.</p>
<h2>9. التعديلات</h2>
<p>قد نحدّث الشروط والأحكام من وقت لآخر. النسخة المنشورة على الموقع تنطبق على طلبك. نشجعك على مراجعة هذه الصفحة دورياً.</p>
<h2>10. التواصل</h2>
<p>للاستفسارات حول هذه الشروط، يرجى استخدام صفحة <strong>اتصل بنا</strong> أو التفاصيل المقدمة فيها.</p>';

        $privacyEn = '<p>At Mood Abaya we are committed to protecting your privacy. This policy explains how we collect, use, and safeguard your personal data when you visit our site or buy our modest wear (abayas, jilbabs, hijabs).</p>
<h2>1. Data we collect</h2>
<p>We may collect:</p>
<ul>
<li><strong>Account and order data:</strong> name, email, phone, billing and shipping address, order history.</li>
<li><strong>Payment data:</strong> processed securely by our payment providers; we do not store full card numbers.</li>
<li><strong>Usage data:</strong> IP address, browser type, device, pages visited, and similar technical information.</li>
<li><strong>Communications:</strong> messages you send to us (e.g. via contact form or support).</li>
</ul>
<h2>2. How we use your data</h2>
<p>We use your data to:</p>
<ul>
<li>Process and fulfil your orders and send shipping updates.</li>
<li>Manage your account and provide customer support.</li>
<li>Send order-related emails (confirmations, delivery, returns) and, if you have opted in, marketing (e.g. new collections, offers).</li>
<li>Improve our website, products, and services (e.g. analytics, testing).</li>
<li>Comply with legal obligations and protect our rights.</li>
</ul>
<h2>3. Legal basis</h2>
<p>We process your data on the basis of: performance of a contract (orders), consent (marketing, optional preferences), and legitimate interests (site security, analytics, improving our service) where permitted by law.</p>
<h2>4. Sharing your data</h2>
<p>We may share data with:</p>
<ul>
<li>Payment and shipping partners to complete your order.</li>
<li>Service providers (hosting, email, analytics) under strict confidentiality.</li>
<li>Authorities when required by law.</li>
</ul>
<p>We do not sell your personal data to third parties.</p>
<h2>5. Retention and security</h2>
<p>We keep your data only as long as needed for the purposes above (e.g. orders, legal requirements, disputes). We use appropriate technical and organisational measures to protect your data against unauthorised access, loss, or misuse.</p>
<h2>6. Your rights</h2>
<p>Depending on your location, you may have the right to: access your data, correct it, request deletion, restrict or object to processing, data portability, and to withdraw consent. You may also have the right to complain to a supervisory authority. To exercise these rights, contact us using the details on our Contact page.</p>
<h2>7. Cookies and tracking</h2>
<p>We use cookies and similar technologies for essential site operation, preferences, analytics, and (with consent) marketing. You can manage cookie preferences in your browser or via our cookie notice where provided.</p>
<h2>8. Changes and contact</h2>
<p>We may update this Privacy Policy from time to time. The current version is always on this page. For any privacy-related questions, please contact us via our Contact page.</p>';

        $privacyAr = '<p>في مود عباية نلتزم بحماية خصوصيتك. توضّح هذه السياسة كيف نجمع ونستخدم ونحمي بياناتك الشخصية عند زيارة موقعنا أو شراء ملابسنا المحتشمة (عبايات، جلابيب، حجاب).</p>
<h2>1. البيانات التي نجمعها</h2>
<p>قد نجمع:</p>
<ul>
<li><strong>بيانات الحساب والطلب:</strong> الاسم، البريد الإلكتروني، الهاتف، عنوان الفواتير والشحن، سجل الطلبات.</li>
<li><strong>بيانات الدفع:</strong> تُعالج بشكل آمن من قبل مزودي الدفع؛ لا نخزن أرقام البطاقات كاملة.</li>
<li><strong>بيانات الاستخدام:</strong> عنوان IP، نوع المتصفح، الجهاز، الصفحات المزارة، ومعلومات تقنية مشابهة.</li>
<li><strong>التواصل:</strong> الرسائل التي ترسلها إلينا (مثلاً عبر نموذج الاتصال أو الدعم).</li>
</ul>
<h2>2. كيف نستخدم بياناتك</h2>
<p>نستخدم بياناتك من أجل:</p>
<ul>
<li>معالجة طلباتك وتنفيذها وإرسال تحديثات الشحن.</li>
<li>إدارة حسابك وتقديم دعم العملاء.</li>
<li>إرسال رسائل مرتبطة بالطلب (التأكيد، التوصيل، الإرجاع)، وإذا وافقت، الرسائل التسويقية (مثلاً مجموعات جديدة، عروض).</li>
<li>تحسين موقعنا ومنتجاتنا وخدماتنا (مثلاً تحليلات، اختبارات).</li>
<li>الامتثال للالتزامات القانونية وحماية حقوقنا.</li>
</ul>
<h2>3. الأساس القانوني</h2>
<p>نعالج بياناتك على أساس: تنفيذ العقد (الطلبات)، الموافقة (التسويق، التفضيلات الاختيارية)، والمصالح المشروعة (أمن الموقع، التحليلات، تحسين الخدمة) حيث يسمح القانون.</p>
<h2>4. مشاركة بياناتك</h2>
<p>قد نشارك البيانات مع:</p>
<ul>
<li>شركاء الدفع والشحن لإتمام طلبك.</li>
<li>مزودي الخدمة (استضافة، بريد، تحليلات) بسرية تامة.</li>
<li>السلطات عند اقتضاء القانون.</li>
</ul>
<p>نحن لا نبيع بياناتك الشخصية لأطراف ثالثة.</p>
<h2>5. الاحتفاظ والأمان</h2>
<p>نحتفظ ببياناتك فقط طالما لزمت للأغراض أعلاه (مثلاً الطلبات، المتطلبات القانونية، النزاعات). نستخدم تدابير تقنية وتنظيمية مناسبة لحماية بياناتك من الوصول غير المصرح به أو الفقدان أو سوء الاستخدام.</p>
<h2>6. حقوقك</h2>
<p>حسب مكانك، قد يكون لديك الحق في: الوصول لبياناتك، تصحيحها، طلب الحذف، تقييد المعالجة أو الاعتراض عليها، نقل البيانات، وسحب الموافقة. قد يكون لديك أيضاً الحق في الشكوى إلى جهة رقابية. لممارسة هذه الحقوق، تواصل معنا باستخدام التفاصيل في صفحة اتصل بنا.</p>
<h2>7. ملفات تعريف الارتباط والتتبع</h2>
<p>نستخدم ملفات تعريف الارتباط وتقنيات مشابهة لتشغيل الموقع الأساسي، التفضيلات، التحليلات، و(بموافقتك) التسويق. يمكنك إدارة تفضيلات ملفات تعريف الارتباط في متصفحك أو عبر إشعار الملفات حيث يُقدّم.</p>
<h2>8. التعديلات والتواصل</h2>
<p>قد نحدّث سياسة الخصوصية من وقت لآخر. النسخة الحالية دائماً على هذه الصفحة. لأي أسئلة متعلقة بالخصوصية، يرجى التواصل معنا عبر صفحة اتصل بنا.</p>';

        $shippingEn = '<p>At Mood Abaya we want your abayas, jilbabs, and hijabs to reach you safely and on time. This policy explains how we ship, delivery times, and what to expect.</p>
<h2>1. Shipping areas</h2>
<p>We currently ship to the countries and regions listed at checkout. If your country is not listed, please contact us—we may be able to arrange delivery in some cases. Shipping options and costs depend on your location and the size of your order.</p>
<h2>2. Processing time</h2>
<p>Orders are processed within <strong>1–3 business days</strong> (excluding weekends and public holidays). During busy periods (e.g. Ramadan, new collections) processing may take slightly longer. You will receive an email when your order has been dispatched.</p>
<h2>3. Delivery times</h2>
<p>Estimated delivery times from dispatch:</p>
<ul>
<li><strong>Local (same country):</strong> typically 2–5 business days.</li>
<li><strong>Regional:</strong> typically 5–10 business days.</li>
<li><strong>International:</strong> typically 7–21 business days, depending on destination and customs.</li>
</ul>
<p>These are estimates only. Delays can occur due to customs, weather, or carrier issues. We will keep you informed if we are notified of significant delays.</p>
<h2>4. Shipping costs</h2>
<p>Shipping costs are calculated at checkout based on destination and order weight. We may offer free shipping above a certain order value—details are shown on the site and at checkout. Any customs, taxes, or import duties are the responsibility of the recipient unless otherwise stated.</p>
<h2>5. Tracking</h2>
<p>Once your order is shipped, we will send you a tracking number and link (where available) so you can follow your delivery. If you do not receive a tracking email within the expected processing time, please check your spam folder or contact us.</p>
<h2>6. Receiving your order</h2>
<p>Please ensure someone is available to receive the delivery at the address given. If a delivery attempt fails, the carrier may leave a notice or attempt redelivery according to their policy. Unclaimed parcels may be returned to us, and we will contact you to arrange reshipment (additional costs may apply).</p>
<h2>7. Lost or damaged items</h2>
<p>If your order is lost in transit or arrives damaged, contact us as soon as possible with your order number and, if applicable, photos. We will work with the carrier to resolve the issue and, where appropriate, send a replacement or offer a refund in line with our Return &amp; Refund Policy.</p>
<h2>8. Contact</h2>
<p>For shipping questions or to change an address before dispatch, please contact us via our Contact page. We are here to help.</p>';

        $shippingAr = '<p>في مود عباية نريد أن تصل إليك العبايات والجلابيب والحجاب بأمان وفي الوقت المحدد. توضّح هذه السياسة كيف نشحن، أوقات التوصيل، وما يمكن توقعه.</p>
<h2>1. مناطق الشحن</h2>
<p>نشحن حالياً إلى الدول والمناطق المدرجة عند الدفع. إذا لم تكن دولتك مدرجة، يرجى التواصل معنا—قد نتمكن من ترتيب التوصيل في بعض الحالات. خيارات وتكاليف الشحن تعتمد على موقعك وحجم طلبك.</p>
<h2>2. وقت المعالجة</h2>
<p>يتم معالجة الطلبات خلال <strong>1–3 أيام عمل</strong> (باستثناء عطلة نهاية الأسبوع والعطل الرسمية). في الفترات المزدحمة (مثلاً رمضان، مجموعات جديدة) قد تستغرق المعالجة وقتاً أطول قليلاً. ستتلقى بريداً إلكترونياً عند شحن طلبك.</p>
<h2>3. أوقات التوصيل</h2>
<p>أوقات التوصيل التقريبية من تاريخ الشحن:</p>
<ul>
<li><strong>محلي (نفس البلد):</strong> عادة 2–5 أيام عمل.</li>
<li><strong>إقليمي:</strong> عادة 5–10 أيام عمل.</li>
<li><strong>دولي:</strong> عادة 7–21 يوماً عمل، حسب الوجهة والجمارك.</li>
</ul>
<p>هذه تقديرات فقط. قد يحدث التأخير بسبب الجمارك أو الطقس أو شركة الشحن. سنبقيك على اطلاع إذا علمنا بتأخير كبير.</p>
<h2>4. تكاليف الشحن</h2>
<p>تُحسب تكاليف الشحن عند الدفع حسب الوجهة ووزن الطلب. قد نقدّم شحن مجاني فوق قيمة طلب معينة—التفاصيل معروضة في الموقع وعند الدفع. أي جمارك أو ضرائب أو رسوم استيراد هي مسؤولية المستلم ما لم يُذكر خلاف ذلك.</p>
<h2>5. التتبع</h2>
<p>بمجرد شحن طلبك، سنرسل لك رقم تتبع ورابط (حيثما متاح) لمتابعة التوصيل. إذا لم تتلقَ بريد التتبع خلال وقت المعالجة المتوقع، يرجى التحقق من مجلد الرسائل غير المرغوبة أو التواصل معنا.</p>
<h2>6. استلام الطلب</h2>
<p>يرجى التأكد من وجود شخص لاستلام الشحنة في العنوان المذكور. إذا فشلت محاولة التوصيل، قد تترك شركة الشحن إشعاراً أو تعيد المحاولة حسب سياستها. الطرود غير المطالَب بها قد تُعاد إلينا، وسنتواصل معك لترتيب إعادة الشحن (قد تنطبق تكاليف إضافية).</p>
<h2>7. الضائع أو التالف</h2>
<p>إذا فُقد طلبك في الطريق أو وصل تالفاً، تواصل معنا في أقرب وقت مع رقم الطلب، وإذا أمكن، صور. سنتعاون مع شركة الشحن لحل المشكلة، وحيثما يناسب، إرسال بديل أو استرداد وفق سياسة الإرجاع والاسترداد.</p>
<h2>8. التواصل</h2>
<p>لأسئلة الشحن أو لتغيير العنوان قبل الشحن، يرجى التواصل معنا عبر صفحة اتصل بنا. نحن هنا لمساعدتك.</p>';

        $returnEn = '<p>We want you to be happy with your purchase from Mood Abaya. If you need to return an abaya, jilbab, hijab, or any other item, this policy explains how returns and refunds work.</p>
<h2>1. Return eligibility</h2>
<p>You may return most items within <strong>14 days</strong> of delivery, provided they are:</p>
<ul>
<li>Unworn, unwashed, and in original condition with tags attached.</li>
<li>In original packaging where applicable.</li>
</ul>
<p>Items that are personalised, made to order, or marked as final sale may not be eligible for return. Please check the product page or contact us if unsure.</p>
<h2>2. How to start a return</h2>
<p>Contact us via our Contact page or email with your order number and the item(s) you wish to return. We will send you return instructions and, where applicable, a return label or authorisation code. Do not send items back without our approval, as we may not be able to process unauthorised returns.</p>
<h2>3. Sending the item back</h2>
<p>Pack the item securely in its original packaging if possible. Include the order confirmation or a note with your order number and reason for return. Send the parcel using a trackable method and keep proof of postage. Return shipping costs are the customer’s responsibility unless the item is faulty or we have stated otherwise.</p>
<h2>4. Inspection and refund</h2>
<p>Once we receive the return, we will inspect the item within a few business days. If it meets our return conditions, we will process your refund to the original payment method. Refunds may take 5–10 business days to appear in your account, depending on your bank or card provider. We will notify you by email when the refund has been processed.</p>
<h2>5. Exchanges</h2>
<p>If you would like a different size, colour, or style, we recommend returning the original item for a refund and placing a new order. This is often faster than arranging an exchange. If you prefer an exchange, contact us and we will do our best to accommodate you subject to stock availability.</p>
<h2>6. Faulty or incorrect items</h2>
<p>If you receive a faulty item or the wrong product, contact us immediately with your order number and photos if relevant. We will arrange a replacement or full refund, including return shipping where appropriate. We apologise for any inconvenience.</p>
<h2>7. Non-returnable items</h2>
<p>For hygiene and safety reasons, certain items (e.g. intimate wear, unless faulty) may not be returnable. This will be stated on the product page. Sale items may have different return terms—please check at time of purchase.</p>
<h2>8. Contact</h2>
<p>For any return or refund questions, please contact us via our Contact page. We are here to help and will respond as quickly as possible.</p>';

        $returnAr = '<p>نريدك أن تكوني راضية عن مشترياتك من مود عباية. إذا احتجت إرجاع عباية أو جلباب أو حجاب أو أي منتج آخر، توضّح هذه السياسة كيف يعمل الإرجاع والاسترداد.</p>
<h2>1. أهلية الإرجاع</h2>
<p>يمكنك إرجاع معظم المنتجات خلال <strong>14 يوماً</strong> من الاستلام، بشرط أن تكون:</p>
<ul>
<li>غير مستخدمة، غير مغسولة، وبحالة أصلية مع البطاقات المرفقة.</li>
<li>في التغليف الأصلي حيث ينطبق.</li>
</ul>
<p>المنتجات المخصصة أو المصنوعة حسب الطلب أو المعلمة كبيع نهائي قد لا تكون قابلة للإرجاع. يرجى التحقق من صفحة المنتج أو التواصل معنا إذا كنت غير متأكدة.</p>
<h2>2. كيف تبدأين الإرجاع</h2>
<p>تواصلي معنا عبر صفحة اتصل بنا أو البريد الإلكتروني مع رقم الطلب والمنتج(ات) التي ترغبين في إرجاعها. سنرسل لك تعليمات الإرجاع، وحيث ينطبق، ملصق إرجاع أو رمز تصريح. لا ترسلي المنتجات دون موافقتنا، إذ قد لا نتمكن من معالجة الإرجاعات غير المصرح بها.</p>
<h2>3. إرسال المنتج</h2>
<p>عبّئي المنتج بشكل آمن في تغليفه الأصلي إن أمكن. أرفقي تأكيد الطلب أو ملاحظة برقم الطلب وسبب الإرجاع. أرسلي الطرد بطريقة قابلة للتتبع واحتفظي بإثبات الإرسال. تكاليف شحن الإرجاع على العميلة ما لم يكن المنتج معيباً أو ذكرنا غير ذلك.</p>
<h2>4. الفحص والاسترداد</h2>
<p>بمجرد استلامنا للإرجاع، سنفحص المنتج خلال أيام عمل قليلة. إذا استوفى شروط الإرجاع، سنعالج الاسترداد إلى طريقة الدفع الأصلية. قد يستغرق الاسترداد 5–10 أيام عمل ليظهر في حسابك حسب البنك أو مزود البطاقة. سنعلمك بالبريد الإلكتروني عند معالجة الاسترداد.</p>
<h2>5. الاستبدال</h2>
<p>إذا أردت مقاساً أو لوناً أو طرازاً مختلفاً، ننصح بإرجاع المنتج الأصلي لاسترداد المبلغ وطلب جديد. هذا غالباً أسرع من ترتيب استبدال. إذا فضلت الاستبدال، تواصلي معنا وسنبذل جهدنا لمساعدتك حسب توفر المخزون.</p>
<h2>6. المنتج المعيب أو الخاطئ</h2>
<p>إذا استلمت منتجاً معيباً أو خاطئاً، تواصلي معنا فوراً مع رقم الطلب والصور إن وجدت. سنرتب بديلاً أو استرداداً كاملاً، بما في ذلك شحن الإرجاع حيث يناسب. نعتذر عن أي إزعاج.</p>
<h2>7. منتجات غير قابلة للإرجاع</h2>
<p>لأسباب صحية وأمنية، بعض المنتجات (مثلاً ملابس داخلية، ما لم تكن معيبة) قد لا تكون قابلة للإرجاع. سيُذكر ذلك في صفحة المنتج. منتجات التخفيض قد يكون لها شروط إرجاع مختلفة—يرجى التحقق عند الشراء.</p>
<h2>8. التواصل</h2>
<p>لأي استفسارات حول الإرجاع أو الاسترداد، يرجى التواصل معنا عبر صفحة اتصل بنا. نحن هنا لمساعدتك وسنرد في أقرب وقت ممكن.</p>';

        $pages = [
            ['page_name' => 'About Us', 'page_slug' => 'about', 'page_content_en' => $aboutEn, 'page_content_ar' => $aboutAr],
            ['page_name' => 'Terms & Conditions', 'page_slug' => 'terms', 'page_content_en' => $termsEn, 'page_content_ar' => $termsAr],
            ['page_name' => 'Privacy Policy', 'page_slug' => 'privacy', 'page_content_en' => $privacyEn, 'page_content_ar' => $privacyAr],
            ['page_name' => 'Shipping Policy', 'page_slug' => 'shipping', 'page_content_en' => $shippingEn, 'page_content_ar' => $shippingAr],
            ['page_name' => 'Return & Refund Policy', 'page_slug' => 'return-refund', 'page_content_en' => $returnEn, 'page_content_ar' => $returnAr],
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
