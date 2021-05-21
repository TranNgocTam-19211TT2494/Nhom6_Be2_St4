<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\User;
use App\Models\Cart;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\ProductReview;
use App\Models\Banner;
use App\Models\UserActivation;
use App\Classes\ActivationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\PostComment;
use App\Models\Contact;


class PageController extends Controller
{
    //
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->get()->take(3);
        $latestProducts = Product::orderBy('id', 'DESC')->get()->take(6);
        $hotProducts = Product::where('condition', 'hot')->orderBy('id', 'DESC')->get()->take(6);
        $cate1 = Category::with('products')->where('id', 1)->first();
        $cate2 = Category::with('products')->where('id', 2)->first();
        $cate3 = Category::with('products')->where('id', 3)->first();
        $cate4 = Category::with('products')->where('id', 4)->first();
        $categories = Category::all();
        //banner
        $banner = Banner::where('status', 'active')->first();
        //banner inactive
        $bannerinactive = Banner::where('status', 'inactive')->take(2)->get();
        return view('trangchu')->with('cate1', $cate1)
            ->with('cate2', $cate2)
            ->with('cate3', $cate3)
            ->with('cate4', $cate4)
            ->with('latest', $latestProducts)
            ->with('hot', $hotProducts)
            ->with('posts', $posts)
            ->with('mainBanner', $banner)
            ->with('subBanner', $bannerinactive)
            ->with('categories', $categories);
    }
    //Trang login của user
    public function userLogin()
    {
        return view('partial.login');
    }
    //Xu ly du lieu login
    public function userLoginSubmit(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'active'])) {
            Session::put('user', $data['email']);
            request()->session()->flash('success', 'Successfully login');
            return redirect()->route('index');
        } else {
            request()->session()->flash('error', 'Invalid email and password pleas try again!');
            return redirect()->back();
        }
    }
    //Trang register
    public function userRegister()
    {
        return view('partial.register');
    }
    //Xu ly du lieu register
    //Xu ly du lieu register
    public function userRegisterSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required|min:2',
            'email' => 'string|required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
        $data = $request->all();
        // dd($data);
        $check = $this->create($data);
        Session::put('user', $data['email']);
        if ($check) {
            request()->session()->flash('success', 'Successfully registered');
            $userActivation = new UserActivation;
            $activation = new ActivationService($userActivation);
            $activation->sendActivationMail($check);
            return redirect()->route('index');
        } else {
            request()->session()->flash('error', 'Please try again!');
            return back();
        }
    }
    //Xu ly user logout
    public function userLogout()
    {
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success', 'Logout successfully');
        return back();
    }
    //Xu ly dang ky user
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active'
        ]);
    }
    //Trang gio hang
    public function cart()
    {
        $cart = Cart::with('product')->where('order_id', null)->where('user_id', Auth::user()->id)->orderBy('id', 'ASC')->paginate(15);
        // dd($cart);
        return view('page.cart')->with('cart', $cart);
    }
    //Trang check out
    public function checkout()
    {
        $cart = Cart::with('product')->where('order_id', null)->where('user_id', Auth::user()->id)->orderBy('id', 'ASC')->get();
        return view('page.checkout')->with('cart', $cart);
    }
    //Trang blog : 
    public function getBlog()
    {
        $random_post = Post::all()->random(3);
        $feature = Post::where('id', 1)->take(3)->get();
        $post_categories = PostCategory::all();
        $post = Post::orderBy('created_at', 'DESC')->paginate(6);
        return view('page.blog', ['posts' => $post, 'post_categories' => $post_categories, 'added_by' => $feature, 'random_post' => $random_post]);
    }
    //Blog category
    public function getBlogCategoryByID($id)
    {
        $feature = Post::where('id', 1)->take(3)->get();
        $post_categories = PostCategory::all();
        $posts = Post::orderBy('id', 'DESC')->paginate(6);
        return view('page.blog_category', ['posts' => $posts, 'post_categories' => $post_categories, 'post_cat_id' => $feature]);
    }
    //Blog hiển thị chi tiết
    public function getBlogDetailByID($slug)
    {
        $post_interest = Post::orderBy('id', 'ASC')->limit(3)->get();
        $random_post = Post::all()->random(3);
        $comment = PostComment::orderBy('created_at', 'DESC')->get();
        $post = Post::with('cat_info')->with('author_info')->with('tag_info')->where('slug', $slug)->first();
        $post_categories = PostCategory::all();
        return view('page.blog-detail', ['post' => $post, 'post_categories' => $post_categories, 'random_post' => $random_post, 'post_interest' => $post_interest, 'comment' => $comment]);
    }
    //Blog tìm kiếm
    public function blogSearch(Request $request)
    {
        //return dd($request->all());
        $tukhoa = $request->get('tukhoa');
        //cần có append để truyền từ khóa lên trang địa chỉ khi chọn vào trang 2->...
        $post = Post::where('title',  'LIKE', "%$tukhoa%")->orWhere('description', 'LIKE', "%$tukhoa%")->take(30)->paginate(4)->appends(['tukhoa' => $tukhoa]);
        //return view('pages.timkiem', compact('tintuc'));
        $post_categories = PostCategory::all();
        return view('page.find_blog', ['posts' => $post, 'tukhoa' => $tukhoa, 'post_categories' => $post_categories]);
    }
    //Trang Shop 
    //liệt kê sản phẩm
    public function getCategogyProductById($id)
    {
        $categories = Category::all();
        $products = Product::where('cat_id', $id)->paginate(6);
        return view('page.product_category', ['products' => $products, 'categories' => $categories]);
    }
    //Hiển thị sản phẩm
    public function ShowProduct()
    {
        $categories = Category::all();
        $products = Product::orderBy('id', 'DESC')->paginate(6);
        return view('page.product-list', ['products' => $products, 'categories' => $categories]);
    }
    //Chi tiết sản phẩm
    //Chi tiết sản phẩm
    public static function getProductBySlug($slug)
    {

        $products = Product::with('cat_info')->where('slug', $slug)->first();
        //Review : 
        $product_reviews = ProductReview::getAllReview();
        $categories = Category::all();
        return view('page.product-detail', ['products' => $products, 'product_reviews' => $product_reviews, 'categories' => $categories]);
    }
    //Trang user profile
    public function adminProfile()
    {
        $profile = Auth()->user();
        return view('backend.users.profile')->with('profile', $profile);
    }
    //Trang đổi password
    public function changePassword()
    {
        $profile = Auth()->user();
        return view('backend.layouts.changePassword')->with('profile', $profile);
    }
    //Trang đổi password cua user
    public function changeUserPassword()
    {
        $profile = Auth()->user();
        return view('user.layouts.userPasswordChange')->with('profile', $profile);
    }
    //Tìm kiếm sản phẩm
    public function productSearch(Request $request)
    {
        //return $request;
        $tukhoa = $request->get('tukhoa');
        //cần có append để truyền từ khóa lên trang địa chỉ khi chọn vào trang 2->...
        $products = Product::where('title', 'like', "%$tukhoa%")
            ->orWhere('description', 'like', "%$tukhoa%")->take(30)->paginate(4)->appends(['tukhoa' => $tukhoa]);
        $categories = Category::all();
        return view('page.find_product')
            ->with('products', $products)
            ->with('categories', $categories);
    }
    //Wishlist
    public function addWishList($productId)
    {

        $wishList = new Wishlist;
        $wishList->user_id = Auth::user()->id;
        $wishList->product_id = $productId;
        $wishList->save();
        return back();
    }

    public function showWishList()
    {
        $products = DB::table('wishlists')
            ->leftJoin('products', 'wishlists.product_id', '=', 'products.id')
            ->join('users', 'users.id', '=', 'wishlists.user_id')
            ->selectRaw('users.id as id_user, users.name as name_user, products.*, wishlists.id as id_wishlist')
            ->where('user_id', Auth::user()->id)
            //   ->orderBy('id','DESC')->paginate(6)
            ->get();
        return view('page.Wishlist', compact('products'));
    }
    public function removeWishList($productId)
    {
        //echo  $id;
        DB::table('wishlists')->where('product_id', '=', $productId)->delete();
        return back()->with('msg', 'San pham da duoc xoa khoi danh muc yeu thich');
    }
    //sort by price
    public function sortByPrice(Request $request)
    {
        $min = $request->minamount;
        $max = $request->maxamount;
        $min = str_replace('$', '', $min);
        $max = str_replace('$', '', $max);
        $products = Product::where('price', '>=', $min)->where('price', '<=', $max)->get();
        dd($products);
        return response()->json(['success' => $products]);
    }
    //Trang liên hệ 
    public function contact()
    {
        return view('page.contact');
    }
    //Lưu liên hệ: 
    public function saveContact(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'email' => 'string|required',
            'message' => 'string|nullable',
        ]);
        $data = $request->all();
        // Thêm cái thời gian:
        $status = Contact::create($data);
        if ($status) {
            request()->session()->flash('success', 'Saved contact successfully');
        } else {
            request()->session()->flash('error', 'Save contact unsuccessfully');
        }
        return redirect()->route('index');
    }
}
