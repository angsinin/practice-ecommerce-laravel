@extends('layouts.app')

@section('title', 'Secured Checkout | Apex Motors Luxury Atelier')

@push('styles')
<style>
    /* Luxury Apex Dark + Gold Theme */
    .checkout-hero-card {
        background: linear-gradient(135deg, rgba(17, 26, 46, 0.95) 0%, rgba(6, 9, 17, 0.98) 100%);
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5), inset 0 0 30px rgba(212, 175, 55, 0.04);
    }

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

    /* Clean Input Styling with Gold Focus Rings */
    .form-control-luxury {
        background: rgba(15, 23, 42, 0.75) !important;
        border: 1px solid rgba(255, 255, 255, 0.14) !important;
        color: #ffffff !important;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.92rem;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .form-control-luxury:hover {
        border-color: rgba(212, 175, 55, 0.35) !important;
        background: rgba(20, 30, 52, 0.85) !important;
    }

    .form-control-luxury:focus {
        background: rgba(18, 27, 48, 0.98) !important;
        border-color: #d4af37 !important;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.25), 0 4px 12px rgba(0, 0, 0, 0.3) !important;
        color: #ffffff !important;
        outline: none;
    }

    .form-control-luxury::placeholder {
        color: #64748b !important;
    }

    .input-group-text-luxury {
        background: rgba(15, 23, 42, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.14);
        color: #94a3b8;
        border-radius: 0.75rem 0 0 0.75rem;
    }

    /* Selection Cards (Shipping & Payment) */
    .luxury-choice-card {
        background: rgba(15, 23, 42, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 0.85rem;
        padding: 1rem 1.15rem;
        cursor: pointer;
        transition: all 0.25s ease;
        position: relative;
    }

    .luxury-choice-card:hover {
        border-color: rgba(212, 175, 55, 0.45);
        background: rgba(22, 34, 61, 0.8);
        transform: translateY(-1px);
    }

    .luxury-choice-card.active {
        border-color: #d4af37 !important;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.12) 0%, rgba(15, 23, 42, 0.85) 100%) !important;
        box-shadow: 0 0 20px rgba(212, 175, 55, 0.18), inset 0 0 12px rgba(212, 175, 55, 0.05) !important;
    }

    .luxury-choice-card .form-check-input {
        background-color: rgba(15, 23, 42, 0.8);
        border-color: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        width: 1.15em;
        height: 1.15em;
    }

    .luxury-choice-card.active .form-check-input {
        background-color: #d4af37;
        border-color: #d4af37;
        box-shadow: 0 0 8px rgba(212, 175, 55, 0.5);
    }

    /* Step Badge Icon */
    .step-badge-num {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fbe38e 0%, #d4af37 100%);
        color: #060911;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
    }

    /* Back Link Hover */
    .back-link-gold {
        color: #94a3b8;
        transition: all 0.2s ease;
    }

    .back-link-gold:hover {
        color: #fbe38e;
        text-shadow: 0 0 10px rgba(212, 175, 55, 0.4);
    }
</style>
@endpush

@section('content')
<div class="container py-4 py-md-5">
    <!-- TOP BAR: STEP INDICATOR & SECURED CHECKOUT BADGE -->
    <div class="mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
            <!-- Step Indicator: Cart > Shipping & Payment > Confirmation -->
            <div class="luxury-stepper" aria-label="Checkout Progress">
                <!-- Step 1: Cart -->
                <a href="{{ route('cart.index') }}" class="step-item completed text-decoration-none" title="Return to Cart">
                    <span class="step-num"><i class="fa-solid fa-check"></i></span>
                    <span class="fw-semibold">Cart</span>
                </a>

                <span class="stepper-separator"><i class="fa-solid fa-chevron-right"></i></span>

                <!-- Step 2: Shipping & Payment (Current) -->
                <div class="step-item active">
                    <span class="step-num font-serif">2</span>
                    <span class="font-serif">Shipping & Payment</span>
                </div>

                <span class="stepper-separator"><i class="fa-solid fa-chevron-right"></i></span>

                <!-- Step 3: Confirmation -->
                <div class="step-item upcoming">
                    <span class="step-num font-serif">3</span>
                    <span>Confirmation</span>
                </div>
            </div>

            <!-- Secured Checkout Badge -->
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.35); box-shadow: 0 0 15px rgba(16, 185, 129, 0.15);">
                <i class="fa-solid fa-shield-halved text-success"></i>
                <span class="text-slate-200 small fw-bold" style="letter-spacing: 0.5px; font-size: 0.78rem;">SECURED CHECKOUT</span>
                <span class="badge bg-success bg-opacity-25 text-success rounded-pill px-2 py-0" style="font-size: 0.68rem;">256-BIT SSL</span>
            </div>
        </div>

        <!-- MAIN HEADER: CONCIERGE VEHICLE CHECKOUT -->
        <div class="p-4 p-md-5 rounded-4 checkout-hero-card position-relative overflow-hidden">
            <div class="position-absolute top-0 end-0 p-4 pointer-events-none opacity-10 d-none d-lg-block">
                <i class="fa-solid fa-car-rear text-warning" style="font-size: 8.5rem;"></i>
            </div>

            <div class="position-relative z-1" style="max-width: 820px;">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge rounded-pill" style="background: rgba(212, 175, 55, 0.18); border: 1px solid rgba(212, 175, 55, 0.4); color: #fbe38e; font-size: 0.72rem; letter-spacing: 1px;">
                        <i class="fa-solid fa-crown me-1 text-warning"></i> OFFICIAL ORDER ACQUISITION
                    </span>
                    <span class="text-slate-400 small">&bull; White-Glove Handover</span>
                </div>

                <h1 class="h2 text-white fw-bold mb-2 font-serif" style="letter-spacing: 0.5px;">
                    CONCIERGE VEHICLE CHECKOUT
                </h1>
                <p class="text-slate-300 small mb-0" style="line-height: 1.6;">
                    Complete your vehicle registration title, select white-glove transport logistics, and finalize settlement via certified National KHQR (ACLEDA / Bakong), bank wire, or showroom handover.
                </p>
            </div>
        </div>
    </div>

    <!-- MAIN CHECKOUT FORM -->
    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
        @csrf

        <div class="row g-4">
            <!-- ========================================== -->
            <!-- LEFT COLUMN: STEP 1, STEP 2, STEP 3       -->
            <!-- ========================================== -->
            <div class="col-lg-8">
                <!-- --------------------------------------- -->
                <!-- STEP 1: CUSTOMER & SHIPPING DETAILS     -->
                <!-- --------------------------------------- -->
                <div class="glass-panel rounded-4 p-4 shadow-sm mb-4" style="border: 1px solid rgba(212, 175, 55, 0.2);">
                    <div class="d-flex align-items-center mb-4 pb-2 border-bottom border-secondary border-opacity-25">
                        <div class="step-badge-num me-3 font-serif">1</div>
                        <div>
                            <h4 class="h5 text-white fw-bold mb-0 font-serif">Customer & Registration Details</h4>
                            <small class="text-slate-400">Official certificate of title and registration documents will be drafted using this information.</small>
                        </div>
                    </div>

                    <div class="row g-3">
                        <!-- First Name -->
                        <div class="col-md-6">
                            <label class="form-label text-slate-200 small fw-semibold">
                                First Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="first_name" 
                                   value="{{ old('first_name', 'Alexander') }}" 
                                   class="form-control form-control-luxury @error('first_name') is-invalid @enderror" 
                                   placeholder="e.g. Alexander" 
                                   required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="col-md-6">
                            <label class="form-label text-slate-200 small fw-semibold">
                                Last Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="last_name" 
                                   value="{{ old('last_name', 'Vanderbilt') }}" 
                                   class="form-control form-control-luxury @error('last_name') is-invalid @enderror" 
                                   placeholder="e.g. Vanderbilt" 
                                   required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-6">
                            <label class="form-label text-slate-200 small fw-semibold">
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-luxury"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email', 'alexander.v@luxurycars.com') }}" 
                                       class="form-control form-control-luxury @error('email') is-invalid @enderror" 
                                       placeholder="name@domain.com" 
                                       style="border-top-left-radius: 0; border-bottom-left-radius: 0;"
                                       required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <label class="form-label text-slate-200 small fw-semibold">
                                Phone Number <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text input-group-text-luxury"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" 
                                       name="phone" 
                                       value="{{ old('phone', '+1 (555) 789-0123') }}" 
                                       class="form-control form-control-luxury @error('phone') is-invalid @enderror" 
                                       placeholder="+1 (555) 000-0000" 
                                       style="border-top-left-radius: 0; border-bottom-left-radius: 0;"
                                       required>
                            </div>
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Delivery / Billing Address -->
                        <div class="col-12">
                            <label class="form-label text-slate-200 small fw-semibold">
                                Complete Delivery & Billing Address <span class="text-danger">*</span>
                            </label>
                            <textarea name="address" 
                                      rows="3" 
                                      class="form-control form-control-luxury @error('address') is-invalid @enderror" 
                                      placeholder="Street address, Penthouse / Suite, City, State/Province, Postal Code, Country" 
                                      required>{{ old('address', '740 Park Avenue, Penthouse B, Manhattan, NY 10021') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- --------------------------------------- -->
                <!-- STEP 2: SHIPPING METHOD CARDS           -->
                <!-- --------------------------------------- -->
                <div class="glass-panel rounded-4 p-4 shadow-sm mb-4" style="border: 1px solid rgba(212, 175, 55, 0.2);">
                    <div class="d-flex align-items-center mb-4 pb-2 border-bottom border-secondary border-opacity-25">
                        <div class="step-badge-num me-3 font-serif">2</div>
                        <div>
                            <h4 class="h5 text-white fw-bold mb-0 font-serif">Shipping & Logistics Method</h4>
                            <small class="text-slate-400">Choose how you wish to receive your reserved luxury vehicles.</small>
                        </div>
                    </div>

                    @php
                        $selectedShipping = old('shipping_method', $defaultShipping ?? 'Standard Showroom Pickup');
                    @endphp

                    <div class="d-flex flex-column gap-3">
                        <!-- Method 1: Showroom Pickup -->
                        <label class="luxury-choice-card shipping-card d-flex justify-content-between align-items-center {{ $selectedShipping === 'Standard Showroom Pickup' ? 'active' : '' }}" onclick="selectShippingCard(this)">
                            <div class="d-flex align-items-center gap-3">
                                <input type="radio" 
                                       name="shipping_method" 
                                       value="Standard Showroom Pickup" 
                                       data-fee="0.00" 
                                       class="form-check-input" 
                                       {{ $selectedShipping === 'Standard Showroom Pickup' ? 'checked' : '' }} 
                                       onchange="updateShipping(this)">
                                <div>
                                    <strong class="text-white d-block">
                                        <i class="fa-solid fa-building-flag text-warning me-1"></i> Standard Showroom Pickup
                                    </strong>
                                    <small class="text-slate-400">Handover presentation ceremony at our nearest flagship atelier showroom.</small>
                                </div>
                            </div>
                            <span class="badge bg-success font-serif fs-6 px-3 py-2">FREE ($0.00)</span>
                        </label>

                        <!-- Method 2: Flatbed Home Delivery -->
                        <label class="luxury-choice-card shipping-card d-flex justify-content-between align-items-center {{ $selectedShipping === 'Flatbed Home Delivery' ? 'active' : '' }}" onclick="selectShippingCard(this)">
                            <div class="d-flex align-items-center gap-3">
                                <input type="radio" 
                                       name="shipping_method" 
                                       value="Flatbed Home Delivery" 
                                       data-fee="50.00" 
                                       class="form-check-input" 
                                       {{ $selectedShipping === 'Flatbed Home Delivery' ? 'checked' : '' }} 
                                       onchange="updateShipping(this)">
                                <div>
                                    <strong class="text-white d-block">
                                        <i class="fa-solid fa-truck-moving text-info me-1"></i> Flatbed Home Delivery
                                    </strong>
                                    <small class="text-slate-400">Direct regional flatbed carrier delivery directly to your residence driveway.</small>
                                </div>
                            </div>
                            <span class="badge font-serif fs-6 px-3 py-2 text-warning" style="background: rgba(212, 175, 55, 0.15); border: 1px solid rgba(212, 175, 55, 0.35);">+$50.00</span>
                        </label>

                        <!-- Method 3: VIP Enclosed Transport -->
                        <label class="luxury-choice-card shipping-card d-flex justify-content-between align-items-center {{ $selectedShipping === 'VIP Enclosed Transport' ? 'active' : '' }}" onclick="selectShippingCard(this)">
                            <div class="d-flex align-items-center gap-3">
                                <input type="radio" 
                                       name="shipping_method" 
                                       value="VIP Enclosed Transport" 
                                       data-fee="150.00" 
                                       class="form-check-input" 
                                       {{ $selectedShipping === 'VIP Enclosed Transport' ? 'checked' : '' }} 
                                       onchange="updateShipping(this)">
                                <div>
                                    <strong class="text-white d-block">
                                        <i class="fa-solid fa-truck-ramp-box text-warning me-1"></i> VIP Enclosed Transport (White-Glove)
                                    </strong>
                                    <small class="text-slate-400">Climate-controlled, dust-sealed, fully insured enclosed trailer transport.</small>
                                </div>
                            </div>
                            <span class="badge bg-warning text-dark font-serif fs-6 px-3 py-2 fw-bold">+$150.00</span>
                        </label>
                    </div>
                </div>

                <!-- --------------------------------------- -->
                <!-- STEP 3: PAYMENT OPTION CARDS            -->
                <!-- --------------------------------------- -->
                <div class="glass-panel rounded-4 p-4 shadow-sm mb-4" style="border: 1px solid rgba(212, 175, 55, 0.2);">
                    <div class="d-flex align-items-center mb-4 pb-2 border-bottom border-secondary border-opacity-25">
                        <div class="step-badge-num me-3 font-serif">3</div>
                        <div>
                            <h4 class="h5 text-white fw-bold mb-0 font-serif">Payment & Settlement Method</h4>
                            <small class="text-slate-400">Select your preferred payment method. National KHQR is supported for all major banking apps.</small>
                        </div>
                    </div>

                    @php
                        $selectedPayment = old('payment_method', 'Bank Transfer / KHQR');
                    @endphp

                    <!-- 4 Payment Cards Grid -->
                    <div class="row g-3 mb-4">
                        <!-- Option 1: Bank Transfer / KHQR (ACLEDA) -->
                        <div class="col-md-6">
                            <label class="luxury-choice-card payment-choice-card d-block h-100 {{ $selectedPayment === 'Bank Transfer / KHQR' ? 'active' : '' }}" 
                                   onclick="selectPaymentCard('khqr', this)">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="radio" 
                                               name="payment_method" 
                                               value="Bank Transfer / KHQR" 
                                               data-type="khqr" 
                                               class="form-check-input" 
                                               {{ $selectedPayment === 'Bank Transfer / KHQR' ? 'checked' : '' }} 
                                               onchange="switchPaymentUi('khqr')">
                                        <strong class="text-white small">Bank Transfer / KHQR (ACLEDA)</strong>
                                    </div>
                                    <span class="badge bg-danger text-white px-2 py-0" style="font-size: 0.65rem;">POPULAR</span>
                                </div>
                                <small class="text-slate-400 ps-4 d-block" style="font-size: 0.78rem;">
                                    Official National KHQR for ACLEDA, ABA, Bakong, and all mobile banking.
                                </small>
                            </label>
                        </div>

                        <!-- Option 2: Cash on Delivery / Showroom -->
                        <div class="col-md-6">
                            <label class="luxury-choice-card payment-choice-card d-block h-100 {{ $selectedPayment === 'Cash on Delivery (COD) / Pay at Showroom' ? 'active' : '' }}" 
                                   onclick="selectPaymentCard('cod', this)">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <input type="radio" 
                                           name="payment_method" 
                                           value="Cash on Delivery (COD) / Pay at Showroom" 
                                           data-type="cod" 
                                           class="form-check-input" 
                                           {{ $selectedPayment === 'Cash on Delivery (COD) / Pay at Showroom' ? 'checked' : '' }} 
                                           onchange="switchPaymentUi('cod')">
                                    <strong class="text-white small">Cash on Delivery / Showroom</strong>
                                </div>
                                <small class="text-slate-400 ps-4 d-block" style="font-size: 0.78rem;">
                                    Settlement via cashier check or cash upon vehicle handover presentation.
                                </small>
                            </label>
                        </div>

                        <!-- Option 3: Credit / Debit Card -->
                        <div class="col-md-6">
                            <label class="luxury-choice-card payment-choice-card d-block h-100 {{ $selectedPayment === 'Credit / Debit Card' ? 'active' : '' }}" 
                                   onclick="selectPaymentCard('card', this)">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <input type="radio" 
                                           name="payment_method" 
                                           value="Credit / Debit Card" 
                                           data-type="card" 
                                           class="form-check-input" 
                                           {{ $selectedPayment === 'Credit / Debit Card' ? 'checked' : '' }} 
                                           onchange="switchPaymentUi('card')">
                                    <strong class="text-white small">Credit / Debit Card</strong>
                                </div>
                                <small class="text-slate-400 ps-4 d-block" style="font-size: 0.78rem;">
                                    Visa, MasterCard, Amex via encrypted 256-bit payment gateway.
                                </small>
                            </label>
                        </div>

                        <!-- Option 4: Digital Wallet -->
                        <div class="col-md-6">
                            <label class="luxury-choice-card payment-choice-card d-block h-100 {{ $selectedPayment === 'Digital Wallet (ABA Pay / Wing / Bakong)' ? 'active' : '' }}" 
                                   onclick="selectPaymentCard('wallet', this)">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <input type="radio" 
                                           name="payment_method" 
                                           value="Digital Wallet (ABA Pay / Wing / Bakong)" 
                                           data-type="wallet" 
                                           class="form-check-input" 
                                           {{ $selectedPayment === 'Digital Wallet (ABA Pay / Wing / Bakong)' ? 'checked' : '' }} 
                                           onchange="switchPaymentUi('wallet')">
                                    <strong class="text-white small">Digital Wallet</strong>
                                </div>
                                <small class="text-slate-400 ps-4 d-block" style="font-size: 0.78rem;">
                                    Direct checkout via Bakong Wallet, ABA Pay, or Wing Bank.
                                </small>
                            </label>
                        </div>
                    </div>

                    <!-- ------------------------------------------- -->
                    <!-- DYNAMIC PAYMENT DETAILS PANELS              -->
                    <!-- ------------------------------------------- -->

                    <!-- 1. ACLEDA BANK KHQR PAYMENT PANEL -->
                    <div id="payment-ui-khqr" class="p-4 rounded-4 {{ $selectedPayment === 'Bank Transfer / KHQR' ? '' : 'd-none' }}" 
                         style="background: linear-gradient(135deg, #0b1324 0%, #060a14 100%); border: 1px solid rgba(212, 175, 55, 0.45); box-shadow: 0 15px 40px rgba(0,0,0,0.6);">
                        <div class="row align-items-center g-4">
                            <!-- Left: ACLEDA KHQR Graphic Card -->
                            <div class="col-md-5 text-center">
                                <div class="p-2 rounded-4 shadow-lg d-inline-block text-dark position-relative bg-white" style="max-width: 270px; border: 2px solid rgba(212, 175, 55, 0.5);">
                                    <div class="rounded-3 overflow-hidden text-center position-relative">
                                        <img src="{{ asset('images/acleda-khqr.jpg') }}" 
                                             alt="ACLEDA Bank KHQR - Ang Sinin" 
                                             class="img-fluid rounded-3" 
                                             style="width: 100%; max-height: 380px; object-fit: contain;">
                                    </div>
                                    <div class="mt-2 text-center small fw-bold text-dark font-serif" style="font-size: 0.85rem;">
                                        Ang Sinin &bull; ACLEDA Bank
                                    </div>
                                </div>

                                <!-- View / Download Full KHQR Button -->
                                <div class="mt-3">
                                    <a href="{{ asset('images/acleda-khqr.jpg') }}" target="_blank" download="acleda-khqr-ang-sinin.jpg" class="btn btn-sm btn-outline-warning rounded-pill px-3 py-2 fw-semibold">
                                        <i class="fa-solid fa-arrow-down-to-bracket me-1"></i> View / Download Full KHQR
                                    </a>
                                </div>
                            </div>

                            <!-- Right: Amount to Pay & Concise Scan Instructions -->
                            <div class="col-md-7">
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                    <span class="badge bg-danger px-2 py-1" style="font-size: 0.72rem;">OFFICIAL NATIONAL KHQR</span>
                                    <span class="badge bg-primary text-white px-2 py-1" style="font-size: 0.72rem;">ACLEDA BANK PLC</span>
                                    <span class="badge bg-warning text-dark fw-bold px-2 py-1" style="font-size: 0.72rem;">KHR (រៀល)</span>
                                </div>

                                <h4 class="text-white fw-bold mb-1" style="font-size: 1.35rem; letter-spacing: 0.2px;">
                                    ស្កេនទូទាត់ជាមួយ ACLEDA Bank KHQR
                                </h4>
                                <p class="text-slate-300 mb-3 small" style="line-height: 1.6;">
                                    អាចស្កេនទូទាត់បានជាមួយគ្រប់ App ធនាគារក្នុងប្រទេសកម្ពុជា (ACLEDA Mobile, ABA Mobile, Bakong, Wing, Canadia...)។
                                </p>

                                <!-- Exact Amount to Pay Box -->
                                <div class="p-3 rounded-3 mb-3" style="background: rgba(212, 175, 55, 0.14); border: 1px solid rgba(212, 175, 55, 0.45); box-shadow: 0 4px 15px rgba(0,0,0,0.25);">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="text-slate-200 text-uppercase fw-bold" style="font-size: 0.78rem; letter-spacing: 0.5px;">
                                            <i class="fa-solid fa-money-bill-transfer text-warning me-1"></i> ចំនួនទឹកប្រាក់ត្រូវស្កេនទូទាត់ (EXACT AMOUNT TO PAY)
                                        </span>
                                        <span class="badge bg-danger text-white fw-bold px-2 py-1" style="font-size: 0.7rem;">KHR (រៀល)</span>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-baseline gap-2 mt-2">
                                        <span class="fs-2 fw-bold text-warning font-serif">
                                            ៛<span id="khqr-total-display">{{ number_format($grandTotal, 0) }}</span>
                                        </span>
                                        <span class="text-white fw-bold fs-5">
                                            (<span id="khqr-total-riel">{{ number_format($grandTotal, 0) }}</span> រៀល / KHR)
                                        </span>
                                        <span class="text-slate-400 small ms-auto font-serif">
                                            &bull; $<span id="khqr-total-usd">{{ number_format($grandTotal, 2) }}</span> USD
                                        </span>
                                    </div>
                                    <p class="text-slate-300 mb-0 mt-2 small" style="line-height: 1.5;">
                                        *សូមបញ្ចូល ឬផ្ទៀងផ្ទាត់ចំនួនទឹកប្រាក់ <strong class="text-warning fw-bold">៛<span id="khqr-note-amount">{{ number_format($grandTotal, 0) }}</span></strong> ឲ្យបានត្រឹមត្រូវពេលស្កេនក្នុង App ធនាគារ
                                    </p>
                                </div>

                                <!-- Concise Step-by-Step Instructions -->
                                <div class="p-3 rounded-3" style="background: rgba(0, 0, 0, 0.5); border: 1px solid rgba(255, 255, 255, 0.12);">
                                    <h6 class="text-white fw-bold text-uppercase mb-2 small" style="letter-spacing: 0.5px;">
                                        <i class="fa-solid fa-list-check text-warning me-2"></i> របៀបស្កេនទូទាត់ (Step-by-Step Instructions)
                                    </h6>
                                    <ol class="text-slate-200 ps-3 mb-0 small" style="line-height: 1.85;">
                                        <li>បើកកម្មវិធី <strong>ACLEDA Mobile</strong>, <strong>ABA Mobile</strong>, <strong>Bakong</strong> ឬធនាគារណាមួយដែលមាន KHQR។</li>
                                        <li>ចុចប៊ូតុង <strong>Scan QR</strong> ហើយស្កេនរូប QR របស់ <strong>ACLEDA Bank</strong> ខាងឆ្វេង។</li>
                                        <li>ផ្ទៀងផ្ទាត់ឈ្មោះគណនីទទួល៖ <strong class="text-info fw-bold">Ang Sinin</strong> (Member of KHQR / ACLEDA Bank)។</li>
                                        <li>ផ្ទៀងផ្ទាត់ទឹកប្រាក់ពិតប្រាកដចំនួន៖ <strong class="text-warning font-serif fw-bold">៛<span id="khqr-instruction-total">{{ number_format($grandTotal, 0) }}</span> (<span id="khqr-instruction-riel">{{ number_format($grandTotal, 0) }}</span> រៀល)</strong>។</li>
                                        <li>ចុចយល់ព្រមផ្ទេរប្រាក់ក្នុង App រួចចុចប៊ូតុង <strong>"Place Vehicle Order"</strong> ខាងស្តាំដើម្បីបញ្ចប់ការកុម្ម៉ង់!</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. COD / SHOWROOM PANEL -->
                    <div id="payment-ui-cod" class="p-4 rounded-3 {{ $selectedPayment === 'Cash on Delivery (COD) / Pay at Showroom' ? '' : 'd-none' }}" 
                         style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-3 rounded-circle text-success fs-2" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25);">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </div>
                            <div>
                                <h6 class="text-white fw-bold mb-1 font-serif">Pay Upon Delivery / Handover Ceremony</h6>
                                <p class="text-slate-300 small mb-0" style="line-height: 1.5;">
                                    Our atelier logistics manager will arrive with official vehicle title deed and certificate. You can inspect the vehicle thoroughly before final payment sign-off with cashier check or cash.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- 3. CREDIT / DEBIT CARD PANEL -->
                    <div id="payment-ui-card" class="p-4 rounded-3 {{ $selectedPayment === 'Credit / Debit Card' ? '' : 'd-none' }}" 
                         style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-white fw-bold mb-0">Credit / Debit Card Details</h6>
                            <div class="d-flex gap-2 text-light fs-5">
                                <i class="fa-brands fa-cc-visa text-info"></i>
                                <i class="fa-brands fa-cc-mastercard text-warning"></i>
                                <i class="fa-brands fa-cc-amex text-primary"></i>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label text-slate-300 small">Cardholder Name</label>
                                <input type="text" class="form-control form-control-luxury" placeholder="Alexander Vanderbilt">
                            </div>
                            <div class="col-12">
                                <label class="form-label text-slate-300 small">Card Number</label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-luxury"><i class="fa-solid fa-credit-card"></i></span>
                                    <input type="text" class="form-control form-control-luxury" placeholder="4242 &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 4242" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-slate-300 small">Expiration Date</label>
                                <input type="text" class="form-control form-control-luxury" placeholder="MM / YY">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-slate-300 small">CVV / CVC</label>
                                <input type="password" maxlength="4" class="form-control form-control-luxury" placeholder="123">
                            </div>
                        </div>
                    </div>

                    <!-- 4. DIGITAL WALLET PANEL -->
                    <div id="payment-ui-wallet" class="p-4 rounded-3 {{ $selectedPayment === 'Digital Wallet (ABA Pay / Wing / Bakong)' ? '' : 'd-none' }}" 
                         style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.1);">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-white fw-bold mb-0">Digital Wallet & Instant Mobile Banking</h6>
                            <span class="badge bg-success">INSTANT CLEARANCE</span>
                        </div>
                        <p class="text-slate-300 small mb-3">
                            Direct mobile transfer via National Bakong, ABA Pay, or Wing Bank. All Cambodian e-wallets route seamlessly through KHQR to <strong>Ang Sinin (ACLEDA Bank)</strong>.
                        </p>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span class="badge bg-primary fs-6 px-3 py-2"><i class="fa-solid fa-building-columns me-1"></i> ACLEDA Mobile</span>
                            <span class="badge bg-primary bg-opacity-75 fs-6 px-3 py-2"><i class="fa-solid fa-mobile-screen-button me-1"></i> ABA Pay</span>
                            <span class="badge bg-danger fs-6 px-3 py-2"><i class="fa-solid fa-network-wired me-1"></i> Bakong Wallet</span>
                            <span class="badge bg-info text-dark fs-6 px-3 py-2"><i class="fa-solid fa-wallet me-1"></i> Wing Bank</span>
                        </div>
                        <div class="p-3 rounded bg-dark border border-secondary border-opacity-25 text-center">
                            <span class="text-slate-300 small d-block">You can also scan the ACLEDA KHQR code directly using any of the above digital wallet apps.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- RIGHT COLUMN: ORDER SUMMARY SIDEBAR       -->
            <!-- ========================================== -->
            <div class="col-lg-4">
                <div class="glass-panel rounded-4 p-4 shadow-sm position-sticky" style="top: 100px; border: 1px solid rgba(212, 175, 55, 0.3);">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-crown text-warning"></i>
                            <h4 class="h5 text-white fw-bold font-serif mb-0">ORDER SUMMARY</h4>
                        </div>
                        <span class="badge bg-warning text-dark font-serif fw-bold">VEHICLE FLEET</span>
                    </div>

                    <!-- Cart Item Thumbnails & Details -->
                    <div class="mb-3 overflow-auto pe-1" style="max-height: 250px;">
                        @foreach($cart as $id => $item)
                            <div class="d-flex align-items-center gap-3 mb-3 pb-2 border-bottom border-secondary border-opacity-10">
                                <img src="{{ $item['image_url'] }}" 
                                     alt="{{ $item['name'] }}" 
                                     class="rounded-2 shadow-sm" 
                                     style="width: 58px; height: 44px; object-fit: cover; border: 1px solid rgba(255, 255, 255, 0.1);">
                                <div class="flex-grow-1 text-truncate">
                                    <h6 class="text-white fw-semibold mb-0 small text-truncate" title="{{ $item['name'] }}">
                                        {{ $item['name'] }}
                                    </h6>
                                    <small class="text-slate-400 d-block" style="font-size: 0.72rem;">
                                        Qty: {{ $item['quantity'] }} &times; 
                                        @if($item['price'] <= 500)
                                            ៛{{ number_format($item['price'], 0) }} / ${{ number_format($item['price'], 0) }}
                                        @else
                                            ${{ number_format($item['price'], 2) }}
                                        @endif
                                    </small>
                                </div>
                                <div class="text-end">
                                    <span class="text-warning fw-bold small font-serif d-block">
                                        @if($item['price'] * $item['quantity'] <= 500)
                                            ៛{{ number_format($item['price'] * $item['quantity'], 0) }}
                                        @else
                                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Line Items Breakdown -->
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-300 small">Fleet Subtotal:</span>
                        <span class="text-white fw-semibold small font-serif" id="sidebar-subtotal">
                            @if($subtotal <= 500)
                                ៛{{ number_format($subtotal, 0) }} (${{ number_format($subtotal, 2) }})
                            @else
                                ${{ number_format($subtotal, 2) }}
                            @endif
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-300 small">Shipping & Handover:</span>
                        <span class="text-info fw-semibold small font-serif" id="sidebar-shipping">
                            @if($shippingFee > 0)
                                ${{ number_format($shippingFee, 2) }}
                            @else
                                FREE ($0.00)
                            @endif
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-slate-300 small">VIP Voucher Discount:</span>
                        <span class="text-success fw-semibold small font-serif" id="sidebar-discount">
                            @if($discount > 0)
                                -${{ number_format($discount, 2) }}
                            @else
                                $0.00
                            @endif
                        </span>
                    </div>

                    <hr class="border-secondary border-opacity-25 my-3">

                    <!-- Live Dynamic Grand Total in both Currency & Riel -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="text-white fw-bold font-serif d-block fs-6">GRAND TOTAL</span>
                            <small class="text-slate-400" style="font-size: 0.7rem;">Verified Title & Handover Included</small>
                        </div>
                        <div class="text-end">
                            <span class="fs-2 fw-bold text-warning font-serif d-block" style="line-height: 1.1;">
                                ៛<span id="sidebar-grandtotal">{{ number_format($grandTotal, 0) }}</span>
                            </span>
                            <div class="text-slate-300 font-serif small mt-1" style="font-size: 0.78rem;">
                                (<span id="sidebar-grandtotal-riel">{{ number_format($grandTotal, 0) }}</span> រៀល / KHR)
                                <span class="text-slate-400 ms-1">&bull; $<span id="sidebar-grandtotal-usd">{{ number_format($grandTotal, 2) }}</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Primary Action Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-lg gold-gradient-btn py-3 rounded-pill fw-bold shadow">
                            <i class="fa-solid fa-lock me-2"></i> Place Vehicle Order
                        </button>
                    </div>

                    <!-- Concise Back to Cart Link -->
                    <div class="text-center mb-4">
                        <a href="{{ route('cart.index') }}" class="back-link-gold text-decoration-none small fw-semibold">
                            &larr; Back to Cart
                        </a>
                    </div>

                    <!-- Trust & Buyer Protection Card -->
                    <div class="p-3 rounded-3" style="background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.08);">
                        <div class="d-flex align-items-center gap-2 mb-2 text-warning small">
                            <i class="fa-solid fa-shield-check"></i>
                            <strong class="font-serif">Apex Atelier Buyer Protection</strong>
                        </div>
                        <p class="text-slate-400 mb-0" style="font-size: 0.72rem; line-height: 1.45;">
                            All orders are protected under certified automotive escrow. Vehicles include clear title, CarFax guarantee, and pre-handover white-glove inspection.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const subtotal = {{ (float)$subtotal }};
    const discount = {{ (float)$discount }};

    function selectShippingCard(labelElement) {
        const radio = labelElement.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
            updateShipping(radio);
        }
    }

    function selectPaymentCard(type, labelElement) {
        const radio = labelElement.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
            switchPaymentUi(type);
        }
    }

    function updateShipping(radio) {
        const fee = parseFloat(radio.getAttribute('data-fee')) || 0;
        const newGrandTotal = Math.max(0, subtotal + fee - discount);
        const formattedTotal = Math.round(newGrandTotal).toLocaleString('en-US');
        const formattedUsd = newGrandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const formattedFee = fee.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        // Update shipping cards UI highlight
        document.querySelectorAll('.shipping-card').forEach(card => card.classList.remove('active'));
        const activeCard = radio.closest('.shipping-card');
        if (activeCard) {
            activeCard.classList.add('active');
        }

        // Update sidebar line items
        const shippingEl = document.getElementById('sidebar-shipping');
        if (shippingEl) {
            shippingEl.innerText = fee === 0 ? 'FREE ($0.00)' : '$' + formattedFee;
        }

        const grandTotalEl = document.getElementById('sidebar-grandtotal');
        if (grandTotalEl) {
            grandTotalEl.innerText = formattedTotal;
        }

        const grandTotalUsdEl = document.getElementById('sidebar-grandtotal-usd');
        if (grandTotalUsdEl) {
            grandTotalUsdEl.innerText = formattedUsd;
        }

        const sidebarRiel = document.getElementById('sidebar-grandtotal-riel');
        if (sidebarRiel) {
            sidebarRiel.innerText = formattedTotal;
        }

        // Update KHQR Panel dynamic numbers
        const khqrTotal = document.getElementById('khqr-total-display');
        if (khqrTotal) {
            khqrTotal.innerText = formattedTotal;
        }

        const khqrUsd = document.getElementById('khqr-total-usd');
        if (khqrUsd) {
            khqrUsd.innerText = formattedUsd;
        }

        const khqrRiel = document.getElementById('khqr-total-riel');
        if (khqrRiel) {
            khqrRiel.innerText = formattedTotal;
        }

        const khqrNote = document.getElementById('khqr-note-amount');
        if (khqrNote) {
            khqrNote.innerText = formattedTotal;
        }

        const khqrInstructionTotal = document.getElementById('khqr-instruction-total');
        if (khqrInstructionTotal) {
            khqrInstructionTotal.innerText = formattedTotal;
        }

        const khqrInstructionRiel = document.getElementById('khqr-instruction-riel');
        if (khqrInstructionRiel) {
            khqrInstructionRiel.innerText = formattedTotal;
        }
    }

    function switchPaymentUi(type) {
        // Highlight active payment card
        document.querySelectorAll('.payment-choice-card').forEach(card => card.classList.remove('active'));
        const activeRadio = document.querySelector('input[name="payment_method"][data-type="' + type + '"]');
        if (activeRadio) {
            activeRadio.checked = true;
            const parentCard = activeRadio.closest('.payment-choice-card');
            if (parentCard) {
                parentCard.classList.add('active');
            }
        }

        // Toggle details panels
        ['khqr', 'cod', 'card', 'wallet'].forEach(p => {
            const el = document.getElementById('payment-ui-' + p);
            if (el) {
                if (p === type) {
                    el.classList.remove('d-none');
                } else {
                    el.classList.add('d-none');
                }
            }
        });
    }
</script>
@endpush
