@extends('layouts.app')

@section('title', 'Order Confirmation #' . $order->order_number . ' | Apex Motors')

@section('content')
<div class="container py-4 py-md-5">
    <div class="max-w-4xl mx-auto" style="max-width: 860px;">
        <!-- STEP INDICATOR: STAGE 3 CONFIRMATION -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div class="luxury-stepper" aria-label="Checkout Progress">
                <!-- Step 1: Cart (Completed) -->
                <div class="step-item completed">
                    <span class="step-num"><i class="fa-solid fa-check"></i></span>
                    <span class="text-slate-300">Cart</span>
                </div>

                <span class="stepper-separator"><i class="fa-solid fa-chevron-right"></i></span>

                <!-- Step 2: Shipping & Payment (Completed) -->
                <div class="step-item completed">
                    <span class="step-num"><i class="fa-solid fa-check"></i></span>
                    <span class="text-slate-300">Shipping & Payment</span>
                </div>

                <span class="stepper-separator"><i class="fa-solid fa-chevron-right"></i></span>

                <!-- Step 3: Confirmation (Active) -->
                <div class="step-item active">
                    <span class="step-num font-serif">3</span>
                    <span class="font-serif fw-bold">Order Confirmed</span>
                </div>
            </div>

            <!-- Verified Badge -->
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.35);">
                <i class="fa-solid fa-badge-check text-success"></i>
                <span class="text-slate-200 small fw-bold" style="font-size: 0.78rem;">OFFICIALLY REGISTERED</span>
            </div>
        </div>

        <!-- PROMINENT SUCCESS BANNER -->
        <div class="text-center py-4 px-3 mb-4 rounded-4 glass-panel border-warning border-opacity-50 shadow-lg position-relative overflow-hidden">
            <div class="d-inline-flex p-3 rounded-circle mb-3" style="background: rgba(16, 185, 129, 0.2); border: 2px solid #10b981;">
                <i class="fa-solid fa-check text-success" style="font-size: 2.5rem;"></i>
            </div>
            <h1 class="h2 text-white fw-bold font-serif mb-2">ORDER PLACED SUCCESSFULLY!</h1>
            <p class="text-muted mb-3" style="max-width: 580px; margin: 0 auto;">
                Thank you, <strong class="text-warning">{{ $order->customer->full_name }}</strong>. Your vehicle purchase has been recorded in our atelier ledger. Our concierge logistics manager will contact you shortly to coordinate title transfer and handover.
            </p>
            <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-dark border border-secondary border-opacity-50">
                <span class="text-muted small">ORDER ID:</span>
                <span class="badge bg-warning text-dark font-serif fw-bold fs-6">{{ $order->order_number }}</span>
            </div>
        </div>

        <!-- ORDER RECEIPT DETAILS CARD -->
        <div class="glass-panel rounded-4 p-4 p-md-5 shadow-sm mb-4 border-secondary border-opacity-25" id="printableInvoice">
            <!-- Receipt Header -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center pb-4 mb-4 border-bottom border-secondary border-opacity-25">
                <div>
                    <span class="brand-logo fs-4 fw-bold gold-gradient-text">APEX MOTORS ATELIER</span>
                    <span class="d-block text-muted small">Certified Luxury Automotive Bill of Sale & Invoice</span>
                </div>
                <div class="mt-3 mt-md-0 text-md-end">
                    <span class="d-block text-muted small">Order Date:</span>
                    <strong class="text-light">{{ $order->created_at->format('M d, Y h:i A') }}</strong>
                </div>
            </div>

            <!-- 2-Column Metadata: Customer & Order Meta -->
            <div class="row g-4 mb-4 pb-4 border-bottom border-secondary border-opacity-25">
                <!-- Customer Information -->
                <div class="col-md-6">
                    <h6 class="text-warning font-serif text-uppercase small fw-bold mb-3">
                        <i class="fa-solid fa-user-shield me-1"></i> Customer & Title Information
                    </h6>
                    <div class="p-3 rounded-3 bg-dark bg-opacity-75 border border-secondary border-opacity-25">
                        <h6 class="text-light fw-bold mb-1">{{ $order->customer->full_name }}</h6>
                        <div class="text-muted small mb-1">
                            <i class="fa-solid fa-envelope me-1 text-secondary"></i> {{ $order->customer->email }}
                        </div>
                        <div class="text-muted small mb-2">
                            <i class="fa-solid fa-phone me-1 text-secondary"></i> {{ $order->customer->phone }}
                        </div>
                        <div class="text-light small border-top border-secondary border-opacity-25 pt-2">
                            <strong class="text-secondary d-block text-xs text-uppercase">Delivery Address:</strong>
                            {{ $order->customer->address }}
                        </div>
                    </div>
                </div>

                <!-- Order Status & Payment -->
                <div class="col-md-6">
                    <h6 class="text-warning font-serif text-uppercase small fw-bold mb-3">
                        <i class="fa-solid fa-file-invoice-dollar me-1"></i> Order & Logistics Details
                    </h6>
                    <div class="p-3 rounded-3 bg-dark bg-opacity-75 border border-secondary border-opacity-25">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Order Status:</span>
                            <!-- Clean Status Badge -->
                            <span class="badge bg-warning text-dark font-serif fw-bold px-3 py-1">
                                <i class="fa-solid fa-clock-rotate-left me-1"></i> {{ $order->order_status }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Payment Method:</span>
                            <strong class="text-light small">{{ $order->payment_method }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted small">Payment Status:</span>
                            <span class="badge bg-secondary text-light px-2 py-1">{{ $order->payment_status }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top border-secondary border-opacity-25 pt-2">
                            <span class="text-muted small">Shipping / Transport:</span>
                            <strong class="text-info small">{{ $order->shipping_method }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ordered Products Table -->
            <h6 class="text-warning font-serif text-uppercase small fw-bold mb-3">
                <i class="fa-solid fa-car-side me-1"></i> Reserved Vehicles
            </h6>
            <div class="table-responsive mb-4">
                <table class="table table-dark table-borderless align-middle mb-0" style="background: transparent;">
                    <thead>
                        <tr class="text-muted small text-uppercase border-bottom border-secondary border-opacity-25">
                            <th scope="col" style="min-width: 250px;">Vehicle Fleet Description</th>
                            <th scope="col" class="text-center">Unit Price</th>
                            <th scope="col" class="text-center">Quantity</th>
                            <th scope="col" class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr class="border-bottom border-secondary border-opacity-10">
                                <td>
                                    <div class="d-flex align-items-center gap-3 py-2">
                                        @if($item->product && $item->product->image_url)
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="rounded-2" style="width: 70px; height: 50px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="text-white fw-bold mb-0">
                                                {{ $item->product ? $item->product->name : 'Vehicle #' . $item->product_id }}
                                            </h6>
                                            @if($item->product)
                                                <small class="text-muted">
                                                    {{ $item->product->brand }} &bull; Model Year {{ $item->product->model_year }} &bull; Category: {{ $item->product->category->name ?? 'Luxury' }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center font-serif text-light">
                                    ${{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="text-center text-light fw-bold">
                                    {{ $item->quantity }}
                                </td>
                                <td class="text-end font-serif text-warning fw-bold">
                                    ${{ number_format($item->subtotal, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Financial Calculation Summary -->
            <div class="row justify-content-end">
                <div class="col-md-5">
                    <div class="p-3 rounded-3 bg-dark bg-opacity-50 border border-secondary border-opacity-25">
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Subtotal:</span>
                            <span class="text-light fw-semibold font-serif">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Shipping Fee:</span>
                            <span class="text-info fw-semibold font-serif">+${{ number_format($order->shipping_fee, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 small">
                            <span class="text-muted">Discount Applied:</span>
                            <span class="text-success fw-semibold font-serif">-${{ number_format($order->discount, 2) }}</span>
                        </div>
                        <hr class="border-secondary border-opacity-25 my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-light fw-bold font-serif">GRAND TOTAL:</span>
                            <span class="fs-4 fw-bold text-warning font-serif">
                                @if($order->grand_total <= 500)
                                    ៛{{ number_format($order->grand_total, 0) }} ({{ number_format($order->grand_total, 0) }} រៀល)
                                @else
                                    ${{ number_format($order->grand_total, 2) }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="mt-4 pt-4 border-top border-secondary border-opacity-25 text-center text-muted small">
                <p class="mb-1"><i class="fa-solid fa-stamp text-warning me-1"></i> Authorized Apex Motors Atelier Digital Sales Ledger Entry</p>
                <small>For questions or custom delivery arrangements, email concierge@apexmotors.com quoting <strong>{{ $order->order_number }}</strong>.</small>
            </div>
        </div>

        <!-- ACTIONS ROW -->
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <button onclick="window.print()" class="btn btn-outline-warning rounded-pill px-4 py-2">
                <i class="fa-solid fa-print me-2"></i> Print Invoice
            </button>
            <a href="{{ route('products.index') }}" class="btn gold-gradient-btn rounded-pill px-4 py-2 fw-bold shadow">
                <i class="fa-solid fa-car me-2"></i> Return to Showroom Fleet
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        body {
            background-color: #fff !important;
            color: #000 !important;
        }
        .navbar-luxury, footer, .btn, .breadcrumb {
            display: none !important;
        }
        .glass-panel {
            background: #fff !important;
            color: #000 !important;
            border: 1px solid #ccc !important;
            box-shadow: none !important;
        }
        .text-white, .text-light {
            color: #000 !important;
        }
        .text-muted {
            color: #555 !important;
        }
        .table-dark {
            background: #fff !important;
            color: #000 !important;
        }
        .table-dark th, .table-dark td {
            color: #000 !important;
            border-color: #ddd !important;
        }
    }
</style>
@endpush
