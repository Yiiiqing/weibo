@extends('layouts.default')


@section('content')
  @if (Auth::check())
    <div>
      <div class="row">
        <div class="col-md-8">
          <section>
            @include('shared._status_form')
          </section>
          <h4>微博列表</h4>
          <hr>
          @include('shared._feed')
        </div>
        <aside class="col-md-4">
          <section class="user_info">
            @include('shared._user_info',['user' => Auth::user()])
          </section>
        </aside>
      </div>
    </div>
  @else
    <div class="jumbotron">
      <h1>Hello！(￣▽￣)~*</h1>
      <p class="lead">你现在所看到的是 🐽张一清 的 微博💬 网站！</p>
      <h4>你怎么发现这个角落的？是不是我告诉你的？如果是的话，那就说明：<hr/></h4><h4>我爱你❤️</h4><p>喂！屏幕面前的那位！说你呢</p>
      <hr/>
      <h5>什么？不是？那你还待着干嘛！</h5>
      <p>项目Git主页<a href="https://github.com/Yiiiqing/weibo">Laravel weibo project</a></p>
      <p>一切，将从这里开始</p>
      <p>
        <a class="btn btn-lg btn-success" href="{{route('signup')}}" role="button">现在注册</a>
      </p>
    </div>
  @endif
@stop
