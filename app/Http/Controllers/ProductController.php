<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of luxury car products with filtering and search.
     */
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();

        $query = Product::with('category');

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search by keyword (Name, Brand, Description, Year)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('model_year', 'like', "%{$search}%");
            });
        }

        // Price Filter (starting from $100+)
        if ($request->filled('min_price')) {
            $query->where('price', '>=', floatval($request->min_price));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', floatval($request->max_price));
        }

        // Sorting
        $sort = $request->get('sort', 'featured');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'year_desc':
                $query->orderBy('model_year', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('price', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $request->category,
            'search' => $request->search,
            'minPrice' => $request->get('min_price', 100),
            'maxPrice' => $request->max_price,
            'sort' => $sort,
        ]);
    }

    /**
     * Display the specified vehicle.
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(3)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
