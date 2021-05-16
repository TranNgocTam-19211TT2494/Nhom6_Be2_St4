@extends('layouts.master')
@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Shopping Cart</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shoping Cart Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{route('cart.update')}}" method="POST">
                                @csrf
                                <!-- Start cart items -->
                                @isset($cart)
                                @if ($cart->isNotEmpty())
                                @foreach ($cart as $item)
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="@php
                $image=explode(',',$item->product['photo']);
                echo $image[0];
                @endphp" alt="{{$item->title}}" width="100px" height="100px">
                                        <h5>{{$item->product['title']}}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        {{number_format($item->price)}}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" name="quantity[]" value="{{$item->quantity}}">
                                            </div>
                                        </div>
                                        <input type="hidden" name="cartId[]" value="{{$item->id}}">
                                    </td>

                                    <td class="shoping__cart__total">
                                        {{number_format($item->amount)}}
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <a href="{{route('cart.delete',$item->id)}}"><span class="icon_close"></span></a>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td class="shoping__cart__item text-center">
                                        There are no any carts available. <a href="" style="color:blue;">Continue shopping</a>

                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endif
                                @endisset

                                <!-- End cart items -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="{{route('index')}}" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    <button type="submit" class="primary-btn cart-btn cart-btn-right" style="border:none;"><span class="icon_loading"></span>
                        Upadate Cart</button>
                </div>
                </form>
            </div>
            <div class="col-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>Discount Codes</h5>
                        <form action="{{route('coupon.apply')}}" method="post">
                            @csrf
                            <input type="text" name="code" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">APPLY COUPON</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <li>Subtotal <span>@isset($cart)
                                {{number_format($cart->sum('amount'))}}
                                @endisset</span></li>
                        @if(session()->has('coupon'))
                        <li>Coupon <span>{{number_format(Session::get('coupon')['value'])}}</span></li>
                        <li>Total <span>{{number_format(($cart->sum('amount'))-(Session::get('coupon')['value']))}}</span></li>
                        @else
                        <li>Total <span>{{number_format($cart->sum('amount'))}}</span></li>
                        @endif

                    </ul>
                    <a href="{{route('checkout')}}" class="primary-btn">PROCEED TO CHECKOUT</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->
@endsection