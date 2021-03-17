<?php

namespace App\Http\Controllers;

use App\Follower;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::where('id','!=',auth()->id())->get();
        $requests=Follower::with('to_user')->where(['from_user_id'=>auth()->id(),'accepted'=>0])->get();
        $active_user='primary';
        
        return view('follow.users',compact('users','active_user','requests'));
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
    public function edit()
    {
        $user=User::find( auth()->id());
        $active_profile='primary';
        return view('auth.user_profile',compact('user','active_profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $name='';
        if($request->hasfile('filename')){
            $file=$request->file('filename');
            $name=time().$file->getClientOriginalName();
            $file->move(public_path().'/images/avatar/',$name);
        }
        $user=User::find(auth()->id());
        $user->first_name=$request->get('first_name');
        $user->last_name=$request->get('last_name');
        $user->birth_date=$request->get('birth_date');
        if(strlen($name)>0)
            $user->avatar=$name;
        $user->save();
        return redirect()->route('edit.user');
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
