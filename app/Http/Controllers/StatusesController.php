<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //添加
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);


        Auth::user()->statuses()->create([
            'content' =>$request['content']
        ]);

        session()->flash('success','发布成功！');
        return redirect()->back();
    }
    //删除
    public function destroy(Status $status)//隐形路由模型绑定，传入的是 id，但是 laravel 自动查找并注入对象
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }
}
