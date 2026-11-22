@extends('layouts.app')

@section('title', 'Apex Motors | Luxury Automotive Showroom & Supercars')

@push('styles')
<style>
    /* Full-Bleed Luxury Automotive Hero */
    .hero-fullbleed-luxury {
        position: relative;
        background: linear-gradient(180deg, rgba(6, 9, 17, 0.88) 0%, rgba(6, 9, 17, 0.72) 40%, rgba(6, 9, 17, 0.98) 100%),
                    url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=2000&q=85') center 35% / cover no-repeat;
        border-bottom: 1px solid rgba(212, 175, 55, 0.18);
        padding-top: 4rem;
        padding-bottom: 6.5rem;
    }

    /* Floating Search & Filter Card */
    .floating-filter-card {
        background: rgba(12, 18, 32, 0.94);
        backdrop-filter: blur(28px);
        -webkit-backdrop-filter: blur(28px);
        border: 1px solid rgba(212, 175, 55, 0.35);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.75), 0 0 35px rgba(212, 175, 55, 0.12);
        border-radius: 1.25rem;
        transition: all 0.3s ease;
    }

    /* Continuous Looping Marquee Animation (រត់វិលជុំ) */
    .marquee-container {
        width: 100%;
        overflow: hidden;
        position: relative;
        padding: 4px 0;
        mask-image: linear-gradient(to right, transparent 0%, black 4%, black 96%, transparent 100%);
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 4%, black 96%, transparent 100%);
    }

    .marquee-track {
        display: flex;
        width: max-content;
        gap: 0.85rem;
        animation: marqueeScroll 38s linear infinite;
        will-change: transform;
    }

    .marquee-container:hover .marquee-track,
    .marquee-container:focus-within .marquee-track {
        animation-play-state: paused;
    }

    @keyframes marqueeScroll {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(-50%);
        }
    }

    .marquee-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.55rem 1.15rem;
        border-radius: 999px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        color: #cbd5e1;
        background: rgba(12, 18, 32, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.1);
        white-space: nowrap;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    .marquee-pill:hover {
        color: #ffffff;
        background: rgba(212, 175, 55, 0.16);
        border-color: rgba(212, 175, 55, 0.45);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(212, 175, 55, 0.2);
    }

    .marquee-pill.active {
        color: #060911 !important;
        background: linear-gradient(135deg, #fbe38e 0%, #d4af37 100%) !important;
        border-color: #d4af37 !important;
        box-shadow: 0 0 16px rgba(212, 175, 55, 0.45);
        font-weight: 700;
    }

    .marquee-pill.active i {
        color: #060911 !important;
    }

    .filter-input-luxury {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.14) !important;
        color: #ffffff !important;
        font-size: 0.88rem !important;
        border-radius: 999px !important;
        padding: 0.55rem 1rem !important;
        transition: all 0.25s ease;
    }

    .filter-input-luxury:focus {
        background: rgba(17, 26, 46, 0.98) !important;
        border-color: #d4af37 !important;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.22) !important;
        color: #ffffff !important;
    }

    /* Trust Pill Capsules in Hero */
    .trust-capsule {
        background: rgba(12, 18, 32, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 1rem;
        padding: 0.85rem 1.15rem;
        transition: transform 0.25s ease, border-color 0.25s ease;
    }
    .trust-capsule:hover {
        transform: translateY(-2px);
        border-color: rgba(212, 175, 55, 0.35);
    }

    /* Product Card & Quantity Controls */
    .qty-picker-luxury {
        background: rgba(15, 23, 42, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 999px;
        padding: 3px 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: border-color 0.25s ease;
    }

    .qty-picker-luxury:focus-within {
        border-color: #d4af37;
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.25);
    }

    .qty-btn-icon {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        color: #cbd5e1;
        transition: all 0.2s ease;
        padding: 0;
    }

    .qty-btn-icon:hover {
        background: rgba(212, 175, 55, 0.2);
        color: #fbe38e;
        transform: scale(1.1);
    }

    .qty-card-input {
        width: 32px;
        background: transparent;
        border: none;
        color: #ffffff;
        font-weight: 700;
        text-align: center;
        font-size: 0.85rem;
        padding: 0;
        outline: none;
        -moz-appearance: textfield;
    }

    .qty-card-input::-webkit-outer-spin-button,
    .qty-card-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* In-Cart Floating Indicator */
    .in-cart-pill {
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.95) 0%, rgba(184, 145, 39, 0.95) 100%);
        color: #060911;
        font-weight: 800;
        font-size: 0.72rem;
        letter-spacing: 0.3px;
        border-radius: 999px;
        padding: 4px 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4), 0 0 12px rgba(212, 175, 55, 0.5);
        border: 1px solid #ffffff;
    }

    /* Horizontal Chip Carousel Scrollbar */
    .chip-scroll-row {
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .chip-scroll-row::-webkit-scrollbar {
        display: none;
    }
</style>
@endpush

@section('content')
<!-- FULL-BLEED HERO WITH DARK OVERLAY & ACCENT TYPOGRAPHY -->
<section class="hero-fullbleed-luxury">
    <!-- Ambient Studio Vignette -->
    <div class="position-absolute top-0 end-0 pointer-events-none" style="width: 700px; height: 500px; background: radial-gradient(ellipse at 75% 25%, rgba(212, 175, 55, 0.15), transparent 70%); filter: blur(50px); z-index: 0;"></div>
    <div class="position-absolute bottom-0 start-0 pointer-events-none" style="width: 600px; height: 400px; background: radial-gradient(circle at 20% 80%, rgba(56, 189, 248, 0.08), transparent 70%); filter: blur(55px); z-index: 0;"></div>

    <div class="container position-relative z-1">
        <div class="row align-items-center g-5">
            <!-- Left Hero Content -->
            <div class="col-lg-7">
                <!-- Concierge Tag -->
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3" style="background: rgba(212, 175, 55, 0.12); border: 1px solid rgba(212, 175, 55, 0.38);">
                    <span class="badge bg-warning text-dark fw-bold font-serif" style="font-size: 0.72rem; letter-spacing: 0.5px;">2025/2026 FLEET</span>
                    <span class="text-warning small fw-medium"><i class="fa-solid fa-gem me-1"></i> Flagship Automotive Atelier</span>
                </div>

                <!-- Headline with Gold Accent Phrase -->
                <h1 class="display-4 fw-extrabold text-white mb-3" style="line-height: 1.15; letter-spacing: -0.5px;">
                    FIND YOUR DREAM CAR.<br>
                    <span class="gold-gradient-text font-serif">DRIVE LUXURY WITH DISTINCTION.</span>
                </h1>

                <!-- Clean Subtitle with Bilingual Khmer Pricing Balance -->
                <p class="text-slate-200 mb-4 pe-lg-4" style="font-size: 1.05rem; line-height: 1.75; text-shadow: 0 1px 3px rgba(0,0,0,0.6);">
                    Explore prestigious hypercars, executive sedans, and accessible daily cruisers starting from 
                    <strong class="text-warning font-serif">100 / 200</strong> <span class="khmer-font text-warning-subtle fw-semibold">រៀល (KHR)</span>. 
                    Every vehicle is inspected across 150 critical points, guaranteed with clear certificate of title, and settled via certified ACLEDA Bank KHQR.
                </p>

                <!-- 3 Concise Trust / Feature Highlights -->
                <div class="row g-2 mb-4">
                    <div class="col-sm-4">
                        <div class="trust-capsule h-100 d-flex align-items-center gap-2">
                            <div class="p-2 rounded-circle" style="background: rgba(212, 175, 55, 0.15); border: 1px solid rgba(212, 175, 55, 0.3);">
                                <i class="fa-solid fa-tags text-warning small"></i>
                            </div>
                            <div>
                                <span class="text-white fw-bold d-block small font-serif" style="font-size: 0.8rem;">No Hidden Charges</span>
                                <span class="text-slate-400 d-block" style="font-size: 0.72rem;">Transparent Pricing</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="trust-capsule h-100 d-flex align-items-center gap-2">
                            <div class="p-2 rounded-circle" style="background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3);">
                                <i class="fa-solid fa-shield-check text-info small"></i>
                            </div>
                            <div>
                                <span class="text-white fw-bold d-block small font-serif" style="font-size: 0.8rem;">150+ Point Check</span>
                                <span class="text-slate-400 d-block" style="font-size: 0.72rem;">Certified Inspection</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="trust-capsule h-100 d-flex align-items-center gap-2">
                            <div class="p-2 rounded-circle" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3);">
                                <i class="fa-solid fa-qrcode text-success small"></i>
                            </div>
                            <div>
                                <span class="text-white fw-bold d-block small font-serif" style="font-size: 0.8rem;">ACLEDA KHQR</span>
                                <span class="text-slate-400 d-block" style="font-size: 0.72rem;">Concierge Support</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action Buttons -->
                <div class="d-flex flex-wrap gap-3 pt-1">
                    <a href="#inventory" class="btn btn-lg gold-gradient-btn px-4 py-2.5 rounded-pill shadow">
                        <i class="fa-solid fa-compass me-2"></i> Explore Showroom Fleet
                    </a>
                    <a href="{{ route('cart.index') }}" class="btn btn-lg gold-outline-btn px-4 py-2.5 rounded-pill font-serif">
                        <i class="fa-solid fa-cart-shopping me-2 text-warning"></i> View Cart & Checkout
                    </a>
                </div>
            </div>

            <!-- Right Featured Car Showcase Card -->
            <div class="col-lg-5">
                <div class="p-4 rounded-4 glass-panel-gold position-relative shadow-lg" style="border: 1px solid rgba(212, 175, 55, 0.38);">
                    <!-- Vehicle Showcase Image -->
                    <div class="rounded-3 overflow-hidden position-relative mb-3" style="height: 230px; border: 1px solid rgba(255, 255, 255, 0.08); background: #000;">
                        <img src="{{ asset('images/porsche-taycan.jpg') }}" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1624880056139-d1212d7ff347?auto=format&fit=crop&w=1200&q=80';" alt="Porsche Taycan 4S" class="w-100 h-100" style="object-fit: cover; object-position: center;">
                        <div class="position-absolute bottom-0 start-0 w-100 p-2" style="background: linear-gradient(to top, rgba(6, 9, 17, 0.9) 0%, transparent 100%);">
                            <span class="badge" style="background: rgba(212, 175, 55, 0.14); border: 1px solid rgba(212, 175, 55, 0.35); color: #f1f5f9; font-size: 0.72rem; letter-spacing: 0.5px;">
                                <i class="fa-solid fa-bolt me-1" style="color: #d4af37;"></i> ELECTRIC VEHICLES
                            </span>
                        </div>
                    </div>

                    <!-- Car Details -->
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h4 class="text-white fw-bold mb-0 font-serif" style="font-size: 1.25rem;">Porsche Taycan 4S</h4>
                        <span class="text-warning fw-bold fs-4 font-serif">$115,000</span>
                    </div>

                    <p class="text-slate-300 small mb-3" style="line-height: 1.5; font-size: 0.84rem;">
                        Stuttgart precision engineering featuring high-output dual permanent magnet synchronous motors, 800V architecture, and adaptive air suspension.
                    </p>

                    <!-- Spec Badges -->
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge text-slate-200" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); font-size: 0.72rem;">
                            <i class="fa-solid fa-bolt me-1" style="color: #d4af37;"></i> 800V Architecture
                        </span>
                        <span class="badge text-slate-200" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); font-size: 0.72rem;">
                            <i class="fa-solid fa-gauge-high me-1" style="color: #d4af37;"></i> 0-60 in 3.9s
                        </span>
                        <span class="badge text-slate-200" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); font-size: 0.72rem;">
                            <i class="fa-solid fa-road me-1" style="color: #d4af37;"></i> Dual-Motor AWD
                        </span>
                    </div>

                    <!-- Quick Reserve Form with Quantity Stepper -->
                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form" data-product-id="12">
                        @csrf
                        <input type="hidden" name="product_id" value="12">
                        <div class="d-flex align-items-center gap-2">
                            <div class="qty-picker-luxury">
                                <button type="button" class="qty-btn-icon" onclick="decrementCardQty(12)" title="Decrease">
                                    <i class="fa-solid fa-minus small"></i>
                                </button>
                                <input type="number" name="quantity" id="card-qty-12" value="1" min="1" max="99" class="qty-card-input" readonly>
                                <button type="button" class="qty-btn-icon" onclick="incrementCardQty(12)" title="Increase">
                                    <i class="fa-solid fa-plus small"></i>
                                </button>
                            </div>
                            <button type="submit" class="btn flex-grow-1 gold-gradient-btn rounded-pill py-2.5 px-3 fw-bold font-serif d-flex align-items-center justify-content-center gap-2 shadow-sm" style="font-size: 0.84rem;">
                                <i class="fa-solid fa-cart-plus"></i>
                                <span>QUICK RESERVE TO CART</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FLOATING SEARCH & FILTER CARD (OVERLAPPING BOTTOM EDGE OF HERO) -->
