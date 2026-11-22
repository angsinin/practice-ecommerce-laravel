@extends('layouts.app')

@section('title', 'Shopping Cart | Apex Motors Luxury Atelier')

@section('content')
<div class="container py-4 py-md-5">
    <!-- TOP STEP PROGRESS INDICATOR & SECURED BADGE -->
    <div class="mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
            <!-- Luxury Stepper: Step 1 Cart is Active -->
            <div class="luxury-stepper" aria-label="Checkout Progress">
                <!-- Step 1: Cart (Current Active) -->
                <div class="step-item active">
                    <span class="step-num font-serif">1</span>
                    <span class="font-serif fw-bold">Cart & Fleet</span>
                </div>

                <span class="stepper-separator"><i class="fa-solid fa-chevron-right"></i></span>

                <!-- Step 2: Shipping & Payment (Upcoming) -->
                <div class="step-item upcoming">
                    <span class="step-num font-serif">2</span>
                    <span>Shipping & KHQR Payment</span>
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

        <!-- Header Title Bar -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center pb-3 border-bottom border-secondary border-opacity-25">
            <div>
                <h1 class="h2 text-white fw-bold mb-1 font-serif">
                    <i class="fa-solid fa-cart-shopping text-warning me-2"></i> YOUR LUXURY CAR CART
                </h1>
                <p class="text-slate-300 small mb-0">Review your selected automotive fleet before proceeding to secured concierge checkout and KHQR settlement.</p>
            </div>
            @if(!empty($cart) && count($cart) > 0)
                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all vehicles from your cart?');">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger mt-3 mt-md-0 rounded-pill px-3">
                        <i class="fa-solid fa-trash-can me-1"></i> Clear Entire Cart
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(empty($cart) || count($cart) === 0)
        <!-- EMPTY CART STATE -->
        <div class="text-center py-5 glass-panel rounded-4 shadow-sm my-5">
            <div class="mb-4 d-inline-flex p-4 rounded-circle bg-dark border border-secondary border-opacity-50 text-warning" style="font-size: 3.5rem;">
                <i class="fa-solid fa-car-tunnel"></i>
            </div>
            <h3 class="text-white fw-bold font-serif mb-2">Your Showroom Cart is Empty</h3>
            <p class="text-slate-300 mb-4 mx-auto" style="max-width: 500px; font-size: 0.95rem;">
                You haven't reserved any luxury vehicles yet. Explore our premier inventory of sports cars, luxury SUVs, EVs, and budget city cruisers starting from just 100 / 200 រៀល (KHR).
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('products.index') }}" class="btn gold-gradient-btn px-4 py-2 rounded-pill fw-bold">
                    <i class="fa-solid fa-compass me-2"></i> Explore Showroom Fleet
                </a>
            </div>
        </div>
    @else
        <!-- CART HAS ITEMS -->
        <div class="row g-4">
            <!-- Left Side: Items Table/List -->
            <div class="col-lg-8">
                <div class="glass-panel rounded-4 p-4 shadow-sm mb-4" style="border: 1px solid rgba(212, 175, 55, 0.2);">
                    <div class="table-responsive">
                        <table class="table table-dark table-borderless align-middle mb-0" style="background: transparent;">
                            <thead>
                                <tr class="text-slate-400 small text-uppercase border-bottom border-secondary border-opacity-25" style="letter-spacing: 0.5px;">
                                    <th scope="col" style="min-width: 280px;">Vehicle Fleet</th>
                                    <th scope="col" class="text-center">Unit Price</th>
                                    <th scope="col" class="text-center" style="width: 140px;">Quantity</th>
                                    <th scope="col" class="text-end">Subtotal</th>
                                    <th scope="col" class="text-end" style="width: 60px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $item)
                                    @php
                                        $itemSubtotal = $item['price'] * $item['quantity'];
                                    @endphp
                                    <tr class="border-bottom border-secondary border-opacity-10" id="cart-row-{{ $id }}">
                                        <!-- Vehicle Info -->
                                        <td>
                                            <div class="d-flex align-items-center gap-3 py-2">
                                                <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="rounded-3 shadow-sm" style="width: 85px; height: 60px; object-fit: cover; border: 1px solid rgba(255, 255, 255, 0.1);">
                                                <div>
                                                    <span class="badge bg-secondary text-light px-2 py-0 small mb-1" style="font-size: 0.65rem;">
                                                        {{ $item['brand'] }} &bull; {{ $item['model_year'] ?? '2025' }}
                                                    </span>
                                                    <h6 class="text-white fw-bold mb-0 text-truncate" style="max-width: 220px;" title="{{ $item['name'] }}">
                                                        {{ $item['name'] }}
                                                    </h6>
                                                    <small class="text-slate-400">Stock Unit #{{ $id }}</small>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Unit Price (with dual Riel / USD display for low test amounts) -->
                                        <td class="text-center font-serif text-warning fw-semibold">
                                            @if($item['price'] <= 500)
                                                <div class="d-block">
                                                    ៛{{ number_format($item['price'], 0) }}
                                                    <small class="text-slate-400 d-block" style="font-size: 0.72rem;">(${{ number_format($item['price'], 0) }})</small>
                                                </div>
                                            @else
                                                ${{ number_format($item['price'], 2) }}
                                            @endif
                                        </td>

                                        <!-- Quantity Controls -->
                                        <td class="text-center">
                                            <div class="d-inline-flex align-items-center rounded-pill bg-dark border border-secondary border-opacity-50 p-1">
                                                <!-- Decrease Form -->
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="decrease">
                                                    <button type="submit" class="btn btn-sm text-light px-2 py-0 border-0 bg-transparent" title="Decrease Quantity">
                                                        <i class="fa-solid fa-minus small"></i>
                                                    </button>
                                                </form>

                                                <span class="px-2 fw-bold text-light font-serif" style="min-width: 28px;">
                                                    {{ $item['quantity'] }}
                                                </span>

                                                <!-- Increase Form -->
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="action" value="increase">
                                                    <button type="submit" class="btn btn-sm text-light px-2 py-0 border-0 bg-transparent" title="Increase Quantity">
                                                        <i class="fa-solid fa-plus small"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                        <!-- Item Subtotal -->
                                        <td class="text-end font-serif text-white fw-bold fs-6">
                                            @if($itemSubtotal <= 500)
                                                <div>
                                                    <span class="text-warning">៛{{ number_format($itemSubtotal, 0) }}</span>
                                                    <small class="text-slate-400 d-block" style="font-size: 0.72rem;">(${{ number_format($itemSubtotal, 0) }})</small>
                                                </div>
                                            @else
                                                ${{ number_format($itemSubtotal, 2) }}
                                            @endif
                                        </td>

                                        <!-- Delete Action -->
                                        <td class="text-end">
                                            <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Remove {{ $item['name'] }} from cart?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm text-danger border-0 bg-transparent p-2 hover-opacity" title="Remove Vehicle">
                                                    <i class="fa-solid fa-trash-can fs-6"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Continue Shopping Link -->
                    <div class="mt-4 pt-3 border-top border-secondary border-opacity-25 d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <a href="{{ route('products.index') }}" class="text-warning text-decoration-none small fw-semibold">
                            <i class="fa-solid fa-arrow-left me-1"></i> Continue Shopping Vehicles
                        </a>
                        <span class="text-slate-400 small">
                            <i class="fa-solid fa-shield-halved text-success me-1"></i> Certified Pre-Delivery Inspection Guaranteed
                        </span>
                    </div>
                </div>

                <!-- Promo / Discount Code Box -->
                <div class="glass-panel rounded-4 p-4 shadow-sm" style="border: 1px solid rgba(212, 175, 55, 0.2);">
                    <h5 class="text-white fw-bold font-serif mb-2">
                        <i class="fa-solid fa-ticket text-warning me-2"></i> Promotional & VIP Discount Voucher
                    </h5>
                    <p class="text-slate-300 small mb-3">Apply an atelier VIP voucher to claim promotional incentives on your order.</p>

                    @if(!empty($promoCode))
                        <div class="p-3 rounded-3 bg-dark border border-success d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-success me-2">APPLIED</span>
                                <strong class="text-light">{{ $promoCode }}</strong>
                                <span class="text-success small ms-2">(-${{ number_format($discount, 2) }} savings)</span>
                            </div>
                            <form action="{{ route('cart.coupon.remove') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="fa-solid fa-xmark me-1"></i> Remove
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('cart.coupon') }}" method="POST" class="row g-2 align-items-center">
                            @csrf
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-secondary text-secondary">
                                        <i class="fa-solid fa-tag"></i>
                                    </span>
                                    <input type="text" name="coupon_code" class="form-control bg-dark text-light border-secondary" placeholder="Enter code (e.g. VIP100)" required style="text-transform: uppercase;">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn gold-gradient-btn w-100 py-2 rounded-3 fw-bold">
                                    Apply Code
                                </button>
                            </div>
                        </form>

                        <!-- Quick 1-Click Code Buttons -->
                        <div class="mt-3 pt-2 d-flex flex-wrap align-items-center gap-2">
                            <span class="small text-slate-400 me-1">Available Test Codes:</span>
                            <form action="{{ route('cart.coupon') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="coupon_code" value="VIP100">
                                <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-2 py-0" style="font-size: 0.75rem;">
                                    <strong>VIP100</strong> ($100 OFF)
                                </button>
                            </form>
                            <form action="{{ route('cart.coupon') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="coupon_code" value="LUXURY500">
                                <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill px-2 py-0" style="font-size: 0.75rem;">
                                    <strong>LUXURY500</strong> ($500 OFF)
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Side: Order Calculation & Proceed to Checkout -->
            <div class="col-lg-4">
                <div class="glass-panel rounded-4 p-4 shadow-sm position-sticky" style="top: 100px; border: 1px solid rgba(212, 175, 55, 0.3);">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-secondary border-opacity-25">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-crown text-warning"></i>
                            <h5 class="text-white fw-bold font-serif mb-0">ORDER SUMMARY</h5>
                        </div>
                        <span class="badge bg-warning text-dark font-serif fw-bold">STAGE 1</span>
                    </div>

                    <!-- Calculation Lines -->
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-300 small">Vehicle Fleet Subtotal:</span>
                        <span class="text-light fw-semibold small font-serif">
                            @if($subtotal <= 500)
                                ៛{{ number_format($subtotal, 0) }} (${{ number_format($subtotal, 2) }})
                            @else
                                ${{ number_format($subtotal, 2) }}
                            @endif
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-slate-300 small">VIP Voucher Discount:</span>
                        <span class="text-success fw-semibold small font-serif">
                            @if($discount > 0)
                                -${{ number_format($discount, 2) }}
                            @else
                                $0.00
                            @endif
                        </span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-slate-300 small">Estimated Transport:</span>
                        <span class="text-info small">Calculated at Checkout (Free Pickup or VIP Delivery)</span>
                    </div>

                    <hr class="border-secondary border-opacity-25 my-3">

                    <!-- Grand Total in both Currency & Riel -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="text-light fw-bold font-serif d-block">GRAND TOTAL</span>
                            <small class="text-slate-400" style="font-size: 0.72rem;">Verified Title & Handover Included</small>
                        </div>
                        <div class="text-end">
                            <span class="fs-2 fw-bold text-warning font-serif d-block" style="line-height: 1.1;">
                                ៛{{ number_format($grandTotal, 0) }}
                            </span>
                            <div class="text-slate-300 font-serif small mt-1" style="font-size: 0.78rem;">
                                ({{ number_format($grandTotal, 0) }} រៀល / KHR)
                                <span class="text-slate-400 ms-1">&bull; ${{ number_format($grandTotal, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Proceed to Checkout Button -->
                    <div class="d-grid mb-3">
                        <a href="{{ route('checkout.index') }}" class="btn btn-lg gold-gradient-btn py-3 rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2 shadow">
                            <span>Proceed to Checkout</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <!-- Payment Preview Teaser Banner -->
                    <div class="p-3 rounded-3 mb-3" style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(212, 175, 55, 0.25);">
                        <div class="d-flex align-items-center gap-2 text-warning small fw-bold mb-1">
                            <i class="fa-solid fa-qrcode"></i>
                            <span>KHQR Settlement Ready</span>
                        </div>
                        <p class="text-slate-300 mb-2" style="font-size: 0.75rem; line-height: 1.45;">
                            Official <strong>ACLEDA Bank KHQR</strong> (Ang Sinin), ABA Pay, Cards & Showroom Handover available on the next step.
                        </p>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-danger text-white px-2 py-0" style="font-size: 0.65rem;">ACLEDA KHQR</span>
                            <span class="badge bg-primary text-white px-2 py-0" style="font-size: 0.65rem;">ABA Pay</span>
                            <span class="badge bg-dark border border-secondary text-light px-2 py-0" style="font-size: 0.65rem;">Bakong</span>
                            <span class="badge bg-success text-white px-2 py-0" style="font-size: 0.65rem;">Cash Handover</span>
                        </div>
                    </div>

                    <!-- Security & Concierge Badges -->
                    <div class="p-3 rounded-3 bg-dark bg-opacity-75 border border-secondary border-opacity-25 text-center">
                        <div class="d-flex justify-content-around text-slate-300 small mb-2">
                            <span><i class="fa-solid fa-lock text-warning me-1"></i> 256-Bit Encrypted</span>
                            <span><i class="fa-solid fa-shield text-success me-1"></i> Escrow Secured</span>
                        </div>
                        <small class="text-slate-400 d-block" style="font-size: 0.7rem;">
                            Direct Atelier escrow, KHQR, ABA & major credit cards accepted.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
