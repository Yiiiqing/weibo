<!DOCTYPE html>
<html>
<head>
<title>@yield('title','Weibo App') - Laravel bite</title>
<link rel="stylesheet" href="{{mix('css/app.css')}}">
</head>

<body>
  @include('layouts._header')

  <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="/">Weibo App</a>
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item"><a class="nav-link" href="/help">帮助</a></li>
        <li class="nav-item"><a class="nav-link" href="#">登录</a></li>
      </ul>
    </div>
  </nav> -->
  <div>
    @include('shared._messages')
    @yield('content')
    @include('layouts._footer')
  </div>
</body>
</html>
