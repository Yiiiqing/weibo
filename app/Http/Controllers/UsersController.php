<?php

namespace App\Http\Controllers;

// use App\Models\User;

use Illuminate\Http\Request;
use App\Models\User;//+因为已经声明了namespace，使用 User Model需要这么加
use Auth;

class UsersController extends Controller
{
    //
    public function create()
    {
        return view('users.create');
    }
    /*
由于  show()  方法传参时声明了类型 —— Eloquent 模型  User ，对应的变量名  $user  会匹配路由片段中的  {user} ，这样，Laravel 会自动注入与请求 URI 中传入的 ID 对应的用户模型实例。
    */
    public function show(User $user)//声明了类型 —— Eloquent 模型  User

    {
        return view('users.show', compact('user'));//我们将用户对象  $user  通过  compact  方法转化为一个关联数组，并作为第二个参数传递给  view  方法，将数据与视图进行绑定。

    }

    public function store(Request $request){
        //validate  方法接收两个参数，第一个参数为用户的输入数据，第二个参数为该输入数据的验证规则。
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);
        session()->flash('success','欢迎，您将在这里开启一段新的旅程~');//flash  方法接收两个参数，第一个为会话的键，第二个为会话的值
        return redirect()->route('users.show',[$user]);
    }
}
