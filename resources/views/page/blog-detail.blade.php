@extends('layouts.master')
@section('content')
<!-- Blog Details Hero Begin -->
<section class="blog-details-hero set-bg" data-setbg="{{asset('/img/blog/details/details-hero.jpg')}}" id="hero">
    @php $countPost=DB::table('post_comments')->where('post_id',$post->id)->get(); @endphp
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="blog__details__hero__text">
                    <h2>{{$post->title}}</h2>
                    <ul>
                        <li>By {{$post->author_info['name']}}</li>
                        <li>{{$post->created_at->format('F d, Y')}}</li>
                        @if(isset($countPost))
                        <li>{{count($countPost)}} Comments</li>
                        @endif
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
                    <img src="{{$post->photo}}" alt="">
                    <p>{!!$post->description !!}</p>
                </div>
                <h3>Comment</h3>
                <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
                <section class="content-item" id="comments">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8">
                                <form action="{{route('comment.store')}}" method="post">
                                    @csrf
                                    <h3 class="pull-left">New Comment</h3>
                                    <!-- kiểm tra đăng nhập thành công mới cho commet -->
                                    @if(Auth::check())
                                    <button type="submit" class="btn btn-primary btncss">Submit</button>
                                    @else
                                    <button type="submit" class="btn btn-primary btncss" disabled>Submit</button>
                                    @endif

                                    <fieldset>
                                        <div class="row">
                                            <div class="col-sm-3 col-lg-2 hidden-xs">
                                                <img class="img-responsive" src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                            </div>
                                            <div class="form-group col-xs-12 col-sm-9 col-lg-10">
                                                <input type="text" style="display: none;" name="post_id" value="{{$post->id}}" id="">
                                                <textarea class="form-control" id="message" placeholder="Your message" name="comment" required=""></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                                <!-- dem so luong bai theo post_id -->
                                @if(isset($countPost))
                                <h3>{{count($countPost)}} Comments</h3>
                                @endif

                                @if(isset($comment))
                                @foreach($comment as $item)
                                @if($item->post_id == $post->id)
                                <!-- COMMENT 1 - START -->
                                <div class="media">

                                    @php $name=DB::table('users')->select('name')->where('id',$item->user_id)->get();
                                    @endphp
                                    @php $email=DB::table('users')->select('photo')->where('id',$item->user_id)->get();
                                    @endphp
                                    @if(isset($email) && isset($name))
                                    @foreach($email as $data)
                                    <a class="pull-left" href="#"><img class="media-object" src="{{ $data->photo }}" style="height: 50px; width: 50px; border-radius: 50%;" alt=""></a>


                                    @endforeach
                                    <div class="media-body">
                                        <h4 class="media-heading">@foreach($name as $data){{ $data->name}}
                                            @endforeach &emsp;&emsp;
                                            <!-- Xóa comment -->
                                            @if(isset(Auth::user()->role))
                                            @if(Auth::user()->role === "admin" || Auth::user()->id === $item->user_id || Auth::user()->role === "writter")
                                            <form method="POST" action="{{route('comment.destroy',[$item->id])}}">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$item->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                            @endif
                                            @endif
                                        </h4>
                                        <p class="comment">{!!$item->comment!!}</p>
                                        <span style="font-weight: bold;">Reply:
                                        </span><span>{{$item->replied_comment}}</span>
                                        @if(isset(Auth::user()->role))
                                        @if(Auth::user()->role === "admin" || Auth::user()->role === "writter")
                                        <form method="POST" action="{{route('comment.destroy',[$item->id])}}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn " data-id={{$item->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                        @endif
                                        @endif
                                        <p class="reply"></p>
                                        <ul class="list-unstyled list-inline media-detail pull-left">
                                            <li><i class="fa fa-calendar"></i>{{$item->created_at}}</li>
                                        </ul>

                                    </div>
                                    @endif
                                </div>
                                @if(Auth::check())
                                <!-- cập nhập comment -->
                                @if(Auth::user()->role === "admin" || Auth::user()->role === "writter")
                                <form action="{{route('comment.update',$item->id)}}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <input id="inputTitle" type="text" name="reply" placeholder="Reply Comment" value="{{old('title')}}" class="form-control">
                                            </div>

                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <button type="submit" class="btn btn-success replycss">Reply</button>
                                            </div>

                                        </div>

                                    </div>
                                </form>
                                @endif
                                <!-- COMMENT 1 - END -->
                                @endif
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </section>
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
                                    <li><span>Tags: {{$post->tags}}

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
                        <p>{{$item->summary}}</p>
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

@push('styles')
<style>
    .blog__details__text img {
        /* width: 100%; */
        width: 100%;
        height: 300px;
        object-fit: fill;
    }

    .blog__sidebar__item a {
        text-decoration: none;
        color: black;
    }

    .set-bg {
        background-image: url("../img/blog/details/details-hero.jpg");
    }

    .content-item {
        padding: 30px 0;
        background-color: #FFFFFF;
    }

    .content-item.grey {
        background-color: #F0F0F0;
        padding: 50px 0;
        height: 100%;
    }

    .content-item h2 {
        font-weight: 700;
        font-size: 35px;
        line-height: 45px;
        text-transform: uppercase;
        margin: 20px 0;
    }

    #comments .btncss {
        position: absolute;
        /* margin-left: 264px; */
        margin-top: 43px;
        /* margin-right: -26px; */
        top: 40px;
        right: -67px;
    }

    .content-item h3 {
        font-weight: 400;
        font-size: 20px;
        color: #555555;
        margin: 10px 0 15px;
        padding: 0;
    }

    .content-headline {
        height: 1px;
        text-align: center;
        margin: 20px 0 70px;
    }

    .content-headline h2 {
        background-color: #FFFFFF;
        display: inline-block;
        margin: -20px auto 0;
        padding: 0 20px;
    }

    .grey .content-headline h2 {
        background-color: #F0F0F0;
    }

    .content-headline h3 {
        font-size: 14px;
        color: #AAAAAA;
        display: block;
    }


    #comments {
        box-shadow: 0 -1px 6px 1px rgba(0, 0, 0, 0.1);
        background-color: #FFFFFF;
    }

    #comments form {
        margin-bottom: 30px;
    }

    #comments .btn {
        margin-top: 7px;
    }

    #comments form fieldset {
        clear: both;
    }

    #comments form textarea {
        height: 100px;
    }

    #comments .media {
        border-top: 1px dashed #DDDDDD;
        padding: 20px 0;
        margin: 0;
        position: relative;
    }

    #comments .media>.pull-left {
        margin-right: 20px;
    }

    #comments .media img {
        max-width: 100px;
    }

    #comments .media h4 {
        margin: 0 0 10px;
    }

    #comments .media h4 span {
        font-size: 14px;
        float: right;
        color: #999999;
    }

    #comments .media p {
        margin-bottom: 15px;
        text-align: justify;
    }

    #comments .media-detail {
        margin: 0;
    }

    #comments .media-detail li {
        color: #AAAAAA;
        font-size: 12px;
        padding-right: 10px;
        font-weight: 600;
    }

    #comments .media-detail a:hover {
        text-decoration: underline;
    }

    #comments .media-detail li:last-child {
        padding-right: 0;
    }

    #comments .media-detail li i {
        color: #666666;
        font-size: 15px;
        margin-right: 10px;
    }

    .hover {
        color: black;
    }

    .hover:hover {
        color: black;
    }

    .btn.btn-success.replycss {
        position: absolute;
        top: -7px;
    }

    a.css-delete {
        color: black;
        text-decoration: none;
    }

    button.btn.btn-danger.btn-sm.dltBtn {
        position: absolute;
        top: 12px;
        right: 35%;
    }
</style>
@endpush