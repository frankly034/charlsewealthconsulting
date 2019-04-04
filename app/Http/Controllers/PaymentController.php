<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Paystack;
use Session;
use App\Transaction;
use App\Cart;

class PaymentController extends Controller
{

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
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
    public function handleGatewayCallback()
    {
     
        $paymentDetails = Paystack::getPaymentData();

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $order = new Transaction();
        dd(Session::all());

        //dd($paymentDetails);
        $order->reference_id = $paymentDetails['data']['reference'];
        $order->amount = $paymentDetails['data']['amount'];
        $order->state = $paymentDetails['data']['metadata']['state'];
        $order->address = $paymentDetails['data']['metadata']['address'];
        $order->fullName = $paymentDetails['data']['metadata']['fullName'];
        $order->email = $paymentDetails['data']['metadata']['email'];
        $order->paid_at = $paymentDetails['data']['paidAt'];
        $order->currency = $paymentDetails['data']['currency'];
        $order->cart = serialize($cart);
        $order->save();
        request()->session()->forget('cart');
        return $order;

        //return $paymentDetails;
        dd($paymentDetails['data']);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}

