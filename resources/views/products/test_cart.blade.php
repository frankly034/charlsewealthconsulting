<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@if(Session::has('cart'))    
<h4>total Price:₦ {{$totalPrice}}</h4>
@foreach ($product as $products)
<div>
<h4>product name: {{$products['item']['product_name']}}</h4>
<h4>product Quantity: {{$products['qty']}}</h4>
<h4>product price: {{$products['price']}}</h4>

</div>
@endforeach



<form method="POST" action="{{ route('pay') }}" accept-charset="UTF-8" class="form-horizontal" role="form">
    <div class="row" style="margin-bottom:40px;">
      <div class="col-md-8 col-md-offset-2">
        <p>
            <div>
                @foreach ($product as $item)
                {{$item['item']['product_name']}}, {{" "}}
                @endforeach
                ₦ {{$totalPrice}}
            </div>
        </p>
        <input type="email" name="email" value="" placeholder="please enter your email"> {{-- required --}}
    <input type="hidden" name="amount" value="{{$totalPrice * 100}}"> {{-- required in kobo --}}
    <input type="hidden" name="quantity" value="{{$totalQty}}">
    <input type="text" name="country" placeholder="please enter your country of residence">
    <input type="text" name="state" placeholder="State">
    <input type="text" name="address" placeholder="please enter the delivery address for your purchase">
    <input type="text" name="fullName" placeholder="please enter your full name">
        <input type="hidden" name="" value="{{ json_encode($array = ['key_name' => 'value',]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
        <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
        <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}"> {{-- required --}}
        {{ csrf_field() }} {{-- works only when using laravel 5.1, 5.2 --}}

    


        <p>
          <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
          <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
          </button>
        </p>
      </div>
    </div>
</form>
@endif
</body>
</html>