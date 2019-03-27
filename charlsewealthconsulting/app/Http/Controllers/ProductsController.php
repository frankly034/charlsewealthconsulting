<?php

namespace App\Http\Controllers;
use App\Cart;
use App\Products;
use Illuminate\Http\Request;
use Session;
use App\http\Requests;

class ProductsController extends Controller
{
    //this handles adding iteems to the shopping cart
    public function getAddToCart(Request $request, $id){
        $product = Products::findOrFail($id);
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        return $request->session()->all();

        

    }

    public function getReduceByOne($id, Request $request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        Session::put('cart', $cart);
        return $request->session()->all();
        
    }

    public function getRemoveItem(Request $request, $id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        Session::put('cart', $cart);
        return $request->session()->all();
    }

    public function resetSession(Request $request){
     return $request->session()->flush();
   }

    public function getCart( Request $request){
        if(!$request->session()->has('cart')){
            return " 123";
            return view('shop.shopping_cart');
        }
        $oldCart = $request->session()->get('cart');
        $cart = new Cart($oldCart);
        dd($request->session()->get('cart'));
        return $cart;
       // $product = $cart->items;
        //$totalPrice = $cart->total->price;
        //return view('shop.shopping_cart');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::latest()->get();
        return $products ;
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
        $this->validate([
            'product_name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image_url' => 'nullable|string'
        ]);

        $product = new Products([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $request->image_url
        ]);
        $product->save();
        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product::findOrFail($id);
        return $product; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product::findOrFail($id);
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $products::findOrFail($id);
        $product_all = $request->all();
        $product->fill($product_all)->update();
        return $product;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        $products::findOrFail($id);

        $product->delete();
        return $product;
        
    }

    
}
