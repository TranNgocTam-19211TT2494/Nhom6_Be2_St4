<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
@include('layouts.notification')
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="{{route('index')}}"><img src="{{asset($site->logo)}}" alt="{{$site->title}}"></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            @isset(Auth::user()->id)
            @php
            $countWishlist = App\Models\Wishlist::where('user_id',Auth::user()->id)->count();
            @endphp
            <li><a href="{{route('wishlist')}}"><i class="fa fa-heart"></i> <span>{{$countWishlist}}</span></a></li>
            @else
            <li><a href="{{route('wishlist')}}"><i class="fa fa-heart"></i> <span>0</span></a></li>
            @endisset
            @isset(Auth::user()->id)
            <li><a href="{{route('cart')}}"><i class="fa fa-shopping-bag"></i> <span>@php
                        $cartItem=DB::table('carts')
                        ->where('order_id',null)->where('user_id',Auth::user()->id)->sum('quantity');
                        echo $cartItem;
                        @endphp</span></a></li>
            @else
            <li><a href="{{route('cart')}}"><i class="fa fa-shopping-bag"></i> <span>0</span></a></li>
            @endisset
        </ul>
        @isset(Auth::user()->id)
        <div class="header__cart__price">item: <span>@php
                $cartItem=DB::table('carts')
                ->where('order_id',null)->where('user_id',Auth::user()->id)->sum('amount');
                echo number_format($cartItem);
                @endphp</span></div>
        @else
        <div class="header__cart__price">item: <span>0.00</span></div>
        @endisset
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__language">
            <a href="{{route('user.profile')}}"><i class="fas fa-truck"></i>Tracking</a>
        </div>
        @if (Auth::user())
        @auth
        @if (Auth::user()->role=='admin')
        <div class="header__top__right__auth">
            <a href="{{route('user.profile')}}"><i class="fas fa-tasks"></i>DASHBOARD</a>
        </div>
        @else
        <div class="header__top__right__auth">
            <a href="{{route('admin')}}"><i class="fas fa-tasks"></i>ADMIN</a>
        </div>
        @endif
        @endauth


        <div class="header__top__right__auth">
            <a href="{{route('user.logout')}}"><i class="fas fa-sign-out-alt"></i>Logout</a>

        </div>
        @else
        <div class="header__top__right__auth">
            <a href="{{route('user.login')}}"> Login</a>
        </div>
        <i class="fas fa-people-arrows"></i>
        <div class="header__top__right__auth">
            <a href="{{route('user.register')}}"> Register</a>
        </div>
        @endif
    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="{{url('/')}}">Home</a></li>
            <li><a href="{{route('product.all')}}">Shop</a></li>
            <li><a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                    <li><a href="{{route('product.all')}}">Shop Details</a></li>
                    <li><a href="{{route('cart')}}">Shoping Cart</a></li>
                    <li><a href="{{route('checkout')}}">Check Out</a></li>
                    <li><a href="{{route('blog.all')}}">Blog Details</a></li>
                </ul>
            </li>
            <li><a href="{{route('blog.all')}}">Blog</a></li>
            <li><a href="{{route('contact')}}">Contact</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i> {{$site->email}}</li>
            <li>{{$site->message}}</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> {{$site->email}}</li>
                            <li>{{$site->message}}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                        </div>
                        <div class="header__top__right__language">
                            <a href="{{route('user.profile')}}" style="color: black;"><i class="fas fa-truck"></i> Tracking</a>
                        </div>
                        @if (Auth::user())
                        @auth
                        @if (Auth::user()->role=='user')
                        <div class="header__top__right__auth">
                            <a href="{{route('user.profile')}}"><i class="fas fa-tasks"></i>DASHBOARD</a>
                        </div>
                        @else
                        <div class="header__top__right__auth">
                            <a href="{{route('admin')}}"><i class="fas fa-tasks"></i>ADMIN</a>
                        </div>
                        @endif
                        @endauth
                        <div class="header__top__right__auth">
                            <a href="{{route('user.logout')}}"><i class="fas fa-sign-out-alt"></i>Logout</a>

                        </div>
                        @else
                        <div class="header__top__right__auth">
                            <a href="{{route('user.login')}}"> Login</a>
                        </div>
                        <i class="fas fa-people-arrows"></i>
                        <div class="header__top__right__auth">
                            <a href="{{route('user.register')}}"> Register</a>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="{{url('/')}}"><img src="{{asset($site->logo)}}" alt="{{$site->title}}"></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="active"><a href="{{route('index')}}">Home</a></li>
                        <li><a href="{{route('product.all')}}">Shop</a></li>
                        <li><a href="#">Pages</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="{{route('product.all')}}">Shop Details</a></li>
                                <li><a href="{{route('cart')}}">Shoping Cart</a></li>
                                <li><a href="{{route('checkout')}}">Check Out</a></li>
                                <li><a href="{{route('blog.all')}}">Blog Details</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('blog.all')}}">Blog</a></li>
                        <li><a href="{{route('contact')}}">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        @isset(Auth::user()->id)
                        @php
                        $countWishlist = App\Models\wishlist::where('user_id',Auth::user()->id)->count();
                        @endphp
                        <li><a href="{{route('wishlist')}}"><i class="fa fa-heart"></i> <span>{{$countWishlist}}</span></a></li>
                        @else
                        <li><a href="{{route('wishlist')}}"><i class="fa fa-heart"></i> <span>0</span></a></li>
                        @endisset
                        @isset(Auth::user()->id)
                        <li><a href="{{route('cart')}}"><i class="fa fa-shopping-bag"></i> <span>@php
                                    $cartItem=DB::table('carts')
                                    ->where('order_id',null)->where('user_id',Auth::user()->id)->sum('quantity');
                                    echo $cartItem;
                                    @endphp</span></a></li>
                        @else
                        <li><a href="{{route('cart')}}"><i class="fa fa-shopping-bag"></i> <span>0</span></a></li>
                        @endisset

                    </ul>
                    @isset(Auth::user()->id)
                    <div class="header__cart__price">item: <span>@php
                            $cartItem=DB::table('carts')
                            ->where('order_id',null)->where('user_id',Auth::user()->id)->sum('amount');
                            echo number_format($cartItem);
                            @endphp</span></div>
                    @else
                    <div class="header__cart__price">item: <span>0.00</span></div>
                    @endisset

                </div>
            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->
<!-- Hero Section Begin -->
<section class="hero hero-normal" id="hero_banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All departments</span>
                    </div>
                    <ul>
                        <!-- Đổ dữ liệu category ra header dùng querybuilder -->
                        @foreach (DB::table('categories')->get() as $category)
                        <li><a href="{{route('product.category',$category->id)}}">{{$category->title}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="{{route('product.search')}}" method="get">
                            <input type="text" placeholder="What do yo u need?" name="tukhoa">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>{{$site->phone}}</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
                @yield('banner')
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->