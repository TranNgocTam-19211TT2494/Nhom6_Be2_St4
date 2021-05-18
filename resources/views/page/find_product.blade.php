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
            <div class="row" id="updateDiv">
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
    </div>
</section>
<!-- Product Section End -->

@endsection