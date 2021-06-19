<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DateTime;
use DateInterval;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('cat_info')->orderBy('id', 'desc')->paginate(10);
        return view('backend.product.index', compact('products', $products));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::get();
        return view('backend.product.create')->with('categories', $category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        //Kiểm tra dữ liệu gửi về từ request
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|required',
            'weight' => 'required',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'numeric',
            'manufacturer' => 'string|nullable',
            'expiry' => 'numeric',
        ]);
        // //Gán dữ liệu
        $data = $request->all();

        //Tạo slug
        $slug = Str::slug($request->title);
        //Kiểm tra slug có trùng hay không?
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        //Gán lại slug vào $data
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);
        //Gọi phương thức create
        $status = Product::create($data);
        //Kiểm tra quá trình thêm product đã thành công hay chưa
        if ($status) {
            request()->session()->flash('success', 'Product Successfully added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $category = Category::get();
        // return $items;
        return view('backend.product.edit')->with('product', $product)
            ->with('categories', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        //Kiểm tra dữ liệu gửi về từ request
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|required',
            'weight' => 'required',
            'stock' => "required|numeric",
            'cat_id' => 'required|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price' => 'required|numeric',
            'discount' => 'numeric',
            'manufacturer' => 'string|nullable',
            'expiry' => 'numeric',
        ]);
        // //Gán dữ liệu
        $data = $request->all();
        //$data['is_featured'] = $request->input('is_featured', 0);
        //Gọi phương thức update
        $status = $product->fill($data)->save();
        //Kiểm tra quá trình thêm product đã thành công hay chưa
        if ($status) {
            request()->session()->flash('success', 'Product Updated Successfully');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $status = $product->delete();
        //Kiểm tra quá trình thêm product đã thành công hay chưa
        if ($status) {
            request()->session()->flash('success', 'Product Deleted Successfully');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
    }
    //Phương thức tự động giảm giá sản phẩm khi hạn sử dụng còn ít
    public static function AutoDiscount()
    {
        $products = Product::all();
        $dtNow = Carbon::now('Asia/Ho_Chi_Minh');
        foreach ($products as $product) {
            $ngayNhap = new DateTime(($product->created_at)->format("Y-m-d"));
            $now = new DateTime($dtNow->format("Y-m-d"));
            $interval = new DateInterval('P' . $product->expiry . 'D');
            $handung = $ngayNhap->add($interval);
            //$ex2=$dtNow->format("Y-m-d");
            $expired = $handung->diff($now);
            if ($expired->d <= 2) {
                $product['discount'] = 50;
                $product->save();
            }
        }
    }
    //Phương thức tự ẩn sản phẩm khi hết hạn
    //Phương thức tự động giảm giá sản phẩm khi hạn sử dụng còn ít
    public static function AutoInactive()
    {
        $products = Product::get();
        $dtNow = Carbon::now('Asia/Ho_Chi_Minh');
        foreach ($products as $product) {
            $ngayNhap = new DateTime(($product->created_at)->format("Y-m-d"));
            $now = new DateTime($dtNow->format("Y-m-d"));
            $interval = new DateInterval('P' . $product->expiry . 'D');
            $handung = $ngayNhap->add($interval);
            //$ex2=$dtNow->format("Y-m-d");
            $expired = $handung->diff($now);
            if ($expired->d == 0) {
                $product['status'] = 'inactive';
                $product->save();
            }
        }
    }
}
