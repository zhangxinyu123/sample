<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only' => ['edit', 'update','destroy']
        ]);
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    public function index()//用户列表
    {
        $users = User::paginate(30);
        return view('users.index', compact('users'));
    }

    public function create()//注册页
    {
        return view('users.create');
    }

    public function show($id)
    {//用户页面显示
        $user = User::findOrFail($id);
        $statuses = $user->statuses()
            ->orderBy('created_at', 'desc')
            ->paginate(30);
        return view('users.show', compact('user', 'statuses'));
    }

    public function store(Request $request)
    {//输入验证
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到您的注册邮箱上，请注意查收。');
        return redirect('/');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'confirmed|min:6'
        ]);
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        $data = array_filter([
            'name' => $request->name,
            'password' => $request->password
        ]);
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $id);
    }
    public function destroy($id){//删除用户
        $user = User::findOrFail($id);
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('success','成功删除用户！');
        return back();
    }
    public function sendEmailConfirmationTo($user){//发送邮件
       $view = 'emails.confirm';
        $data = compact('user');
        $from = '583145128@qq.com';
        $name = 'zhangxinyu';
        $to = $user->email;
        $subject = "感谢注册Sample应用！请确认你的邮箱。";

        Mail::send($view,$data,function($message) use ($from,$name,$to,$subject) {
            $message->from($from,$name)->to($to)->subject($subject);
        });
    }
    public function confirmEmail($token){//激活邮箱
        $user = User::where('activation_token',$token)->firstOrFail();

        $user->activated = true;
        $user->activation_token= null;
        $user->save();

        Auth::login($user);
        session()->flash('success','恭喜你，激活成功！');
        return redirect()->route('users.show',[$user]);
    }
}
