<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function showcaterogy($id)
    {
        $feature = Blog::where('feature', 1)->take(3)->get();
        $blog_category = BlogCategory::all();
        $blog = Blog::where('id_category', $id)->paginate(4);
        return view('pages.blog_caterogy', ['blog' => $blog, 'blog_category' => $blog_category, 'feature' => $feature]);
    }
    public function hienthi()
    {
        $feature = Blog::where('feature', 1)->take(3)->get();
        $blog_category = BlogCategory::all();
        $blog = Blog::orderBy('created_at', 'DESC')->paginate(4);
        return view('pages.blog', ['blog' => $blog, 'blog_category' => $blog_category, 'feature' => $feature]);
    }
    public function hienthichitiet($id)
    {
        $blog = Blog::find($id);
        $blog_category = BlogCategory::all();
        $feature = Blog::where('id_category', 1)->paginate(4);
        return view('pages.blog_detail', ['blog' => $blog, 'blog_category' => $blog_category, 'feature' => $feature]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // $blogList = Blog::all();
        // return view('blog', compact('blogList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