<div class="container position-relative" style="margin-top: -55px; z-index: 25;" id="inventory">
    <div class="floating-filter-card p-3 p-md-4">
        <!-- Main Filter Columns Row -->
        <form action="{{ route('products.index') }}" method="GET" id="filterForm">
            <div class="row g-2 align-items-end">
                <!-- Col 1: Search Make/Model -->
                <div class="col-lg-4 col-md-6">
                    <label class="form-label text-slate-300 small fw-semibold mb-1 text-uppercase font-serif" style="font-size: 0.72rem; letter-spacing: 0.5px;">Search Make / Model</label>
                    <div class="input-group">
                        <span class="input-group-text border-0 text-warning bg-dark border-secondary px-3" style="border: 1px solid rgba(255, 255, 255, 0.14) !important; border-right: none !important; border-radius: 999px 0 0 999px;">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}" 
                               class="form-control filter-input-luxury" 
                               style="border-radius: 0 999px 999px 0 !important; border-left: none !important;"
                               placeholder="e.g. BMW, Porsche, Mini, Camry...">
                    </div>
                </div>

                <!-- Col 2: Category -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label text-slate-300 small fw-semibold mb-1 text-uppercase font-serif" style="font-size: 0.72rem; letter-spacing: 0.5px;">Vehicle Category</label>
                    <select name="category" class="form-select filter-input-luxury" style="background-color: #0c1220 !important;">
                        <option value="">All Categories ({{ $products->total() }})</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $selectedCategory == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }} ({{ $cat->products_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Col 3: Price Range/Budget -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label text-slate-300 small fw-semibold mb-1 text-uppercase font-serif" style="font-size: 0.72rem; letter-spacing: 0.5px;">Price Range (KHR / $)</label>
                    <div class="d-flex align-items-center gap-1.5">
                        <input type="number" 
                               name="min_price" 
                               value="{{ $minPrice }}" 
                               min="100" 
                               step="50" 
                               class="form-control form-control-sm filter-input-luxury text-center px-1" 
                               placeholder="Min (100)">
                        <span class="text-slate-400 small">-</span>
                        <input type="number" 
                               name="max_price" 
                               value="{{ $maxPrice }}" 
                               min="100" 
                               step="1000" 
                               class="form-control form-control-sm filter-input-luxury text-center px-1" 
                               placeholder="Max">
                    </div>
                </div>

                <!-- Col 4: Action Buttons -->
                <div class="col-lg-2 col-md-6">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn gold-gradient-btn w-100 py-2 rounded-pill fw-bold font-serif d-flex align-items-center justify-content-center gap-1.5 shadow" style="font-size: 0.84rem;">
                            <i class="fa-solid fa-sliders"></i>
                            <span>Search / Filter</span>
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-3 py-2 rounded-pill text-slate-300" title="Reset Filters" style="border-color: rgba(255,255,255,0.15);">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- POPULAR CATEGORIES & BRANDS CONTINUOUS LOOPING MARQUEE ("ប្រភេទ និងប្រេនរថយន្តពេញនិយម") -->
<div class="container position-relative mt-4 mb-2 z-1">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2 px-1">
        <div class="d-flex align-items-center gap-2">
            <span class="badge rounded-pill" style="background: rgba(212, 175, 55, 0.15); border: 1px solid rgba(212, 175, 55, 0.35); color: #fbe38e; font-size: 0.7rem; letter-spacing: 0.5px;">
                <i class="fa-solid fa-crown text-warning me-1"></i> TOP FLEET
            </span>
            <h3 class="h6 text-white mb-0 fw-bold khmer-font" style="letter-spacing: 0.3px;">
                ប្រភេទ និងប្រេនរថយន្តពេញនិយម <span class="text-slate-400 fw-normal small font-sans ms-1 d-none d-sm-inline">(Popular Categories & Brands)</span>
            </h3>
        </div>
        <div class="d-none d-md-flex align-items-center gap-1.5 text-slate-400 small" style="font-size: 0.74rem;">
            <i class="fa-solid fa-arrows-left-right text-warning"></i>
            <span class="khmer-font">រត់វិលជុំ • ដាក់ Mouse លើដើម្បីផ្អាក (Hover to Pause)</span>
        </div>
    </div>

    @php
        $marqueeItems = [
            [
                'label' => 'ទាំងអស់ (All Products)',
                'url' => route('products.index'),
                'icon' => 'fa-solid fa-border-all',
                'active' => empty($selectedCategory) && empty($search) && empty($maxPrice),
            ],
            [
                'label' => 'SUV & Crossover',
                'url' => route('products.index', ['search' => 'SUV']),
                'icon' => 'fa-solid fa-car-side',
                'active' => request('search') === 'SUV',
            ],
            [
                'label' => 'Minivan & Family',
                'url' => route('products.index', ['search' => 'Minivan']),
                'icon' => 'fa-solid fa-van-shuttle',
                'active' => request('search') === 'Minivan',
            ],
            [
                'label' => 'កង់អគ្គិសនី (E-Bikes)',
                'url' => route('products.index', ['search' => 'Electric']),
                'icon' => 'fa-solid fa-bolt',
                'active' => request('search') === 'Electric',
            ],
            [
                'label' => 'គ្រឿងបន្ថែម (Parts)',
                'url' => route('products.index', ['search' => 'Parts']),
                'icon' => 'fa-solid fa-gears',
                'active' => request('search') === 'Parts',
            ],
            [
                'label' => 'BYD',
                'url' => route('products.index', ['search' => 'BYD']),
                'icon' => 'fa-solid fa-charging-station',
                'active' => request('search') === 'BYD',
            ],
            [
                'label' => 'Tesla',
                'url' => route('products.index', ['search' => 'Tesla']),
                'icon' => 'fa-solid fa-bolt-lightning',
                'active' => request('search') === 'Tesla',
            ],
            [
                'label' => 'Hyundai',
                'url' => route('products.index', ['search' => 'Hyundai']),
                'icon' => 'fa-solid fa-shield-halved',
                'active' => request('search') === 'Hyundai',
            ],
            [
                'label' => 'KIA',
                'url' => route('products.index', ['search' => 'KIA']),
                'icon' => 'fa-solid fa-certificate',
                'active' => request('search') === 'KIA',
            ],
            [
                'label' => 'BMW',
                'url' => route('products.index', ['search' => 'BMW']),
                'icon' => 'fa-solid fa-compass',
                'active' => request('search') === 'BMW',
            ],
            [
                'label' => 'Mercedes',
                'url' => route('products.index', ['search' => 'Mercedes']),
                'icon' => 'fa-solid fa-star',
                'active' => request('search') === 'Mercedes',
            ],
            [
                'label' => 'Peugeot',
                'url' => route('products.index', ['search' => 'Peugeot']),
                'icon' => 'fa-solid fa-shield-cat',
                'active' => request('search') === 'Peugeot',
            ],
            [
                'label' => 'Porsche',
                'url' => route('products.index', ['search' => 'Porsche']),
                'icon' => 'fa-solid fa-crown',
                'active' => request('search') === 'Porsche',
            ],
        ];
    @endphp

    <!-- Continuous Looping Marquee Track Wrapper -->
    <div class="marquee-container" title="Click any category or brand to filter. Hover to pause.">
        <div class="marquee-track" role="region" aria-label="Popular categories and brands ticker">
            {{-- Set 1 --}}
            @foreach($marqueeItems as $item)
                <a href="{{ $item['url'] }}" class="marquee-pill {{ $item['active'] ? 'active' : '' }}">
                    <i class="{{ $item['icon'] }} {{ $item['active'] ? '' : 'text-warning' }}"></i>
                    <span class="khmer-font">{{ $item['label'] }}</span>
                </a>
            @endforeach

            {{-- Set 2 (Duplicate for Seamless Infinite Loop) --}}
            @foreach($marqueeItems as $item)
                <a href="{{ $item['url'] }}" class="marquee-pill {{ $item['active'] ? 'active' : '' }}" aria-hidden="true" tabindex="-1">
                    <i class="{{ $item['icon'] }} {{ $item['active'] ? '' : 'text-warning' }}"></i>
                    <span class="khmer-font">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- INVENTORY SHOWROOM SECTION -->
<div class="container pt-3 pb-4">
    <!-- Polished Showroom Inventory Section Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 pb-3 border-bottom border-secondary border-opacity-20">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge rounded-pill" style="background: rgba(212, 175, 55, 0.14); border: 1px solid rgba(212, 175, 55, 0.35); color: #fbe38e; font-size: 0.68rem; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-crown me-1 text-warning"></i> CURATED ATELIER FLEET
                </span>
                <span class="text-slate-400 small">&bull; 100% Clear Titles Guaranteed</span>
            </div>
            <h2 class="h3 text-white fw-bold mb-0 font-serif" style="letter-spacing: 0.5px;">
                SHOWROOM INVENTORY
            </h2>
        </div>

        <div class="mt-3 mt-md-0 d-flex flex-wrap align-items-center gap-3">
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.1);">
                <span class="text-slate-400 small">Showing:</span>
                <span class="text-warning fw-bold small font-serif">{{ $products->count() }} of {{ $products->total() }} Vehicles</span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="text-slate-400 small fw-medium">Sort:</span>
                <select class="form-select form-select-sm text-white rounded-pill px-3 py-1" style="width: 195px; background: #0c1220; border: 1px solid rgba(212, 175, 55, 0.3); font-size: 0.8rem;" onchange="location = this.value;">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured Fleet</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High (៛100+)</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'year_desc']) }}" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>Newest Model Year</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Alphabetical (A-Z)</option>
                </select>
            </div>
        </div>
    </div>

    <!-- CARS GRID -->
    @if($products->isEmpty())
        <div class="text-center py-5 glass-panel rounded-4 my-4">
            <i class="fa-solid fa-car-burst text-slate-400 mb-3" style="font-size: 4rem;"></i>
            <h4 class="text-light font-serif">No Vehicles Matched Your Search Criteria</h4>
            <p class="text-slate-300">Try clearing your filters or widening your price range to explore our full fleet.</p>
            <a href="{{ route('products.index') }}" class="btn gold-gradient-btn px-4 py-2 rounded-pill mt-2">
                <i class="fa-solid fa-rotate-left me-2"></i> Reset All Filters
            </a>
        </div>
    @else
        @php
            $sessionCart = session('cart', []);
        @endphp

        <div class="row g-4">
            @foreach($products as $car)
                @php
                    $inCart = isset($sessionCart[$car->id]);
                    $inCartQty = $inCart ? $sessionCart[$car->id]['quantity'] : 0;
                @endphp

                <div class="col-lg-4 col-md-6">
                    <div class="car-card h-100 d-flex flex-column justify-content-between position-relative">
                        <!-- Vehicle Image Container -->
                        <div class="car-image-container">
                            <img src="{{ $car->image_url }}" alt="{{ $car->name }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80'">
                            
                            <!-- Category Badge -->
                            <span class="position-absolute top-0 start-0 m-3 badge px-3 py-1 rounded-pill" style="background: rgba(6, 9, 17, 0.85); border: 1px solid rgba(212, 175, 55, 0.4); color: #fbe38e; font-size: 0.72rem; backdrop-filter: blur(8px);">
                                {{ $car->category->name }}
                            </span>

                            <!-- Model Year Badge -->
                            <span class="position-absolute top-0 end-0 m-3 badge px-2 py-1 rounded fw-bold text-white font-serif" style="background: rgba(0, 0, 0, 0.75); border: 1px solid rgba(255, 255, 255, 0.15); font-size: 0.75rem; backdrop-filter: blur(8px);">
                                {{ $car->model_year }}
                            </span>

                            <!-- Floating In-Cart Badge Indicator -->
                            <div class="position-absolute top-0 end-0 m-3 me-5 {{ $inCart ? '' : 'd-none' }}" id="in-cart-badge-{{ $car->id }}">
                                <span class="in-cart-pill d-inline-flex align-items-center gap-1 font-serif">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>In Cart (<span class="in-cart-qty">{{ $inCartQty }}</span>)</span>
                                </span>
                            </div>

                            <!-- Stock Indicator -->
                            <div class="position-absolute bottom-0 start-0 m-2 px-2 py-1 rounded text-xs d-flex align-items-center gap-1" style="background: rgba(6, 9, 17, 0.9); font-size: 0.72rem; border: 1px solid rgba(255,255,255,0.08);">
                                @if($car->stock > 0)
                                    <span class="badge bg-success rounded-circle p-1"> </span>
                                    <span class="text-success fw-semibold">In Showroom ({{ $car->stock }} Units)</span>
                                @else
                                    <span class="badge bg-danger rounded-circle p-1"> </span>
                                    <span class="text-danger fw-semibold">Reserved / On Order</span>
                                @endif
                            </div>
                        </div>

                        <!-- Car Card Body -->
                        <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="text-warning small text-uppercase mb-1 tracking-wider fw-bold font-serif" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-award me-1"></i> {{ $car->brand }}
                                </div>
                                <h3 class="h5 text-white fw-bold mb-2 text-truncate font-serif" title="{{ $car->name }}">
                                    {{ $car->name }}
                                </h3>
                                <p class="text-slate-300 small mb-3" style="line-height: 1.55; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 42px; font-size: 0.85rem;">
                                    {{ $car->description }}
                                </p>

                                <!-- Car Specs Pills -->
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    <span class="badge" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); color: #cbd5e1; font-size: 0.7rem;">
                                        <i class="fa-solid fa-gauge-high text-info me-1"></i> Verified Performance
                                    </span>
                                    <span class="badge" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.12); color: #cbd5e1; font-size: 0.7rem;">
                                        <i class="fa-solid fa-shield-check text-success me-1"></i> Clean CarFax
                                    </span>
                                </div>
                            </div>

                            <!-- Pricing, Quantity Controls & Add to Cart Action -->
                            <div class="pt-3 border-top border-secondary border-opacity-20 mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <small class="text-slate-400 d-block text-uppercase fw-semibold" style="font-size: 0.68rem; letter-spacing: 0.5px;">Direct Atelier Price</small>
                                        @if($car->price <= 500)
                                            <div class="d-flex align-items-baseline gap-1.5">
                                                <span class="fs-4 fw-bold text-warning font-serif">
                                                    ៛{{ number_format($car->price, 0) }}
                                                </span>
                                                <span class="text-slate-400 small font-serif">/ ${{ number_format($car->price, 0) }}</span>
                                            </div>
                                            <span class="khmer-font text-warning-subtle small fw-medium d-block" style="font-size: 0.76rem; color: #fbe38e !important;">
                                                {{ number_format($car->price, 0) }} រៀល (KHR)
                                            </span>
                                        @else
                                            <span class="fs-4 fw-bold text-warning font-serif d-block">
                                                ${{ number_format($car->price, 2) }}
                                            </span>
                                            <small class="text-slate-400 d-block" style="font-size: 0.7rem;">Verified Title & Handover</small>
                                        @endif
                                    </div>

                                    <!-- Tier Badges -->
                                    @if($car->price <= 500)
                                        <span class="badge bg-success bg-opacity-25 text-success border border-success small px-2 py-1">
                                            <i class="fa-solid fa-bolt me-1"></i> Budget Special
                                        </span>
                                    @elseif($car->price <= 5000)
                                        <span class="badge bg-primary bg-opacity-25 text-info border border-info small px-2 py-1">
                                            Urban Compact
                                        </span>
                                    @elseif($car->price >= 70000)
                                        <span class="badge bg-warning bg-opacity-25 text-warning border border-warning small px-2 py-1 font-serif">
                                            <i class="fa-solid fa-crown me-1"></i> Luxury Tier
                                        </span>
                                    @endif
                                </div>

                                <!-- Add to Cart Form with Inline Quantity Controls -->
                                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form" data-product-id="{{ $car->id }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $car->id }}">
                                    
                                    <div class="d-flex align-items-center gap-2">
                                        <!-- Quantity Controls (- / +) -->
                                        <div class="qty-picker-luxury">
                                            <button type="button" class="qty-btn-icon" onclick="decrementCardQty({{ $car->id }})" title="Decrease Quantity">
                                                <i class="fa-solid fa-minus small"></i>
                                            </button>
                                            <input type="number" name="quantity" id="card-qty-{{ $car->id }}" value="1" min="1" max="{{ max(1, $car->stock) }}" class="qty-card-input" readonly>
                                            <button type="button" class="qty-btn-icon" onclick="incrementCardQty({{ $car->id }})" title="Increase Quantity">
                                                <i class="fa-solid fa-plus small"></i>
                                            </button>
                                        </div>

                                        <!-- Prominent Add to Cart Button -->
                                        <button type="submit" class="btn gold-gradient-btn py-2 px-3 rounded-pill fw-bold font-serif flex-grow-1 d-flex align-items-center justify-content-center gap-2 btn-add-cart shadow-sm" style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-cart-plus"></i>
                                            <span class="btn-text">{{ $inCart ? 'Add More' : 'Add to Cart' }}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- LUXURY SHOWROOM FEATURES / VALUE PROPOSITION STRIP -->
