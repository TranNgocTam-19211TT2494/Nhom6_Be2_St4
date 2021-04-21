@extends('layouts.master')
@section('product')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>{{$tukhoa}}</h2>
                    <div class="breadcrumb__option">
                        <a href="{{asset('blog')}}">Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->
<style>
    .blog__sidebar__recent__item__pic img {
        width: 90px;
    }

    .blog__details__text img {
        /* width: 100%; */
        width: 100%;
        height: 300px;
        object-fit: fill;
    }

    .blog__sidebar__recent {
        width: 300px;
    }

    .blog__sidebar__item a {
        text-decoration: none;
        color: black;
    }
</style>
<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                @include('partial.menu_blog')
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="row">
                    @foreach($blog as $item)
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="img/blog/{{$item->blog_thumbnail	}}" alt="">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i><?= date_format($item->created_at, "F j, Y, g:i a"); ?></li>
                                    <li><i class="fa fa-comment-o"></i> 5</li>
                                </ul>
                                <h5><a href="{{asset('blog_detail/')}}/{{$item->id}}">{{$item->blog_title}}</a></h5>
                                <a href="{{asset('blog_detail/')}}/{{$item->id}}" class="blog__btn">READ MORE&rarr; </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-lg-12">
                        {{$blog->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->
@endsection