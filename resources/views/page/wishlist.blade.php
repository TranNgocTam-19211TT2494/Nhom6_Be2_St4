@extends('layouts.master')
@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>You Have {{count($products)}} Product In Wishlists
                        <?php if (isset($msg)) {
                            echo $msg;
                        } ?>
                    </h2>
                    <div class="breadcrumb__option">
                        <a href="{{url('/')}}">Home</a>
                        <span>Wishlists</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="col-lg-9 col-md-7">
            <div class="row">
                @foreach($products as $product)
                @php $photo = explode(',',$product->photo); @endphp
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{$photo[0]}}">
                            <ul class="product__item__pic__hover">
                                <ul class="product__item__pic__hover">
                                    <!-- <li><a href="{{url('Wishlist')}}"><i class="fa fa-heart"></i></a></li> -->
                                    <li><a href="{{route('cart.add',$product->slug)}}"><i class="fa fa-shopping-cart"></i></a></li>
                                    <li><a href="{{route('wishlist.remove',$product->id)}}" style="color: red;"><i class="fa fa-minus-square"></i></a></li>
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

        </div>
    </div>
</section>
<!-- Product Section End -->
@endsection