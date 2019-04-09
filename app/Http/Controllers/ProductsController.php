<?php

namespace App\Http\Controllers;
use App\Cart;
use App\Products;
use Illuminate\Http\Request;
use Session;
use Cloudder;
use App\http\Requests;
use App\Http\Controllers\Controller;
use Paystack;
use App\Transaction;



class ProductsController extends Controller
{
    //this handles adding items to the shopping cart
    public function addToCart(Request $request, $id){
        $product = Products::findOrFail($id);
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        return json_encode($request->session()->get('cart'));
    }

    public function reduceItemByOne($id, Request $request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        Session::put('cart', $cart);
        return json_encode($request->session()->get('cart'));
        
    }

    public function removeItem(Request $request, $id){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        Session::put('cart', $cart);
        return json_encode($request->session()->get('cart'));
    }

    public function emptyCart(){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        Session::forget('cart');
        $cart = null;

      return json_encode(Session::get('cart'));
   }

    public function getCart(Request $request){
        //dd(request()->session()->get('cart'));
        if(!Session::has('cart')){
            return view('products.test_cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $product = $cart->items;
        $totalPrice = $cart->totalPrice;
        $totalQty = $cart->totalQty;
        return view('products.test_cart', compact('product','totalPrice','totalQty'));
    }
    /**
     * From paystack
     * 
     */

     
    public function redirectToGateway()
    {

        request()->metadata = json_encode(request()->all());
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback(Request $request)
    {
     
        $paymentDetails = Paystack::getPaymentData();
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        if($paymentDetails){
            $order = new Transaction();
            $order->reference_id = $paymentDetails['data']['reference'];
            $order->amount = $paymentDetails['data']['amount'];
            $order->state = $paymentDetails['data']['metadata']['state'];
            $order->address = $paymentDetails['data']['metadata']['address'];
            $order->fullName = $paymentDetails['data']['metadata']['fullName'];
            $order->email = $paymentDetails['data']['metadata']['email'];
            $order->paid_at = $paymentDetails['data']['paidAt'];
            $order->currency = $paymentDetails['data']['currency'];
            $order->cart = serialize($cart);
            $order->status = "Pending";
            $order->save();
        }
        $this->emptyCart();


        //return $paymentDetails;
        //dd($paymentDetails['data']);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
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
        
        $this->validate($request,[
            'product_name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required|mimes:jpeg,bmp,jpg,png|between:1, 6000'

        ]);

        if($request->hasFile('image')){
            $image = $request->file('image')->getRealPath();

            Cloudder::upload($image, null);

            $image_url = Cloudder::show(Cloudder::getPublicId());
        }

        $product = new Products([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'price' => $request->price,
            'image_url' => $image_url
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
        $product = Products::findOrFail($id);
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
        $product = Products::findOrFail($id);
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
        $this->validate($request,[
            'product_name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'nullable|string'
        ]);

        if($request->hasFile('image')){
            $image = $request->file('image')->getRealPath();

            Cloudder::upload($image, null);

            $image_url = Cloudder::show(Cloudder::getPublicId());
        }
        
        $products = Products::findOrFail($id);
        if($request->hasFile('image')){
            $url_id = $products->image_url;
            $url_arr = explode("/",$url_id);
            $url_last = count($url_arr)-1;
            $url_last_id = explode(".", $url_arr[$url_last]);
            $publicId = $url_last_id[0];
            Cloudder::destroyImage($publicId);
            $products->image_url = $image_url;
        }
        $product_all = $request->all();
        $products->fill($product_all)->update();
        return $products;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Products::findOrFail($id);
        $url_id = $products->image_url;
        $url_arr = explode("/",$url_id);
        $url_last = count($url_arr)-1;
        $url_last_id = explode(".", $url_arr[$url_last]);
        $publicId = $url_last_id[0];
        Cloudder::destroyImage($publicId);
        $products->delete();
        return $products;
        
    }

    
}
