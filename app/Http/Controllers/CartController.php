<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('carts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all);

        ////14/04/2020 현재 github.com/hardevine/LaravelShoppingcart 을  install 할 수 없음.
        //// Cart::add($request->id,$request->title,1,$request->price)
        ////     ->associate('App\Product');

        $duplicate = Cart::search(function($cartItem,$rowId) use ($request) {
            return $cartItem->id == $request->product_id;
        });

        if ($duplicate->isNotEmpty()){
            return redirect()->route('products.index')->with('success', 'already added shopping cart.');
        }

        $product = Product::find($request->product_id);

        Cart::add($product->id,$product->title,1,$product->price)
            ->associate('App\Product');

        return redirect()->route('products.index')->with('success', 'completed to add shopping cart.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        //Cart::remove($rowId);

        return back()->with('success', 'completed to delete...');
    }
}
