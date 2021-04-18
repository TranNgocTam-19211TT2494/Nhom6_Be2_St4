<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class PageController extends Controller
{
    public function index()
    {
        $blog = Blog::orderBy('created_at', 'DESC')->take(3)->get();
        return view('demo', ['blog' => $blog]);
    }
}
