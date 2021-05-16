<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use App\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $comment = PostComment::orderBy('id', 'DESC')->paginate(10);
        return view('backend.comment.index')->with('comments', $comment);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posts = Post::orderBy('id', 'DESC')->paginate(10);
        return view('backend.comment.create')->with('posts', $posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo $request->cat_id;
        // echo $request->comment;
        // echo $request->status;
        $this->validate($request, [
            'comment' => 'string|required|max:50',
        ]);
        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }
        $data = $request->all();
        $data['user_id'] = $user_id;
        $data['post_id'] = $request->post_id;
        $status = PostComment::create($data);
        if ($status) {
            request()->session()->flash('success', 'Comment successfully added');
        } else {
            request()->session()->flash('error', 'Error occurred while adding comment');
        }
        return redirect()->back();
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
        $comment = PostComment::findOrFail($id);
        echo $comment;
        echo $request->reply;

        $data['replied_comment'] = $request->reply;


        $status = $comment->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Comment successfully updated');
        } else {
            request()->session()->flash('error', 'Error occurred while updating comment');
        }
        return redirect()->back();
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
        $comment = PostComment::findOrFail($id);
        if ($comment) {
            $status = $comment->delete();
            if ($status) {
                request()->session()->flash('success', 'Comment Successfully deleted');
            } else {
                request()->session()->flash('error', 'Comment can not deleted');
            }
            return redirect()->back();
        } else {
            request()->session()->flash('error', 'Comment not found');
            return redirect()->back();
        }
    }
}
