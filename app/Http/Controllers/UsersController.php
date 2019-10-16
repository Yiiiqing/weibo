<?php

namespace App\Http\Controllers;

// use App\Models\User;

use Illuminate\Http\Request;
use App\Models\User;//+因为已经声明了namespace，使用 User Model需要这么加
use Auth;
use Mail;

class UsersController extends Controller
{
    //中间件过滤
    //PHP 的构造器方法，当一个类对象被创建之前该方法将会被调
    public function __construct()
    {
        //除了 XXX 需要授权，别的都公开可以访问。
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
        ]);

        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }
    //列表
    public function index()
    {
        $users = User::paginate(10);//指定分页，每页十行
        return view('users.index', compact('users'));
    }
    //创建
    public function create()
    {
        return view('users.create');
    }
    /*
由于  show()  方法传参时声明了类型 —— Eloquent 模型  User ，对应的变量名  $user  会匹配路由片段中的  {user} ，这样，Laravel 会自动注入与请求 URI 中传入的 ID 对应的用户模型实例。
    */
    public function show(User $user)//声明了类型 —— Eloquent 模型  User
    {
        $statuses = $user -> statuses()
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
        return view('users.show', compact('user', 'statuses'));//我们将用户对象  $user  通过  compact  方法转化为一个关联数组，并作为第二个参数传递给  view  方法，将数据与视图进行绑定。

    }

    public function store(Request $request)
    {
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
        //邮箱
        $this->sendEmailConfirmationTo($user);
        session()->flash('success','验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');

        //不增加邮箱验证的话
        // Auth::login($user);
        // session()->flash('success','欢迎，您将在这里开启一段新的旅程~');//flash  方法接收两个参数，第一个为会话的键，第二个为会话的值
        // return redirect()->route('users.show',[$user]);
    }
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));//绑定，在将用户数据与视图进行绑定之后，便可以在视图上通过  $user  来访问用户对象

    }
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);

        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        // 当其值不为空时才将其赋值给  data ，避免将空白密码保存到数据库中。
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success','个人资料更新成功！');

        return redirect()->route('users.show', $user);
    }
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success','成功删除用户！');
        return back();
    }
    //验证邮箱成功
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();//查询不到返回 404

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show',[$user]);
    }
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = '感谢注册Weibo 应用！请确认你的邮箱。';

        Mail::send($view, $data, function($message) use ($to, $subject){
            $message->to($to)->subject($subject);
        });
    }
}
