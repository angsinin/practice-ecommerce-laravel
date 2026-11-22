<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks for clean truncation if re-seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        OrderItem::truncate();
        Order::truncate();
        Product::truncate();
        Category::truncate();
        Customer::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Seed Categories
        $categories = [
            [
                'name' => 'Sports Cars',
                'description' => 'Track-tested aerodynamic masterpieces and high-revving performance thoroughbreds.'
            ],
            [
                'name' => 'Electric Vehicles',
                'description' => 'Zero emissions with hypercar acceleration and cutting-edge autonomous intelligence.'
            ],
            [
                'name' => 'Luxury SUVs',
                'description' => 'Commanding presence, mastercrafted bespoke leather, and conquering all-wheel drive.'
            ],
            [
                'name' => 'Executive Sedans',
                'description' => 'Unmatched rear-seat serenity, whisper-quiet cabin acoustics, and first-class technology.'
            ],
            [
                'name' => 'Mini & Budget Cars',
                'description' => 'Agile urban runabouts, pocket cruisers, and accessible modern micro-mobility.'
            ],
        ];

        $catMap = [];
        foreach ($categories as $cat) {
            $created = Category::create($cat);
            $catMap[$cat['name']] = $created->id;
        }

        // 2. Seed Products (Pricing starting from $100 up to $152,000+)
        $products = [
            // Mini & Budget Cars
            [
                'category_id' => $catMap['Mini & Budget Cars'],
                'name' => 'Mini City Eco Cruiser',
                'brand' => 'Metro Motors',
                'model_year' => 2024,
                'price' => 100.00,
                'stock' => 15,
                'image_url' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Ultracompact city commuter car offering maximum parking versatility, nimble electric power, and zero emissions for metropolitan driving.',
            ],
            [
                'category_id' => $catMap['Mini & Budget Cars'],
                'name' => 'City Sprint Micro Cruiser',
                'brand' => 'Metro Motors',
                'model_year' => 2024,
                'price' => 200.00,
                'stock' => 20,
                'image_url' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Economical ultra-light urban cruiser perfect for low-cost test transactions and agile daily city driving.',
            ],
            [
                'category_id' => $catMap['Mini & Budget Cars'],
                'name' => 'Fiat 500 Vintage Dolce',
                'brand' => 'Fiat',
                'model_year' => 2023,
                'price' => 450.00,
                'stock' => 8,
                'image_url' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Charming Italian compact with retro curves, panoramic moonroof, premium touchpoints, and agile urban handling.',
            ],
            [
                'category_id' => $catMap['Mini & Budget Cars'],
                'name' => 'Corolla Compact Urban Sport',
                'brand' => 'Toyota',
                'model_year' => 2024,
                'price' => 4500.00,
                'stock' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Highly reliable, ultra-efficient commuter vehicle equipped with Toyota Safety Sense 3.0 and intuitive Apple CarPlay/Android Auto.',
            ],

            // Executive Sedans
            [
                'category_id' => $catMap['Executive Sedans'],
                'name' => 'Camry XSE V6 Platinum',
                'brand' => 'Toyota',
                'model_year' => 2025,
                'price' => 28500.00,
                'stock' => 10,
                'image_url' => 'https://images.unsplash.com/photo-1590362891991-f776e747a588?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Bold executive styling, 301-hp 3.5L V6 engine, dual exhaust with quad chrome tips, and red leather-trimmed cockpit.',
            ],
            [
                'category_id' => $catMap['Executive Sedans'],
                'name' => 'Audi A6 Prestige S-Line',
                'brand' => 'Audi',
                'model_year' => 2025,
                'price' => 58900.00,
                'stock' => 6,
                'image_url' => 'https://images.unsplash.com/photo-1603584173870-7f23fdae1b7a?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Quattro all-wheel drive, dual touchscreens with MMI Navigation plus, Bang & Olufsen 3D Premium Sound, and Matrix-design LED headlights.',
            ],
            [
                'category_id' => $catMap['Executive Sedans'],
                'name' => 'Mercedes-Benz S-Class S580 4MATIC',
                'brand' => 'Mercedes-Benz',
                'model_year' => 2025,
                'price' => 122000.00,
                'stock' => 4,
                'image_url' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=1200&q=80',
                'description' => 'The absolute pinnacle of automotive luxury. Biturbo V8 with EQ Boost, active multicontour massage seating, and augmented-reality HUD.',
            ],

            // Sports Cars
            [
                'category_id' => $catMap['Sports Cars'],
                'name' => 'BMW M4 Competition Coupe',
                'brand' => 'BMW',
                'model_year' => 2025,
                'price' => 78000.00,
                'stock' => 5,
                'image_url' => 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?auto=format&fit=crop&w=1200&q=80',
                'description' => 'High-revving 503-hp M TwinPower Turbo inline 6-cylinder, M xDrive all-wheel system with 2WD mode, and carbon-fiber bucket seats.',
            ],
            [
                'category_id' => $catMap['Sports Cars'],
                'name' => 'Corvette Z06 3LZ',
                'brand' => 'Chevrolet',
                'model_year' => 2025,
                'price' => 89500.00,
                'stock' => 3,
                'image_url' => 'https://images.unsplash.com/photo-1544829099-b9a0c07fad1a?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Naturally aspirated 5.5L flat-plane crank V8 revving to 8,600 RPM. Supercar proportions with magnetic selective ride control.',
            ],
            [
                'category_id' => $catMap['Sports Cars'],
                'name' => 'Aston Martin Vantage V8 Coupe',
                'brand' => 'Aston Martin',
                'model_year' => 2025,
                'price' => 146500.00,
                'stock' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Handcrafted British sculpture powered by a twin-turbocharged 4.0-liter V8 engine delivering 656 hp and an addictive exhaust note.',
            ],

            // Electric Vehicles
            [
                'category_id' => $catMap['Electric Vehicles'],
                'name' => 'Tesla Model 3 Performance',
                'brand' => 'Tesla',
                'model_year' => 2025,
                'price' => 38990.00,
                'stock' => 12,
                'image_url' => 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Sub-3.0 second 0-60 mph launch, all-glass acoustic canopy roof, Track Mode V3, and Full Self-Driving hardware suite.',
            ],
            [
                'category_id' => $catMap['Electric Vehicles'],
                'name' => 'Porsche Taycan 4S Cross Turismo',
                'brand' => 'Porsche',
                'model_year' => 2025,
                'price' => 115000.00,
                'stock' => 4,
                'image_url' => '/images/porsche-taycan.jpg',
                'description' => '800-volt architecture for rapid 270kW charging, air suspension with Smart Lift, and distinct Stuttgart sports car dynamics.',
            ],
            [
                'category_id' => $catMap['Electric Vehicles'],
                'name' => 'Lucid Air Grand Touring',
                'brand' => 'Lucid',
                'model_year' => 2025,
                'price' => 138000.00,
                'stock' => 3,
                'image_url' => 'https://images.unsplash.com/photo-1617788138017-80ad40651399?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Industry-leading 516 miles of EPA electric range, 819 horsepower dual motors, and floating 34-inch curved Glass Cockpit display.',
            ],

            // Luxury SUVs
            [
                'category_id' => $catMap['Luxury SUVs'],
                'name' => 'Range Rover Autobiography LWB',
                'brand' => 'Land Rover',
                'model_year' => 2025,
                'price' => 142000.00,
                'stock' => 4,
                'image_url' => 'https://images.unsplash.com/photo-1506015391300-4802dc74de2e?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Executive Class rear seating with hot stone massage, all-wheel steering, active noise cancellation, and electronic air suspension.',
            ],
            [
                'category_id' => $catMap['Luxury SUVs'],
                'name' => 'Mercedes-Benz G-Class G63 AMG',
                'brand' => 'Mercedes-Benz',
                'model_year' => 2025,
                'price' => 145000.00,
                'stock' => 3,
                'image_url' => 'https://images.unsplash.com/photo-1520031441872-265e4ff70366?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Iconic silhouette hand-built with AMG 4.0L V8 Biturbo producing 577 hp, 3 locking differentials, and side-pipe exhaust roar.',
            ],
            [
                'category_id' => $catMap['Luxury SUVs'],
                'name' => 'Porsche Cayenne Turbo GT',
                'brand' => 'Porsche',
                'model_year' => 2025,
                'price' => 152000.00,
                'stock' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80',
                'description' => 'Nürburgring record-setting luxury SUV with 650 hp twin-turbo V8, ceramic composite brakes (PCCB), and carbon aerodynamic package.',
            ],
        ];

        foreach ($products as $prod) {
            Product::create($prod);
        }

        // 3. Seed Sample Customer & Completed Order for demonstration
        $customer = Customer::create([
            'first_name' => 'Alexander',
            'last_name' => 'Vanderbilt',
            'email' => 'alexander.v@luxurycars.com',
            'phone' => '+1 (555) 789-0123',
            'address' => '740 Park Avenue, Penthouse B, Manhattan, NY 10021',
        ]);

        $sampleProduct = Product::where('price', '>', 50000)->first();
        if ($sampleProduct) {
            $shippingFee = 150.00;
            $discount = 100.00;
            $subtotal = $sampleProduct->price * 1;
            $grandTotal = $subtotal + $shippingFee - $discount;

            $order = Order::create([
                'order_number' => 'ORD-0001',
                'customer_id' => $customer->id,
                'shipping_method' => 'VIP Enclosed Transport',
                'shipping_fee' => $shippingFee,
                'discount' => $discount,
                'payment_method' => 'Credit / Debit Card',
                'subtotal' => $subtotal,
                'grand_total' => $grandTotal,
                'order_status' => 'Pending',
                'payment_status' => 'Pending',
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $sampleProduct->id,
                'quantity' => 1,
                'unit_price' => $sampleProduct->price,
                'subtotal' => $subtotal,
            ]);
        }
    }
}
