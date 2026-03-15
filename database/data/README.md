# Salla store import data

Full product data from **[Mood.Design on Salla](https://salla.sa/moodabaya)** is kept in `salla-moodabaya-products.json`.

## Why only one product?

The store’s product list is loaded by JavaScript. Automated fetching only got the single product page:

- **Product page:** [عباية كريب بقصّة واسعة مع كسرات خلفية ودانتيل](https://salla.sa/moodabaya/yKxaaNa)

So only that product’s full data (title, price, description, stock status) could be extracted. The rest of the catalog wasn’t available from the public HTML.

## How to add more products

1. **From Salla admin**  
   Export products (if your plan supports it) or copy name, description, price, SKU, and image URLs for each product.

2. **From the storefront**  
   Open each product page, copy the text and price, and in DevTools (Network/Elements) find the main product image URL (often from `cdn.salla.sa`).

3. **Add to the JSON**  
   Append a new object to the `products` array in `salla-moodabaya-products.json` with this shape:

```json
{
  "source_url": "https://salla.sa/moodabaya/XXXXX",
  "name_ar": "الاسم بالعربية",
  "name_en": "Name in English",
  "slug": "url-friendly-slug",
  "description_ar": "الوصف... يمكن استخدام أسطر متعددة.",
  "description_en": "Description... Multiple paragraphs allowed.",
  "price": 400,
  "compare_at_price": null,
  "stock": 10,
  "sku": "ABY-002",
  "category_slug": "abayas",
  "short_description": "One line summary.",
  "featured": false,
  "image_urls": ["https://cdn.salla.sa/..."]
}
```

- **category_slug** must be one of: `abayas`, `jilbabs`, `hijabs`.
- **image_urls**: optional. If you add Salla CDN URLs here, you can extend the seeder to download and save them under `storage/app/public/products/` and use them as the product image.

4. **Re-run the seeder**  
   `php artisan db:seed --class=ProductSeeder`  
   so the new products (and any edits) are loaded into your app.

## Image URLs

Product images on Salla are usually served from `cdn.salla.sa`. If you add URLs to `image_urls`, the seeder can be updated to download those images and attach them to the product (main + gallery). Right now the seeder uses placeholder images when `image_urls` is empty.
