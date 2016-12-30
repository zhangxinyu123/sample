<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
class UsersController extends Controller
{
    public function create(){
        return view('users.create');
    }
    public function show($id){//用户页面显示
        $user = User::findOrFail($id);
        return view('users.show',compact('user'));
    }
    public function store(Request $request){//输入验证
       $this->validate($request,[
           'name'=>'required|max:50',
           'email'=>'required|email|unique:users|max:255',
           'password'=>'required|confirmed|min:6'
       ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
        ]);
        session()->flash('success','注册成功，在这开启您的新旅程吧~');
        return redirect()->route('users.show',[$user]);
    }

}
