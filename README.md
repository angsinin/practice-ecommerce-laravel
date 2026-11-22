# លំហាត់អនុវត្ត — Apex Motors (`practice-ecommerce-laravel`)

គម្រោងគេហទំព័រលក់រថយន្ត **Apex Motors** បង្កើតឡើងដោយប្រើ **Laravel (PHP / Blade)** សម្រាប់អនុវត្តមេរៀន **Shopping Cart & Checkout** និងបំពេញតាមលក្ខខណ្ឌលំហាត់អនុវត្តទាំង ៤ ផ្នែក។

---

## ✨ មុខងារសំខាន់ៗ (Key Features)

1. **Product Catalog & Shopping Cart (Exercise 1)**
   - បង្ហាញបញ្ជីរថយន្តជាមួយរូបភាព ប្រភេទ តម្លៃ និងព័ត៌មានលម្អិត
   - មានតម្លៃតេស្តទាបស្រួលសាកល្បង (ដូចជា `100` / `200` រៀល / KHR) រួមជាមួយរថយន្តតម្លៃផ្សេងៗ
   - បន្ថែមចូលកន្ត្រក (AJAX Add to Cart), មើលកន្ត្រក, កែចំនួន (Update QTY), លុបចេញ, គណនា Subtotal និង Grand Total ព្រមទាំងប៊ូតុងទៅកាន់ Checkout

2. **Checkout & ACLEDA KHQR Payment (Exercise 2)**
   - ទម្រង់បំពេញព័ត៌មានអតិថិជន (First Name, Last Name, Email, Phone Number, Address) និងការផ្ទៀងផ្ទាត់ទិន្នន័យ (Validation)
   - ជ្រើសរើសវិធីដឹកជញ្ជូន (Shipping Method) និងបង្ហាញ Order Summary / Grand Total
   - ភ្ជាប់រូបភាព **ACLEDA KHQR** (`/images/acleda-khqr.jpg` — **Ang Sinin**) និងប៊ូតុងបញ្ជាទិញ (Place Order)

3. **Order Confirmation (Exercise 3)**
   - បង្ហាញសារជូនដំណឹងជោគជ័យ (`Order Placed Successfully!`)
   - បង្ហាញលេខកូដការកម្មង់ (`ORD-...`), ឈ្មោះអតិថិជន, កាលបរិច្ឆេទ, បញ្ជីទំនិញ និងចំនួន, ទឹកប្រាក់សរុប និងស្ថានភាព (`Pending`)

4. **Database Schema (Exercise 4)**
   - រៀបចំ Database តាមទំនាក់ទំនង 5 Tables: `customers`, `categories`, `products`, `orders`, និង `order_items` រួមជាមួយ Migrations, Models, Seeders និង Automated Tests

---

## 🛠️ បច្ចេកវិទ្យាប្រើប្រាស់ (Tech Stack)

- **Backend & Framework:** PHP, Laravel
- **Frontend:** Blade Templates, HTML5, CSS3, JavaScript
- **Database & Testing:** Relational Schema (5 Tables), PHPUnit / Artisan Feature & Unit Tests

---

## 🚀 របៀបដំឡើង និងដំណើរការលើកុំព្យូទ័រផ្សេង (Setup on Another Machine)

```bash
git clone [https://github.com/angsinin/practice-ecommerce-laravel.git](https://github.com/angsinin/practice-ecommerce-laravel.git)
cd practice-ecommerce-laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan test
php artisan serve
