@extends('layouts.master')
@section('content')

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                @include('partial.product_sidebar')
            </div>
        </div>

        <div class="col-lg-9 col-md-7">
            <div class="product__discount">
                <div class="section-title product__discount__title">
                    <h2>Sale Off</h2>
                </div>
                <div class="row">
                    <div class="product__discount__slider owl-carousel">
                        @foreach($products as $product)
                        @if ($product->discount > 0)
                        @php $photo = explode(',',$product->photo); @endphp
                        <div class="col-lg-4">
                            <div class="product__discount__item">
                                <div class="product__discount__item__pic set-bg" data-setbg="{{$photo[0]}}">
                                    <div class="product__discount__percent">{{number_format($product->discount)}}%
                                    </div>
                                    <ul class="product__item__pic__hover">
                                        @php
                                        $count=0;
                                        @endphp
                                        @if(Auth::user())
                                        $count = App\Models\Wishlist::where(['product_id' =>
                                        $product->id,'user_id'=>Auth::user()->id])->count();
                                        @endif
                                        @if($count == "0")
                                        <li>
                                            <a href="{{route('wishlist.add',$product->id)}}"> <i class="fa fa-heart"></i></a>
                                        </li>
                                        @else
                                        <li><a href="{{route('wishlist.remove',$product->id)}}" style="background: red;"><i class="fa fa-heart"></i></a></li>
                                        @endif
                                        <li><a href="{{route('cart.add',$product->slug)}}"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__discount__item__text">
                                    <h5><a href="{{route('product.detail',$product->slug)}}">{{$product->title}}</a>
                                    </h5>
                                    <div class="product__item__price">
                                        @php
                                        $after_discount=($product->price-($product->price*$product->discount)/100);
                                        @endphp
                                        {{number_format($product->price)}}đ<span>{{number_format($after_discount)}}đ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="filter__item">
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="filter__sort">
                            <span>Sort By</span>

                            <select name="select" id="cdb">
                                <option value="0">Default</option>
                                <option value="1">Hot</option>
                                <option value="2">New</option>
                            </select>

                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        @php
                        $countProduct=DB::table('products')->count();
                        @endphp
                        <div class="filter__found">
                            <h6><span>{{$countProduct}}</span>Products found</h6>
                        </div>


                    </div>
                    <div class="col-lg-4 col-md-3">
                        <div class="filter__option">
                            <span class="icon_grid-2x2"></span>
                            <span class="icon_ul"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($products as $product)
                @php $photo = explode(',',$product->photo); @endphp
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{$photo[0]}}">
                            <ul class="product__item__pic__hover">
                                @php
                                $count=0;
                                @endphp
                                @if(Auth::user())
                                $count = App\Models\Wishlist::where(['product_id' =>
                                $product->id,'user_id'=>Auth::user()->id])->count();
                                @endif


                                @if($count == 0)
                                <li>
                                    <a href="{{route('wishlist.add',$product->id)}}"> <i class="fa fa-heart"></i></a>
                                </li>
                                @else
                                <li><a href="{{route('wishlist.remove',$product->id)}}" style="background: red;"><i class="fa fa-heart"></i></a></li>
                                @endif
                                <li><a href="{{route('cart.add',$product->slug)}}"><i class="fa fa-shopping-cart"></i></a></li>
                            </ul>

                        </div>
                        <div class="product__item__text">
                            <h6><a href="{{route('product.detail',$product->slug)}}">{{$product->title}}</a>
                            </h6>
                            <h5>{{number_format($product->price)}}đ</h5>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <div class="col-md-12">
                {{$products->links()}}
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection
@push('styles')
<style>
    button {
        display: contents;
    }

    .product__item__pic__hover form {
        list-style: none;
        display: inline-block;
        margin-right: 6px;
    }
</style>
@endpush