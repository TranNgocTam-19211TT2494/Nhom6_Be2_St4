@extends('layouts.master')
@section('content')
<!-- Blog Details Hero Begin -->
<section class="blog-details-hero set-bg" data-setbg="{{asset('/img/blog/details/details-hero.jpg')}}" id="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="blog__details__hero__text">
                    <h2>{{$post->title}}</h2>
                    <ul>
                        <li>By {{$post->author_info['name']}}</li>
                        <li>{{$post->created_at->format('F d, Y')}}</li>
                        <li>8 Comments</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Hero End -->

<!-- Blog Details Section Begin -->
<section class="blog-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5 order-md-1 order-2">
                @include('partial.menu_blog')

            </div>
            <div class="col-lg-8 col-md-7 order-md-1 order-1">
                <div class="blog__details__text">
                    <p>{!!$post->description !!}</p>


                </div>
                <div class="blog__details__content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="blog__details__author">
                                <div class="blog__details__author__pic">
                                    <img src="{{$post->author_info['photo']}}" alt="">
                                </div>
                                <div class="blog__details__author__text">
                                    <h6>{{$post->author_info['name']}}</h6>
                                    <span>{{$post->author_info['role']}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div class="blog__details__widget">
                                <ul>
                                    <li><span>Categories: {{$post->cat_info['title']}}</span> </li>
                                    <li><span>Tags:

                                        </span></li>
                                </ul>
                                <div class="blog__details__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-google-plus"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                    <a href="#"><i class="fa fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Section End -->

<!-- Related Blog Section Begin -->
<section class="related-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related-blog-title">
                    <h2>Post You May Like</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($post_interest as $item)
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic">
                        <img src="{{$item->photo}}" alt="{{$item->title}}" height="350px" width="500px">
                    </div>
                    <div class="blog__item__text">
                        <ul>
                            <li><i class="fa fa-calendar-o"></i>{{$item->created_at->format('d-m-Y')}}</li>
                            <li><i class="fa fa-comment-o"></i> 5</li>
                        </ul>
                        <h5><a href="{{route('blog.detail',$item->slug)}}">{{$item->title}}</a></h5>
                        <p>{!!substr_replace($item->description,'...',100,-1)!!}</p>
                        <a href="{{route('blog.detail',$item->slug)}}" class="blog__btn">READ MORE&rarr; </a>
                    </div>
                </div>
            </div>
            @endforeach



        </div>
    </div>
</section>
<!-- Related Blog Section End -->
@endsection