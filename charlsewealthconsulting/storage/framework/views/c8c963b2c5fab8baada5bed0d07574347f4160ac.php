<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <form method="POST" action="<?php echo e(route('pay')); ?>" accept-charset="UTF-8" class="form-horizontal" role="form">
            <div class="row" style="margin-bottom:40px;">
              <div class="col-md-8 col-md-offset-2">
                <p>
                    <div>
                        Lagos Eyo Print Tee Shirt
                        ₦ 2,950
                    </div>
                </p>
                <input type="hidden" name="email" value="otemuyiwa@gmail.com"> 
                <input type="hidden" name="orderID" value="345">
                <input type="hidden" name="amount" value="800"> 
                <input type="hidden" name="quantity" value="3">
                <input type="hidden" name="metadata" value="<?php echo e(json_encode($array = ['key_name' => 'value',])); ?>" > 
                <input type="hidden" name="reference" value="<?php echo e(Paystack::genTranxRef()); ?>"> 
                <input type="hidden" name="key" value="<?php echo e(config('paystack.secretKey')); ?>"> 
                <?php echo e(csrf_field()); ?> 
    
                
    
    
                <p>
                  <button class="btn btn-success btn-lg btn-block" type="submit" value="Pay Now!">
                  <i class="fa fa-plus-circle fa-lg"></i> Pay Now!
                  </button>
                </p>
              </div>
            </div>
    </form>
    </body>
</html>

<?php /* C:\xampp\htdocs\charlsewealth\charlsewealthconsulting\charlsewealthconsulting\resources\views/welcome.blade.php */ ?>