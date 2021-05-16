@extends('layouts.master')
@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{asset('img/breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Login</h2>
                    <div class="breadcrumb__option">
                        <a href="{{url('/')}}">Home</a>
                        <span>User login</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Contact Form Begin -->
<div class="contact-form spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="contact__form__title">
                    <h2>User login</h2>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <p>Please register in order to checkout more quickly</p>
                        <!-- Form -->
                        <form class="form" method="post" action="{{route('user.login.submit')}}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Your Email<span>*</span></label>
                                        <input type="email" name="email" placeholder="Input your email" required="required" value="{{old('email')}}">                        
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Your Password<span>*</span></label>
                                        <input type="password" name="password" placeholder="Input" required="required" value="{{old('password')}}">
                                    </div>
                                </div>
                                @isset($message)
                                <span class="text-danger">{{$message->content}}</span>
                                @endisset
                                @if (session('error'))
                                <span class="text-danger">{{session('error')}}</span>
                                @endif
                                <div class="col-12">
                                    <div class="form-group">
                                        <button class="btn site-btn" type="submit">Login</button>
                                        <button class="btn site-btn" formaction="">Register</button>
                                        OR @if (Route::has('password.request'))
                                            <a class="lost" href="{{ route('password.request') }}">
                                                Lost your password?
                                            </a>
                                            @endif


                                    </div>
                                    <div class="checkout__input__checkbox">
                                        <label for="lost-pass">
                                            Remember me!
                                            <input type="checkbox" id="lost-pass">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Contact Form End -->
@endsection