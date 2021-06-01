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
                                        if(Auth::user())
                                        {
                                        $count = App\Models\Wishlist::where(['product_id' =>
                                        $product->id,'user_id'=>Auth::user()->id])->count();
                                        }
                                        @endphp
                                        @if($count == "0")
                                        <li>
                                            <a href="{{route('wishlist.add',$product->id)}}"> <i class="fa fa-heart"></i></a>
                                        </li>
                                        @else
                                        <li><a href="{{route('wishlist.remove',$product->id)}}" style="border: 1px solid red;"><i class="fa fa-heart" style="color: red;"></i></a></li>
                                        @endif
                                        <li><a href="{{route('cart.add',$product->slug)}}"><i class="fa fa-shopping-cart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product__discount__item__text">
                                    <h5><a href="{{route('product.detail',$product->slug)}}">{{$product->title}}</a>
                                    </h5>
                                    <div class="product__item__price">
                                        @php
                                        $sale = round((100 - $product->discount)/100,1);
                                        $after_discount=round(($product->price * $sale));
                                        @endphp
                                        {{number_format($after_discount)}}đ<span>{{number_format($product->price)}}đ</span>
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
                            <form>
                                <span>Sort By</span>
                                @csrf
                                <select name="sort" id="sort">
                                    <option value="{{Request::url()}}?sort_by=all" selected>
                                        Default
                                    </option>
                                    <option value="{{Request::url()}}?sort_by=all" data-anh=".all">
                                        All
                                    </option>
                                    <option value="{{Request::url()}}?sort_by=hot" data-anh=".hot">
                                        Hot
                                    </option>
                                    <option value="{{Request::url()}}?sort_by=new" data-anh=".new">
                                        New
                                    </option>
                                </select>
                            </form>

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
            <!-- Phần sortBy lỗi bootstrap ngay select : display: none; nên không thể chọn  -->
            <!-- Bỏ thêm class content vào row -->
            <div class="row" id="updateDiv">

                @foreach($array as $product)
                @php $photo = explode(',',$product->photo); @endphp
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="{{$photo[0]}}">
                            <ul class="product__item__pic__hover">
                                @php
                                $count=0;
                                if(Auth::user())
                                {
                                $count = App\Models\Wishlist::where(['product_id' =>
                                $product->id,'user_id'=>Auth::user()->id])->count();
                                }
                                @endphp
                                @if($count == "0")
                                <li>
                                    <a href="{{route('wishlist.add',$product->id)}}"> <i class="fa fa-heart"></i></a>
                                </li>
                                @else
                                <li><a href="{{route('wishlist.remove',$product->id)}}" style="border: 1px solid red;"><i class="fa fa-heart" style="color: red;"></i></a></li>
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
@push('scripts')
<!-- <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script> -->
<!-- or -->
<!-- <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script> -->
<!-- Isotope -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script>
    $('.nice-select').remove();
    $('#sort').removeAttr('style');

    $(document).ready(function() {
        $('#sort').on('change', function() {
            var url = $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        })
    })
</script>
@endpush
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