<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::with('category')   // eager loading -> hindari N+1
            ->active()
            ->inStock()
            ->when($request->query('q'), fn ($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    /** Bonus: demo perbandingan jumlah query lazy loading (N+1) vs eager loading. */
    public function eagerDemo(): JsonResponse
    {
        DB::enableQueryLog();

        $products = Product::take(20)->get();
        foreach ($products as $product) {
            $product->category->name; // memicu 1 query per produk
        }
        $lazy = count(DB::getQueryLog());

        DB::flushQueryLog();

        $products = Product::with('category')->take(20)->get();
        foreach ($products as $product) {
            $product->category->name; // sudah ter-load
        }
        $eager = count(DB::getQueryLog());

        return response()->json([
            'lazy_loading_queries' => $lazy,   // 1 + 20 = 21
            'eager_loading_queries' => $eager, // 2
        ]);
    }
}
