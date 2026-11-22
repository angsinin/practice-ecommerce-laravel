<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Apex Motors | Modern Luxury Automotive Showroom')</title>

    <!-- Google Fonts: Cinzel, Plus Jakarta Sans, Outfit & Kantumruy Pro (Khmer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Kantumruy+Pro:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & FontAwesome 6 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-primary: #060911;
            --bg-secondary: #0c1220;
            --bg-card: #111a2e;
            --bg-card-hover: #16223d;
            --border-glass: rgba(255, 255, 255, 0.08);
            --border-gold: rgba(212, 175, 55, 0.3);
            --gold-primary: #d4af37;
            --gold-light: #fbe38e;
            --gold-dark: #aa841f;
            --accent-cyan: #38bdf8;
            --text-pure: #ffffff;
            --text-slate-100: #f1f5f9;
            --text-slate-200: #e2e8f0;
            --text-slate-300: #cbd5e1;
            --text-slate-400: #94a3b8;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-slate-200);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, .font-serif, .brand-logo {
            font-family: 'Cinzel', serif;
            letter-spacing: 0.75px;
        }

        /* High-contrast slate typography helpers */
        .text-slate-100 { color: var(--text-slate-100) !important; }
        .text-slate-200 { color: var(--text-slate-200) !important; }
        .text-slate-300 { color: var(--text-slate-300) !important; }
        .text-slate-400 { color: var(--text-slate-400) !important; }

        /* Ultra-luxury glassmorphic panels */
        .glass-panel {
            background: rgba(12, 18, 32, 0.82);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-glass);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .glass-panel-gold {
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-gold);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 35px rgba(212, 175, 55, 0.12);
        }

        .gold-gradient-text {
            background: linear-gradient(135deg, #fff3b0 0%, #d4af37 50%, #aa841f 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gold-gradient-btn {
            background: linear-gradient(135deg, #e5c07b 0%, #d4af37 50%, #b89127 100%);
            color: #060911;
            font-weight: 700;
            border: none;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.25);
        }

        .gold-gradient-btn:hover {
            background: linear-gradient(135deg, #fff2a3 0%, #e5c07b 50%, #d4af37 100%);
            color: #000;
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.5), 0 6px 20px rgba(0,0,0,0.4);
            transform: translateY(-2px);
        }

        .gold-outline-btn {
            background: rgba(212, 175, 55, 0.05);
            color: #f1f5f9;
            border: 1px solid var(--border-gold);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .gold-outline-btn:hover {
            background: var(--gold-primary);
            color: #060911;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
            transform: translateY(-2px);
        }

        /* Navbar */

        .navbar-luxury {
            background: rgba(6, 9, 17, 0.95);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            position: sticky;
            top: 0;
            z-index: 1030;
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            transition: all 0.3s ease;
        }

        .brand-crest {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fbe38e 0%, #d4af37 50%, #8c6d1f 100%);
            box-shadow: 0 0 16px rgba(212, 175, 55, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #060911;
            font-size: 1.15rem;
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover .brand-crest {
            transform: rotate(-8deg) scale(1.05);
            box-shadow: 0 0 24px rgba(212, 175, 55, 0.65);
        }

        .nav-link-custom {
            color: var(--text-slate-300) !important;
            font-size: 0.88rem;
            font-weight: 500;
            padding: 8px 16px !important;
            border-radius: 999px;
            border: 1px solid transparent;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .nav-link-custom:hover {
            color: #ffffff !important;
            background: rgba(212, 175, 55, 0.08);
            border-color: rgba(212, 175, 55, 0.25);
            transform: translateY(-1px);
        }

        .nav-link-custom.active {
            color: #fbe38e !important;
            background: rgba(212, 175, 55, 0.12);
            border: 1px solid rgba(212, 175, 55, 0.35);
            font-weight: 600;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.15);
        }

        /* Search input with high contrast */
        .navbar-search-input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
            font-size: 0.85rem !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .navbar-search-input::placeholder {
            color: #94a3b8 !important;
        }

        .navbar-search-input:focus {
            background: rgba(18, 26, 44, 0.95) !important;
            border-color: var(--gold-primary) !important;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.22) !important;
            color: #ffffff !important;
        }

        /* Khmer typography balance helper */
        .khmer-font {
            font-family: 'Kantumruy Pro', 'Plus Jakarta Sans', sans-serif !important;
            line-height: 1.45;
            letter-spacing: 0.2px;
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -10px;
            background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 999px;
            box-shadow: 0 2px 10px rgba(225, 29, 72, 0.5);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes badgeBounce {
            0% { transform: scale(1); }
            40% { transform: scale(1.45); }
            100% { transform: scale(1); }
        }

        .badge-bounce {
            animation: badgeBounce 0.45s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Unified Luxury Stepper across Cart, Checkout & Confirmation */
        .luxury-stepper {
            display: inline-flex;
            align-items: center;
            background: rgba(12, 18, 32, 0.85);
            border: 1px solid rgba(212, 175, 55, 0.28);
            border-radius: 9999px;
            padding: 6px 14px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
        }

        .luxury-stepper .step-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.82rem;
            transition: all 0.25s ease;
        }

        .luxury-stepper .step-item.completed {
            color: #94a3b8;
        }

        .luxury-stepper .step-item.completed:hover {
            color: #fbe38e;
        }

        .luxury-stepper .step-item.active {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.22) 0%, rgba(212, 175, 55, 0.08) 100%);
            border: 1px solid rgba(212, 175, 55, 0.45);
            color: #fbe38e;
            font-weight: 700;
            box-shadow: 0 0 14px rgba(212, 175, 55, 0.2);
        }

        .luxury-stepper .step-item.upcoming {
            color: #64748b;
        }

        .luxury-stepper .step-num {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .luxury-stepper .step-item.completed .step-num {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .luxury-stepper .step-item.active .step-num {
            background: #d4af37;
            color: #060911;
            box-shadow: 0 0 10px rgba(212, 175, 55, 0.6);
        }

        .luxury-stepper .step-item.upcoming .step-num {
            background: rgba(255, 255, 255, 0.05);
            color: #64748b;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stepper-separator {
            color: rgba(212, 175, 55, 0.4);
            font-size: 0.68rem;
            margin: 0 2px;
        }

        /* Luxury Vehicle Card */
        .car-card {
            background: var(--bg-card);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 16px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            overflow: hidden;
        }

        .car-card:hover {
            transform: translateY(-8px);
            border-color: rgba(212, 175, 55, 0.45);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.7), 0 0 25px rgba(212, 175, 55, 0.15);
        }

        .car-image-container {
            position: relative;
            height: 230px;
            overflow: hidden;
            background: #020617;
        }

        .car-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .car-card:hover .car-image-container img {
            transform: scale(1.08);
        }

        /* Interactive Toast */
        .toast-luxury {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 9999;
            min-width: 330px;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid var(--gold-primary);
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.8), 0 0 20px rgba(212, 175, 55, 0.2);
            color: #fff;
            padding: 16px 20px;
            display: none;
            animation: slideInUp 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideInUp {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #060911;
        }
        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold-primary);
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- MAIN SINGLE-LINE LUXURY NAVBAR -->
    <nav class="navbar navbar-expand-xl navbar-dark navbar-luxury py-2.5">
        <div class="container d-flex align-items-center justify-content-between flex-nowrap">
            <!-- Brand Logo (Left) -->
            <a class="navbar-brand d-flex align-items-center text-decoration-none me-3 me-lg-4 text-nowrap flex-shrink-0" href="{{ route('products.index') }}">
                <div class="brand-crest me-2.5" style="width: 38px; height: 38px;">
                    <i class="fa-solid fa-crown" style="font-size: 0.95rem;"></i>
                </div>
                <div>
                    <span class="brand-logo fs-4 fw-bold gold-gradient-text tracking-wider d-block font-serif" style="letter-spacing: 2px; line-height: 1.1;">APEX MOTORS</span>
                    <span class="d-block text-slate-400 font-serif" style="font-size: 0.6rem; letter-spacing: 2px;">LUXURY AUTOMOTIVE ATELIER</span>
                </div>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0 shadow-none px-2 d-xl-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars-staggered text-warning fs-4"></i>
            </button>

            <!-- Single-Line Navigation Links (Center/Left) & Utilities (Right) -->
            <div class="collapse navbar-collapse flex-grow-1" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-xl-0 gap-1 align-items-xl-center text-nowrap flex-nowrap">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom text-nowrap {{ request()->routeIs('products.index') && !request('min_price') && !request('category') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fa-solid fa-car-side me-1 text-warning"></i> Showroom
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom text-nowrap {{ request('min_price') == 100 && request('max_price') == 5000 ? 'active' : '' }}" href="{{ route('products.index', ['min_price' => 100, 'max_price' => 5000]) }}">
                            <i class="fa-solid fa-bolt me-1 text-info"></i> Budget & Mini ($100+)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom text-nowrap {{ request('min_price') == 70000 ? 'active' : '' }}" href="{{ route('products.index', ['min_price' => 70000]) }}">
                            <i class="fa-solid fa-crown me-1 text-warning"></i> Supercars ($70K+)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom text-nowrap" href="#footer-concierge">
                            <i class="fa-solid fa-headset me-1 text-info"></i> VIP Concierge
                        </a>
                    </li>
                </ul>

                <!-- Right Utility Controls & Gold Action Pill -->
                <div class="d-flex align-items-center gap-2.5 mt-3 mt-xl-0 flex-shrink-0 text-nowrap">
                    <!-- Search Input Form -->
                    <form action="{{ route('products.index') }}" method="GET" class="d-none d-lg-flex position-relative me-1">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search make, model, EV..." 
                               class="form-control form-control-sm navbar-search-input pe-4 rounded-pill" 
                               style="width: 200px; padding-left: 14px; height: 36px; font-size: 0.8rem;">
                        <button type="submit" class="btn btn-sm position-absolute end-0 top-0 text-slate-400 border-0 bg-transparent pe-3 pt-1.5" aria-label="Search">
                            <i class="fa-solid fa-magnifying-glass text-warning" style="font-size: 0.8rem;"></i>
                        </button>
                    </form>

                    <!-- Prominent Gold Action Pill (CART) -->
                    <a href="{{ route('cart.index') }}" class="btn gold-gradient-btn rounded-pill px-3 py-1.5 position-relative d-inline-flex align-items-center gap-2 shadow text-nowrap font-serif" style="height: 38px;">
                        <i class="fa-solid fa-cart-shopping text-dark"></i>
                        <span class="fw-bold text-dark" style="font-size: 0.82rem; letter-spacing: 0.5px;">CART</span>
                        @php
                            $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
                        @endphp
                        <span id="cart-counter" class="badge rounded-pill bg-dark text-warning border border-warning px-2 py-0.5" style="font-size: 0.72rem; line-height: 1;">{{ $cartCount }}</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
            </div>
        </div>
    </nav>

    <!-- FLASH MESSAGES -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 text-white rounded-3 shadow" style="background: rgba(16, 185, 129, 0.25); border-left: 4px solid #10b981 !important;" role="alert">
                <i class="fa-solid fa-circle-check me-2 text-success fs-5"></i>
                <strong>Success:</strong> {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 text-white rounded-3 shadow" style="background: rgba(239, 68, 68, 0.25); border-left: 4px solid #ef4444 !important;" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2 text-danger fs-5"></i>
                <strong>Notice:</strong> {{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 text-white rounded-3 shadow" style="background: rgba(239, 68, 68, 0.25); border-left: 4px solid #ef4444 !important;" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2 text-danger"></i>
                <strong>Please check the form errors:</strong>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- MAIN BODY CONTENT -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- LUXURY ATELIER FOOTER -->
    <footer id="footer-concierge" class="mt-5 pt-5 pb-4 border-top" style="background: #04060b; border-color: rgba(255, 255, 255, 0.08) !important;">
        <div class="container">
            <div class="row g-4">
                <!-- Col 1: Brand Info -->
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-2 d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: linear-gradient(135deg, #fce588 0%, #d4af37 100%);">
                            <i class="fa-solid fa-shield-cat text-dark"></i>
                        </div>
                        <span class="brand-logo fs-5 fw-bold gold-gradient-text">APEX MOTORS</span>
                    </div>
                    <p class="text-slate-400 small pe-lg-4" style="line-height: 1.6;">
                        Apex Motors is a premier luxury automotive atelier. We connect discerning automotive enthusiasts with curated hypercars, electrified grand tourers, and accessible urban daily runabouts with prices starting from $100 to over $150,000.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle text-slate-300"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle text-slate-300"><i class="fa-brands fa-youtube"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle text-slate-300"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-secondary rounded-circle text-slate-300"><i class="fa-brands fa-telegram"></i></a>
                    </div>
                </div>

                <!-- Col 2: Showroom Locations -->
                <div class="col-6 col-lg-2">
                    <h6 class="text-uppercase text-light fw-bold mb-3 small font-serif">Flagships</h6>
                    <ul class="list-unstyled text-slate-400 small">
                        <li class="mb-2"><i class="fa-solid fa-location-dot text-warning me-1"></i> Beverly Hills, CA</li>
                        <li class="mb-2"><i class="fa-solid fa-location-dot text-warning me-1"></i> Manhattan, NY</li>
                        <li class="mb-2"><i class="fa-solid fa-location-dot text-warning me-1"></i> Dubai Marina, UAE</li>
                        <li class="mb-2"><i class="fa-solid fa-location-dot text-warning me-1"></i> Monte Carlo, Monaco</li>
                        <li class="mb-2"><i class="fa-solid fa-location-dot text-warning me-1"></i> Phnom Penh, KH</li>
                    </ul>
                </div>

                <!-- Col 3: Assurance -->
                <div class="col-6 col-lg-3">
                    <h6 class="text-uppercase text-light fw-bold mb-3 small font-serif">Atelier Guarantee</h6>
                    <ul class="list-unstyled text-slate-400 small">
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i> 150-Point Factory Inspection</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i> Clean Title & CarFax Certified</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i> Enclosed Climate Transport</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i> Escrow Secured Transactions</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i> KHQR, Wire & Cards Accepted</li>
                    </ul>
                </div>

                <!-- Col 4: VIP Concierge -->
                <div class="col-lg-3">
                    <h6 class="text-uppercase text-light fw-bold mb-3 small font-serif">VIP Private Client Desk</h6>
                    <p class="text-slate-400 small mb-2">Speak directly with an automotive acquisition specialist:</p>
                    <p class="text-warning fw-bold mb-1"><i class="fa-solid fa-phone me-1"></i> +1 (800) 890-APEX</p>
                    <p class="text-slate-300 small mb-3"><i class="fa-solid fa-envelope me-1 text-slate-400"></i> concierge@apexmotors.com</p>
                    <div class="p-2 rounded bg-dark border border-secondary border-opacity-25">
                        <span class="text-slate-400" style="font-size: 0.75rem;">Showroom Hours: Mon - Sat 9:00 AM - 8:00 PM EST</span>
                    </div>
                </div>
            </div>

            <hr class="my-4 border-secondary opacity-25">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-slate-400 small">
                <div>
                    &copy; {{ date('Y') }} Apex Motors Atelier LLC. Lesson 9 Laravel Car E-Commerce. All rights reserved.
                </div>
                <div class="d-flex gap-3 mt-2 mt-md-0">
                    <a href="{{ route('products.index') }}" class="text-slate-400 text-decoration-none">Privacy Policy</a>
                    <a href="{{ route('products.index') }}" class="text-slate-400 text-decoration-none">Terms of Sale</a>
                    <a href="{{ route('cart.index') }}" class="text-slate-400 text-decoration-none">Cart & Checkout</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- INTERACTIVE TOAST NOTIFICATION -->
    <div id="toastNotification" class="toast-luxury">
        <div class="d-flex align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="fs-3 text-warning">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <strong class="d-block text-warning small font-serif">SHOWROOM CART UPDATED</strong>
                    <span id="toastMessage" class="small text-slate-200">Vehicle successfully added!</span>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('cart.index') }}" class="btn btn-sm gold-gradient-btn rounded-pill px-3 py-1 font-serif text-nowrap" style="font-size: 0.78rem;">
                    View Cart <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
                <button type="button" class="btn-close btn-close-white" onclick="closeToast()"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global Cart AJAX Script -->
    <script>
        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            const msgSpan = document.getElementById('toastMessage');
            if (toast && msgSpan) {
                msgSpan.innerText = message;
                toast.style.display = 'block';
                setTimeout(() => {
                    closeToast();
                }, 4000);
            }
        }

        function closeToast() {
            const toast = document.getElementById('toastNotification');
            if (toast) toast.style.display = 'none';
        }

        // Global Add-to-Cart handler with Live Feedback
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.add-to-cart-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalHtml = submitBtn ? submitBtn.innerHTML : '';
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Adding...</span>';
                    }

                    const formData = new FormData(form);
                    const productId = formData.get('product_id');

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="fa-solid fa-check text-success"></i> <span>Added!</span>';
                            setTimeout(() => {
                                submitBtn.innerHTML = '<i class="fa-solid fa-cart-plus"></i> <span>Add More</span>';
                            }, 1500);
                        }

                        // Update in-cart badge on product card if present
                        if (productId) {
                            const badge = document.getElementById('in-cart-badge-' + productId);
                            if (badge) {
                                badge.classList.remove('d-none');
                                const qtySpan = badge.querySelector('.in-cart-qty');
                                if (qtySpan && data.cart && data.cart[productId]) {
                                    qtySpan.innerText = data.cart[productId].quantity;
                                }
                            }
                        }

                        // Update cart counter with bounce animation
                        if (data.cartCount !== undefined) {
                            const counter = document.getElementById('cart-counter');
                            if (counter) {
                                counter.innerText = data.cartCount;
                                counter.classList.remove('badge-bounce');
                                void counter.offsetWidth; // trigger reflow
                                counter.classList.add('badge-bounce');
                            }
                        }

                        showToast(data.message || 'Vehicle added to your cart!');
                    })
                    .catch(err => {
                        console.error('Add to cart error:', err);
                        // Fallback to normal submission if AJAX fails
                        form.submit();
                    });
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