<section class="py-5 mt-5 border-top border-bottom border-secondary border-opacity-25" style="background: #04060b;">
    <div class="container">
        <div class="row g-4 text-center text-md-start">
            <div class="col-md-3">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                    <div class="p-3 rounded-circle border border-warning text-warning fs-3" style="background: rgba(212, 175, 55, 0.08);">
                        <i class="fa-solid fa-truck-ramp-box"></i>
                    </div>
                    <div>
                        <h6 class="text-light fw-bold mb-1 font-serif">Enclosed Delivery</h6>
                        <p class="text-slate-400 small mb-0">Climate-controlled white glove transport direct to your residence.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                    <div class="p-3 rounded-circle border border-warning text-warning fs-3" style="background: rgba(212, 175, 55, 0.08);">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <div>
                        <h6 class="text-light fw-bold mb-1 font-serif">Certified Inspection</h6>
                        <p class="text-slate-400 small mb-0">Every vehicle undergoes rigorous mechanical & chassis certification.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                    <div class="p-3 rounded-circle border border-warning text-warning fs-3" style="background: rgba(212, 175, 55, 0.08);">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <div>
                        <h6 class="text-light fw-bold mb-1 font-serif">Bakong KHQR & Cards</h6>
                        <p class="text-slate-400 small mb-0">Seamless digital payments via KHQR (Ang Sinin), ABA, cards, or showroom COD.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3">
                    <div class="p-3 rounded-circle border border-warning text-warning fs-3" style="background: rgba(212, 175, 55, 0.08);">
                        <i class="fa-solid fa-handshake-angle"></i>
                    </div>
                    <div>
                        <h6 class="text-light fw-bold mb-1 font-serif">VIP Concierge Desk</h6>
                        <p class="text-slate-400 small mb-0">Dedicated luxury concierge ready to assist with title & logistics.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function decrementCardQty(id) {
        const input = document.getElementById('card-qty-' + id);
        if (input) {
            let val = parseInt(input.value) || 1;
            if (val > 1) {
                input.value = val - 1;
            }
        }
    }

    function incrementCardQty(id) {
        const input = document.getElementById('card-qty-' + id);
        if (input) {
            let val = parseInt(input.value) || 1;
            let max = parseInt(input.getAttribute('max')) || 99;
            if (val < max) {
                input.value = val + 1;
            }
        }
    }
</script>
@endpush
