@extends('layouts.master')
@section('content')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{asset('img/breadcrumb.jpg')}}" style="background-image: url('../img/breadcrumb.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Blog</h2>
                    <div class="breadcrumb__option">
                        <a href="{{route('index')}}">Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                @include('partial.menu_blog')
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="row">
                    @isset($posts)
                    @foreach($posts as $item)
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="{{$item->photo}}" alt="{{$item->title}}">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i> {{$item->created_at->format('d-m-Y')}}
                                    </li>
                                    <li><i class="fa fa-comment-o"></i> 5</li>
                                </ul>
                                <h5><a href="{{route('blog.detail',$item->slug)}}">{{$item->title}}</a></h5>
                                <p>{!!substr_replace($item->description,'...',100,-1)!!}</p>
                                <a href="{{route('blog.detail',$item->slug)}}" class="blog__btn">READ MORE&rarr; </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endisset
                    <div class="col-lg-12">
                        {{$posts->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->
@endsection
@push('styles')
<style>
    .blog__item__pic img {
        height: 350px;
        width: 500px;
    }
</style>
@endpush