<?php

namespace App\Http\Controllers;

use App\Follower;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $follow_requests=Follower::with('from_user')->where(['to_user_id'=>auth()->id(),'accepted'=>0])->get();
        $followers=Follower::with('from_user','to_user')->where(['to_user_id'=>auth()->id(),'accepted'=>1])->orWhereRaw('from_user_id = ? And accepted = ?',[auth()->id(),1])->get();
        $active_follow ='primary';
        return view('follow.followers',compact('follow_requests','followers','active_follow'));
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
        $count_follower=Follower::where(['from_user_id'=>auth()->id(),'to_user_id'=>$request->user_id])->get();
        if($count_follower->count()==0){
            $follower=new Follower();
            $follower->to_user_id=$request->user_id;
            $follower->from_user_id=auth()->id();
            $follower->accepted=0;
            $follower->save();
        }
        return redirect('users');
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
        $follower=Follower::find($id);
        $follower->accepted=1;
        $follower->save();
        return redirect('user/followers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $follower=Follower::find($id);
        $follower->delete();
        return redirect('users');
    }
}
