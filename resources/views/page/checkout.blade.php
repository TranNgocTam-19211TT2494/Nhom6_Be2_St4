@extends('layouts.master')
@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Checkout</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#" onclick="inputCoupon()">Click here</a> to enter your code
                </h6>
                <div id="coupon">
                    <form class="checkout__input" action="{{route('coupon.apply')}}" method="post">
                        @csrf
                        <input type="text" name="coupon">
                        <button type="submit" class="site-btn">Apply</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="{{route('order.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Fist Name<span>*</span></p>
                                    <input type="text" name="first_name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Last Name<span>*</span></p>
                                    <input type="text" name="last_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Country<span>*</span></p>
                            <input type="text" name="country" required>
                        </div>
                        <div class="checkout__input">
                            <p>Address<span>*</span></p>
                            <input type="text" placeholder="Street Address" class="checkout__input__add" name="address" required>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span>*</span></p>
                                    <input type="text" name="phone" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="text" name="email" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul>
                                @isset($cart)
                                @php
                                $shippingFee=0;
                                $weightSum=0;
                                @endphp
                                @if ($cart->isNotEmpty())
                                @foreach ($cart as $item)
                                <li>{{$item->product->title}} <span>{{number_format($item->amount)}}</span></li>
                                @php
                                $weightSum += $item->product->weight;
                                @endphp
                                @endforeach
                                @endif
                                @endisset
                            </ul>
                            <div class="checkout__order__subtotal">Subtotal <span>{{number_format($cart->sum('amount'))}}</span></div>
                            <input type="hidden" name="sub_total" value="{{$cart->sum('amount')}}">
                            @php
                            if($weightSum >= 2000 || $cart->sum('amount') >= 1000000)
                            {
                            $shippingFee = 0;
                            }else{
                            $shippingFee = 25000;
                            }
                            @endphp
                            <div class="checkout__order__total">Shipping Fee <span>{{$shippingFee}}</span></div>
                            <input type="hidden" name="shipping" value="{{$shippingFee}}">
                            @if(session()->has('coupon'))
                            <div class="checkout__order__total">Copoun <span>{{number_format(Session::get('coupon')['value'])}}</span></div>
                            <input type="hidden" name="coupon" value="{{Session::get('coupon')['value']}}">
                            <div class="checkout__order__total">Total <span>{{number_format(($cart->sum('amount'))-(Session::get('coupon')['value'])+$shippingFee)}}</span></div>
                            <input type="hidden" name="total" value="{{($cart->sum('amount')-(Session::get('coupon')['value'])+$shippingFee)}}">
                            @else
                            <div class="checkout__order__total">Total <span>{{number_format($cart->sum('amount')+$shippingFee)}}</span></div>
                            <input type="hidden" name="total" value="{{$cart->sum('amount')+$shippingFee}}">
                            @endif
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="checkbox" id="paypal" name="payment_method" value="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <input type="hidden" name="quantity" value="{{$cart->sum('quantity')}}">
                            <button type="submit" class="site-btn">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->
@endsection
@push('scripts')
<script>
    var x = document.getElementById("coupon");
    x.style.display = "none";

    function inputCoupon() {

        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
    };
</script>
@endpush