<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
// use Cart;////추후에...

class ProductController extends Controller
{
    public function index()
    {
        //dd(Cart::content());////추후에...
        $products = Product::inRandomOrder()->take(6)->get();
        //dd($products);
        return view('products.index')->with('products', $products);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return view('products.show')->with('product', $product);
    }
}
