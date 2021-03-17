<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $is_like=Like::where(['user_id'=>auth()->id(),'post_id'=>$request->post_id]);
        if($is_like->count()==0){
            $like=new Like();
            $like->post_id=$request->get('post_id');
            $like->user_id=auth()->id();
            $like->save();    
        }
        
        //return redirect('post/'.$request->post_id);
        $countLike=Like::where(['post_id'=>$request->post_id])->count();
        return response()->json(['count'=>$countLike,'id'=>$like->id]);
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
    public function destroy($post_id)
    {
        $like=Like::where(['user_id'=>auth()->id(),'post_id'=>$post_id]);
        $like->delete();
        //return redirect('post/'.$post_id);
        $countLike=Like::where('post_id',$post_id)->count();
        return response()->json(['count'=>$countLike]);
    }
}
