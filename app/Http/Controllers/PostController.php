<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::withCount('likes')->whereIn('user_id', auth()->user()->following()->where('accepted', '=', 1)->pluck('to_user_id'))->orderBy("created_at", "Asc")->paginate(9);
        $active_home = "primary";
        return view('home', compact('posts', 'active_home'));
    }


    public function userPosts(Request $request)
    {
        $posts = Post::where('user_id', auth()->id())->get();
        $active_myPost = "primary";
        return view('post.user_posts', compact('posts','active_myPost'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.new_post');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if ($request->hasfile('filename')) {
                $file = $request->file('filename');
                $name = time() . $file->getClientOriginalName();
                $file->move(public_path() . '/images/', $name);
            }
            $post = new Post();
            $post->body = $request->get('body');
            $post->user_id = auth()->id();
            $post->image_path = $name;
            $post->save();
            return redirect()->route('post.show', $post->id)->with(['success' => 'تم إضافة المنشور بنجاح']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['fails' => 'حدث خطأ ما أرجو المحاولة مرة أخرى']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $post = Post::with(['user', 'likes'])->find($id);
            $isLiked = Like::where(['user_id' => auth()->id(), 'post_id' => $id])->get();
            $post_comments = Post::with('comments', 'comments.user')->find($id);
            return view('post.view_post', compact('post', 'isLiked', 'post_comments'));
        } catch (\Exception $e) {
            return redirect()->back()->with(['fails' => 'حدث خطأ ما أرجو المحاولة مرة أخرى']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $post = Post::find($id);
            if (auth()->id() === $post->user_id)
                return view('post.edit_post', compact('post'));
            else
                return redirect('not_found');
        } catch (\Exception $e) {
            return redirect()->back()->with(['fails' => 'حدث خطأ ما أرجو المحاولة مرة أخرى']);
        }
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
        try {
            $post = Post::find($id);
            if (auth()->id() === $post->user_id) {
                $post->body = $request->get('body');
                $post->save();
                return redirect()->route('post.show' . $id)->with(['success' => 'تم تعديل المنشور بنجاح']);
            } else {
                return redirect('not_found');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['fails' => 'حدث خطأ ما أرجو المحاولة مرة أخرى']);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $post = Post::find($id);
            if (auth()->id() == $post->user_id) {
                $post->delete();
                return redirect('user/posts');
            } else {
                return redirect('not_found');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['fails' => 'حدث خطأ ما أرجو المحاولة مرة أخرى']);
        }
    }
}
