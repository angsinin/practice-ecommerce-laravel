@extends('layouts.app')

@section('title', $product->name . ' | Apex Motors Luxury Atelier')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav class="mb-4">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-muted text-decoration-none">Showroom</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="text-muted text-decoration-none">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active text-warning" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Vehicle Hero Media -->
        <div class="col-lg-7">
            <div class="rounded-4 overflow-hidden border border-secondary border-opacity-25 shadow-lg position-relative mb-3">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-100" style="max-height: 480px; object-fit: cover;">
                <span class="position-absolute top-0 end-0 m-3 badge bg-black bg-opacity-75 text-warning font-serif px-3 py-2 fs-6">
                    Model Year {{ $product->model_year }}
                </span>
            </div>

            <!-- Atelier Guarantees -->
            <div class="row g-3">
                <div class="col-sm-4">
                    <div class="p-3 rounded-3 bg-dark bg-opacity-75 border border-secondary border-opacity-25 text-center">
                        <i class="fa-solid fa-gauge-high text-warning fs-4 mb-2"></i>
                        <h6 class="text-white small fw-bold mb-1">Dynamometer Tested</h6>
                        <small class="text-muted" style="font-size: 0.72rem;">Certified horsepower output</small>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="p-3 rounded-3 bg-dark bg-opacity-75 border border-secondary border-opacity-25 text-center">
                        <i class="fa-solid fa-car-burst text-success fs-4 mb-2"></i>
                        <h6 class="text-white small fw-bold mb-1">Clean Title Guarantee</h6>
                        <small class="text-muted" style="font-size: 0.72rem;">Zero structural damage</small>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="p-3 rounded-3 bg-dark bg-opacity-75 border border-secondary border-opacity-25 text-center">
                        <i class="fa-solid fa-plane-departure text-info fs-4 mb-2"></i>
                        <h6 class="text-white small fw-bold mb-1">Global Transport</h6>
                        <small class="text-muted" style="font-size: 0.72rem;">Air freight & enclosed carrier</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicle Details & Purchase Card -->
        <div class="col-lg-5">
            <div class="glass-panel rounded-4 p-4 p-md-5 shadow-sm">
                <span class="badge bg-secondary text-light px-3 py-1 mb-2">{{ $product->category->name }}</span>
                <span class="text-muted small text-uppercase d-block tracking-wider mb-1">{{ $product->brand }}</span>
                <h1 class="h2 text-white fw-bold mb-3 font-serif">{{ $product->name }}</h1>

                <!-- Direct Price -->
                <div class="mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                    <small class="text-muted d-block text-uppercase" style="font-size: 0.75rem;">Atelier Showroom Price</small>
                    <span class="fs-1 fw-bold text-warning font-serif">
                        ${{ number_format($product->price, 2) }}
                    </span>
                    <span class="text-muted small ms-2">USD</span>
                </div>

                <div class="mb-4">
                    <h6 class="text-warning font-serif small text-uppercase fw-bold mb-2">Vehicle Specification & Overview</h6>
                    <p class="text-muted" style="line-height: 1.6;">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Stock availability -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge {{ $product->stock > 0 ? 'bg-success' : 'bg-danger' }} p-1 rounded-circle"> </span>
                        <strong class="text-light small">
                            {{ $product->stock > 0 ? "In Stock ({$product->stock} Available for Immediate Acquisition)" : 'Currently Reserved' }}
                        </strong>
                    </div>
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="row g-2 align-items-center mb-3">
                        <div class="col-4">
                            <label class="form-label text-muted small mb-1">Quantity</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ max(1, $product->stock) }}" class="form-control bg-dark text-light border-secondary text-center">
                        </div>
                        <div class="col-8 d-flex align-items-end">
                            <button type="submit" class="btn gold-gradient-btn w-100 py-2 rounded-3 fw-bold">
                                <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </form>

                <div class="d-grid gap-2">
                    <a href="{{ route('checkout.index') }}" class="btn btn-outline-warning rounded-pill py-2">
                        <i class="fa-solid fa-lock me-2"></i> Direct Concierge Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
