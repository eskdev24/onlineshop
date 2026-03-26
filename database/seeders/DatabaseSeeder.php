<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ShippingZone;
use App\Models\ShippingRate;
use App\Models\Setting;
use App\Models\Coupon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@buyvia.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Sample Customer
        User::updateOrCreate(
            ['email' => 'customer@buyvia.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'email_verified_at' => now(),
            ]
        );

        // Categories
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'description' => 'Phones, laptops, gadgets and more'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Clothing, shoes, and accessories'],
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'description' => 'Furniture, decor, and garden tools'],
            ['name' => 'Sports', 'slug' => 'sports', 'description' => 'Sports equipment and gear'],
            ['name' => 'Books', 'slug' => 'books', 'description' => 'Fiction, non-fiction, and textbooks'],
            ['name' => 'Health & Beauty', 'slug' => 'health-beauty', 'description' => 'Skincare, makeup, and wellness'],
            ['name' => 'Toys & Games', 'slug' => 'toys-games', 'description' => 'Toys, games, and hobbies'],
            ['name' => 'Automotive', 'slug' => 'automotive', 'description' => 'Car parts and accessories'],
            ['name' => 'Groceries', 'slug' => 'groceries', 'description' => 'Food, drinks, and household items'],
            ['name' => 'Office Supplies', 'slug' => 'office-supplies', 'description' => 'Stationery, printers, and office gear'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Subcategories
        $electronics = Category::where('slug', 'electronics')->first();
        if ($electronics) {
            Category::updateOrCreate(
                ['slug' => 'smartphones'],
                ['name' => 'Smartphones', 'parent_id' => $electronics->id, 'description' => 'Latest smartphones']
            );
            Category::updateOrCreate(
                ['slug' => 'laptops'],
                ['name' => 'Laptops', 'parent_id' => $electronics->id, 'description' => 'Laptops and notebooks']
            );
            Category::updateOrCreate(
                ['slug' => 'accessories'],
                ['name' => 'Accessories', 'parent_id' => $electronics->id, 'description' => 'Gadget accessories']
            );
        }

        // Brands
        $brands = [
            ['name' => 'TechPro', 'slug' => 'techpro'],
            ['name' => 'StyleHub', 'slug' => 'stylehub'],
            ['name' => 'HomeEase', 'slug' => 'homeease'],
            ['name' => 'FitGear', 'slug' => 'fitgear'],
            ['name' => 'BookWorld', 'slug' => 'bookworld'],
        ];
        foreach ($brands as $brand) {
            Brand::updateOrCreate(['slug' => $brand['slug']], $brand);
        }

        // Products
        $products = [
            ['name' => 'Wireless Bluetooth Headphones', 'slug' => 'wireless-bluetooth-headphones', 'sku' => 'BV-001', 'category_id' => 1, 'brand_id' => 1, 'price' => 150, 'discount_price' => 125, 'stock_quantity' => 50, 'is_featured' => true, 'short_description' => 'Premium wireless headphones with noise cancellation', 'description' => 'Experience crystal-clear audio with these premium wireless Bluetooth headphones. Features active noise cancellation, 30-hour battery life, and ultra-comfortable ear cushions.'],
            ['name' => 'Smart Watch Pro', 'slug' => 'smart-watch-pro', 'sku' => 'BV-002', 'category_id' => 1, 'brand_id' => 1, 'price' => 450, 'discount_price' => 380, 'stock_quantity' => 30, 'is_featured' => true, 'short_description' => 'Advanced smartwatch with health monitoring', 'description' => 'Track your fitness goals with this advanced smartwatch. Features heart rate monitoring, GPS tracking, sleep analysis, and a stunning AMOLED display.'],
            ['name' => 'Laptop Stand Adjustable', 'slug' => 'laptop-stand-adjustable', 'sku' => 'BV-003', 'category_id' => 1, 'brand_id' => 1, 'price' => 85, 'stock_quantity' => 100, 'short_description' => 'Ergonomic adjustable laptop stand', 'description' => 'Improve your posture with this sleek adjustable laptop stand. Made from premium aluminum alloy with non-slip pads.'],
            ['name' => 'Men\'s Classic Polo Shirt', 'slug' => 'mens-classic-polo-shirt', 'sku' => 'BV-004', 'category_id' => 2, 'brand_id' => 2, 'price' => 55, 'discount_price' => 42, 'stock_quantity' => 200, 'is_featured' => true, 'short_description' => 'Comfortable cotton polo shirt', 'description' => 'Classic fit polo shirt made from 100% premium cotton. Perfect for casual and semi-formal occasions.'],
            ['name' => 'Women\'s Running Shoes', 'slug' => 'womens-running-shoes', 'sku' => 'BV-005', 'category_id' => 2, 'brand_id' => 4, 'price' => 220, 'discount_price' => 185, 'stock_quantity' => 75, 'is_featured' => true, 'short_description' => 'Lightweight running shoes', 'description' => 'Lightweight and breathable running shoes with responsive cushioning. Perfect for daily runs and workouts.'],
            ['name' => 'Minimalist Desk Lamp', 'slug' => 'minimalist-desk-lamp', 'sku' => 'BV-006', 'category_id' => 3, 'brand_id' => 3, 'price' => 75, 'stock_quantity' => 60, 'short_description' => 'Modern LED desk lamp', 'description' => 'Sleek minimalist desk lamp with adjustable brightness. Features touch control and USB charging port.'],
            ['name' => 'Yoga Mat Premium', 'slug' => 'yoga-mat-premium', 'sku' => 'BV-007', 'category_id' => 4, 'brand_id' => 4, 'price' => 65, 'discount_price' => 50, 'stock_quantity' => 120, 'short_description' => 'Non-slip premium yoga mat', 'description' => 'Extra thick and non-slip yoga mat perfect for all types of yoga and floor exercises. Includes carrying strap.'],
            ['name' => 'JavaScript: The Good Parts', 'slug' => 'javascript-the-good-parts', 'sku' => 'BV-008', 'category_id' => 5, 'brand_id' => 5, 'price' => 45, 'stock_quantity' => 80, 'short_description' => 'Essential JavaScript book', 'description' => 'A must-read for every web developer. Learn the elegant and powerful features of JavaScript.'],
            ['name' => 'Organic Face Moisturizer', 'slug' => 'organic-face-moisturizer', 'sku' => 'BV-009', 'category_id' => 6, 'brand_id' => 3, 'price' => 35, 'discount_price' => 28, 'stock_quantity' => 150, 'is_featured' => true, 'short_description' => 'Natural organic moisturizer', 'description' => 'Hydrate and nourish your skin with this 100% organic face moisturizer. Suitable for all skin types.'],
            ['name' => 'Wireless Keyboard & Mouse Combo', 'slug' => 'wireless-keyboard-mouse-combo', 'sku' => 'BV-010', 'category_id' => 10, 'brand_id' => 1, 'price' => 120, 'discount_price' => 95, 'stock_quantity' => 45, 'short_description' => 'Ergonomic wireless set', 'description' => 'Slim and quiet wireless keyboard and mouse combo. Features long battery life and plug-and-play USB receiver.'],
        ];

        foreach ($products as $productData) {
            $product = Product::updateOrCreate(
                ['slug' => $productData['slug']],
                array_merge($productData, [
                    'is_active' => true,
                    'image' => 'https://placehold.co/800x800/EEE/31343C.png?text=' . urlencode($productData['name'])
                ])
            );

            // Add gallery images if none exist
            if ($product->images()->count() === 0) {
                for ($i = 1; $i <= 4; $i++) {
                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'image' => 'https://placehold.co/800x800/F5F5F5/31343C.png?text=Gallery+' . $i,
                        'sort_order' => $i
                    ]);
                }
            }
        }

        // Shipping
        $zone = ShippingZone::updateOrCreate(['name' => 'Ghana']);
        ShippingRate::updateOrCreate(
            ['shipping_zone_id' => $zone->id, 'name' => 'Standard Delivery'],
            ['type' => 'flat_rate', 'cost' => 15]
        );
        ShippingRate::updateOrCreate(
            ['shipping_zone_id' => $zone->id, 'name' => 'Express Delivery'],
            ['type' => 'flat_rate', 'cost' => 30]
        );
        ShippingRate::updateOrCreate(
            ['shipping_zone_id' => $zone->id, 'name' => 'Free Shipping (Orders over ₵5,000)'],
            ['type' => 'free', 'cost' => 0, 'min_order_value' => 5000]
        );

        // Coupons
        Coupon::updateOrCreate(['code' => 'WELCOME10'], ['type' => 'percentage', 'value' => 10, 'usage_limit' => 100, 'expires_at' => now()->addMonths(3)]);
        Coupon::updateOrCreate(['code' => 'FLAT2000'], ['type' => 'fixed', 'value' => 2000, 'min_order_value' => 10000, 'usage_limit' => 50, 'expires_at' => now()->addMonths(1)]);

        // Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Buyvia'],
            ['key' => 'site_tagline', 'value' => 'Shop Smart, Live Better'],
            ['key' => 'site_email', 'value' => 'info@buyvia.com'],
            ['key' => 'site_phone', 'value' => '+233 55 555 5555'],
            ['key' => 'site_address', 'value' => 'Accra, Ghana'],
            ['key' => 'currency', 'value' => 'GHS'],
            ['key' => 'currency_symbol', 'value' => '₵'],
            ['key' => 'tax_rate', 'value' => '13'],
        ];
        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
