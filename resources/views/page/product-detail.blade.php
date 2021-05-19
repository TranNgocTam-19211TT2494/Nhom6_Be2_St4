@extends('layouts.master')
@section('content')
@php $photos = explode(',',$products->photo); @endphp

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{asset('/img/breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{$products->title}}</h2>
                    <div class="breadcrumb__option">
                        <a href="{{asset('/')}}">Home</a>
                        <a href="{{route('product.detail',$products->slug)}}">{{$products->title}}</a>
                        <span>{{$products->cat_info['title']}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb Section End -->
<!-- Product Details Section Begin -->
<section class="product-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product__details__pic">
                    <div class="product__details__pic__item">
                        <img class="product__details__pic__item--large" src="{{$photos[0]}}" alt="">
                    </div>
                    <!-- slide image -->
                    @if(count($photos) != 1)
                    <div class="product__details__pic__slider owl-carousel">
                        @if(count($photos) < 5 && count($photos)>=2 )
                            @foreach($photos as $photo)
                            <img data-imgbigurl="{{$photo}}" src="{{$photo}}" alt="{{$products->title}}">
                            @endforeach
                            @else
                            @for($i = 0 ; $i < 5;$i++) <img data-imgbigurl="{{$photos[$i]}}" src="{{$photos[$i]}}" alt="{{$products->title}}">
                                @endfor
                                @endif

                    </div>
                    @endif
                    <!-- end slide image -->
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product__details__text">
                    <h3>{{$products->title}}</h3>


                    <div class="rating">
                        <!-- Tính tổng rate trung bình  -->
                        @php

                        $numberRate =DB::table('product_reviews')->where('product_id',$products->id)->count();
                        $sumRating = DB::table('product_reviews')->where('product_id',$products->id)->sum('rate');

                        $itemAge = 0;
                        if($numberRate!=0){
                        $itemAge = round($sumRating / $numberRate, 2);
                        }

                        @endphp

                        @for($i = 1; $i <= 5; $i ++) <i class="fa fa-star {{ $i <= $itemAge ? 'active' : ''}}"></i>

                            @endfor

                            <!-- Kết thúc tính trung bình rate -->

                            <!-- Đếm số đánh giá của người dùng -->
                            @php
                            $rate=DB::table('product_reviews')->where('product_id',$products->id)->count();
                            @endphp
                            <span>({{$rate}}) reviews</span>
                            <!-- Kết thúc đánh giá của dùng -->

                    </div>
                    <div class="product__details__price">{{number_format($products->price)}} VNĐ</div>
                    <p>{!!$products->description!!}</p>
                    <!-- Add cart -->
                    <form action="{{route('cart.add',$products->slug)}}" method="get">
                        @csrf
                        <div class="product__details__quantity">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="text" value="1" name="quantity">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="primary-btn" style="border: none;">ADD TO CARD</button>

                    </form>
                    <!-- <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a> -->

                    <ul>
                        <li><b>Availability</b> <span>@if ($products->stock > 0)
                                In stock
                                @else
                                Out stock
                                @endif</span></li>
                        <li><b>Shipping</b> <span>Free shipping on orders <samp> over 50$ or 2kg</samp></span></li>
                        <li><b>Weight</b> <span>{{number_format($products->weight)}} gam</span></li>
                        <li><b>Share on</b>
                            <div class="share">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="product__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab" aria-selected="false">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Reviews<span>({{$rate}})</span></a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Summary</h6>
                                <p>{!!$products->summary!!}</p>

                            </div>
                        </div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="product__details__tab__desc">
                                <h6>Products Description</h6>
                                <p>{!!$products->description!!}</p>
                            </div>
                        </div>
                        <!-- Xử lý thông kê đánh giá -->
                        @php
                        //Gom nhóm xem tổng sao
                        $arrayDashaboard = App\Models\ProductReview::groupBy('rate')
                        ->where('product_id',$products->id)
                        ->select(DB::raw('count(rate) as total'),DB::raw('sum(rate) as sum'))
                        ->addSelect('rate')
                        ->get()->toArray();


                        $arrayRatings = [];
                        if(!empty($arrayDashaboard)) {
                        for($i = 1; $i <= 5 ; $i ++){ $arrayRatings[$i]=[ "total"=> 0,
                            "sum" => 0,
                            "rate" => 0
                            ];
                            foreach($arrayDashaboard as $item) {
                            if($item['rate'] == $i) {
                            $arrayRatings[$i] = $item;
                            continue;
                            }
                            }
                            }
                            }
                            @endphp
                            <!-- Xử lý bản thông kê -->
                            <!-- Tab Đánh giá -->
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <!-- Bảng thông kê đánh giá sản phẩm -->
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="product__details__tab__desc">
                                            @if($arrayRatings)
                                            <h6 style="margin-top: 20px;font-weight: bold;margin-bottom: 20px;">Đánh giá Sản Phẩm {{$products->title}}</h6>
                                            <div class="toprt">
                                                <div class="crt">
                                                    <div class="lcrt" data-gpa="{{$itemAge}}">
                                                        <b>{{$itemAge}}<i class="fa fa-star"></i></b>
                                                    </div>
                                                    @foreach($arrayRatings as $key => $arrayRating)
                                                    @php
                                                    $itemAge = 0;
                                                    $itemAge = round(($arrayRating['total'] / $numberRate) * 100,0);
                                                    @endphp
                                                    <div class="rcrt">
                                                        <div class="r">
                                                            <span class="t">
                                                                {{$key}} <i class="fa fa-star"></i>

                                                            </span>
                                                            <div class="bgb">
                                                                <div class="bgb-in" style="width: {{$itemAge}}%"></div>
                                                            </div>
                                                            <span class="c" data-buy="{{$itemAge}}"><strong>{{$arrayRating['total']}}</strong> đánh giá ({{$itemAge}}%) </span>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            @else
                                            <h6 style="margin-top: 20px;font-weight: bold;margin-bottom: 20px;">{{$products->title}} vẫn chưa có đánh giá nào!!</h6>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-2">

                                    </div>
                                </div>


                                <!-- End Rating reviews -->
                                <!-- Review -->
                                <div class="product__details__tab__desc">
                                    <h6>Chọn Đánh giá</h6>
                                    @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                    @endif
                                    <form class="form" method="post" action="{{route('rate.store')}}">
                                        @csrf
                                        <!-- {{ csrf_field() }} -->
                                        @if (Auth::check())
                                        <input type="hidden" name="user_id" value="{{ Auth::User()->id }}">
                                        @endif
                                        <div class="row">
                                            <div class="col-lg-12 col-12">
                                                <div class="rating_box">

                                                    <div class="star-rating">
                                                        @php
                                                        $listRatingStart = [
                                                        1 => 'Không thích',
                                                        2 => 'Tạm được',
                                                        3 => 'Bình thường',
                                                        4 => 'Rất tốt',
                                                        5 => 'Tuyệt vời',
                                                        ];
                                                        @endphp
                                                        <div class="form-group wrapper">
                                                            <input type="checkbox" name="rate" id="st1" value="1" />
                                                            <label for="st1"></label>
                                                        </div>

                                                        <div class="form-group wrapper">
                                                            <input type="checkbox" name="rate" id="st2" value="2" />
                                                            <label for="st2"></label>

                                                        </div>
                                                        <div class="form-group wrapper">
                                                            <input type="checkbox" name="rate" id="st3" value="3" />
                                                            <label for="st3"></label>

                                                        </div>
                                                        <div class="form-group wrapper">
                                                            <input type="checkbox" name="rate" id="st4" value="4" />
                                                            <label for="st4"></label>

                                                        </div>
                                                        <div class="form-group wrapper">
                                                            <input type="checkbox" name="rate" id="st5" value="5" />
                                                            <label for="st5"></label>

                                                        </div>

                                                        @error('rate')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror

                                                    </div>


                                                    <!-- Rating view -->
                                                    <span class="list_text_rating">Tốt</span>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" name="product_id" class="form-control" value="{{ $products->id }}">
                                            </div>
                                            <div class="col-lg-12 col-12">
                                                <div class="form-group">
                                                    <label>Write a review</label>
                                                    <textarea name="review" rows="6" style="width: 100%;"></textarea>
                                                </div>
                                            </div>
                                            @if(Auth::check())
                                            <div class="col-lg-12 col-12">
                                                <div class="form-group button5">
                                                    <button type="submit" class="site-btn">Submit</button>
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-lg-12 col-12">
                                                <div class="form-group button5">
                                                    <button type="submit" disabled class="site-btn" style="opacity: .5;">Submit</button>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </form>

                                    <!-- Comment list -->

                                    @foreach($product_reviews as $review)
                                    @if($review->product_id == $products->id)
                                    <div class="row">
                                        <div class="col-md-12 comment">
                                            <div class="media g-mb-30">
                                                <img class="d-flex rounded-circle g-mt-3 g-mr-15" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Image Description">

                                                <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                                                    <div class="g-mb-15">
                                                        <h5 class="h5 g-color-gray-dark-v1 mb-0">
                                                            {{$review->user_info['name']}}
                                                        </h5>

                                                        <span class="g-color-gray-dark-v4 g-font-size-12">
                                                            @if($review->rate <= 0) <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                @elseif($review->rate === 1)
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                @elseif($review->rate === 2)
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                @elseif($review->rate === 3)
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                @elseif($review->rate === 4)
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                                @elseif($review->rate >= 5)
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                @endif
                                                        </span>
                                                    </div>
                                                    <p>{{$review->review}}</p>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                    <!-- End Comment List -->
                                    @endif
                                    @endforeach


                                </div>
                                <!-- End Review -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<!-- Product Details Section End -->
<!-- Related Product Section Begin -->
<section class="related-product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related__product__title">
                    <h2>Related Product</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @if($products!=null)
            @foreach($products->rel_prods as $product)
            @php $photos = explode(',',$product->photo); @endphp
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{$photos[0]}}">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="{{route('product.detail',$product->slug)}}">{{$product->title}}</a></h6>
                        <h5>{{number_format($product->price)}}đ</h5>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product__item">
                    <div class="product__item__pic set-bg" data-setbg="{{asset('img/product/product-1.jpg')}}">
                        <ul class="product__item__pic__hover">
                            <li><a href="#"><i class="fa fa-heart"></i></a></li>
                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="product__item__text">
                        <h6><a href="#">Crab Pool Security</a></h6>
                        <h5>$30.00</h5>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
<!-- Related Product Section End -->
@endsection
<!-- Javascript -->
@push('scripts')
<script>
    $(function() {
        let listStart = $(".wrapper input");

        listRatingStart = {
            1: 'Không thích',
            2: 'Tạm được',
            3: 'Bình thường',
            4: 'Rất tốt',
            5: 'Tuyệt vời',
        };
        listStart.change(function() {
            let $this = $(this);

            let number = $this.attr('value');
            listStart.removeClass('rating_active');

            $.each(listStart, function(key, value) {

                if (key + 1 <= number) {
                    $(this).addClass('rating_active')
                }
            });
            $(".list_text_rating").text('').text(listRatingStart[number]);


        });
    });
</script>
@endpush

@push('styles')
<style>
    /* Bảng thông kê đánh giá */
    .list_text_rating {
        display: inline-block;
        margin-left: 10px;
        margin-bottom: 10px;
        position: relative;
        background: #52b858;
        color: #fff;
        padding: 20px 10px;
        box-sizing: border-box;
        font-size: 12px;
        border-radius: 2px;

    }

    .list_text_rating::after {
        right: 100%;
        top: 50%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-color: rgba(82, 184, 88, 0);
        border-right-color: #52b858;
        border-width: 6px;
        margin-top: -10px;
    }

    .toprt {
        border: solid 1px #ddd;
        border-radius: 5px;
        padding: 5px 15px;
        margin-bottom: 20px;
    }

    .crt {
        height: 120px;
        box-sizing: border-box;
        overflow: overlay;
    }

    .crt .lcrt {
        width: 17%;
        float: left;
        border-right: solid 1px #eee;
        padding-top: 31px;
        height: 90%;
        text-align: center;
        box-sizing: border-box;
        margin: 5px 10px 5px 5px;
    }

    .crt .lcrt b {
        font-size: 40px;
        color: #fd9727;
        line-height: 40px;
    }

    .crt .lcrt b i {
        height: 32px;
        background-size: 32px 32px;
    }

    .crt .rcrt {
        font-size: 13px;
        overflow: hidden;
        box-sizing: border-box;
        padding: 1px 0;
        width: 75%;
        float: left;
        border-right: solid 1px #eee;
    }

    .crt .rcrt .r {
        padding: 1px 20px;
    }

    .crt .rcrt span.t {
        display: inline-block;
        color: #333;
    }

    .crt .rcrt .bgb {
        width: 55%;
        background-color: #e9e9e9;
        height: 5px;
        display: inline-block;
        margin: 0 10px;
        border-radius: 5px;
    }

    .crt .rcrt .bgb .bgb-in {
        background-color: #f25800;
        background-image: linear-gradient(90deg, #ff7d26 0%, #f25800 97%);
        height: 5px;
        border-radius: 5px 0 0 5px;
        max-width: 100%;
    }

    .crt .rcrt span.c {
        display: inline-block;
        color: #288ad6;
        cursor: pointer;
        font: message-box;
    }

    /* reviews */
    .comment {
        margin-top: 20px;
        background-color: #EFF7F9;
    }

    /* tổng rate */
    .rating .active {
        color: #FFC107 !important;
    }

    .comment img {
        height: 60px;
        width: 60px;
        margin-right: 20px;
    }

    /* Rating */
    .rating_box {
        display: inline-flex;
    }

    .star-rating {
        font-size: 0;
        padding-right: 10px;
    }

    .wrapper {
        display: inline-block;
        border: none;
        font-size: 14px;
    }

    /* .wrapper .rating_active {
    color: yellow!important;
} */
    .wrapper input {
        border: 0;
        width: 1px;
        height: 1px;
        clip: rect(1px 1px 1px 1px);
        clip: rect(1px, 1px, 1px, 1px);
        opacity: 0;
    }

    .wrapper label {
        position: relative;
        float: right;
        color: #C8C8C8;
    }

    .wrapper label:before {
        margin: 5px;
        content: "\f005";
        font-family: FontAwesome;
        display: inline-block;
        font-size: 1.5em;
        color: #ccc;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    .wrapper input:checked~label:before {
        color: #FFC107;
    }

    .wrapper label:hover~label:before {
        color: #ffdb70;
    }

    .wrapper label:hover:before {
        color: #FFC107;
    }

    .g-color-gray-dark-v4 {
        color: #FFC107;
    }
</style>
@endpush