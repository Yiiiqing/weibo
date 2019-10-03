<<<<<<< HEAD
@foreach (['danger', 'warning', 'success', 'info'] as $msg)
  @if(session()->has($msg))
    <div class="flash-message">
      <p class="alert alert-{{ $msg }}">
        {{ session()->get($msg) }}
      </p>
    </div>
  @endif
=======
@foreach(['danger','warning','success','info'] as $msg)
    @if(session()->has($msg))
        <div class="flash-msg">
          <p class="alert alert-{{ $msg }}">
            {{session()->get($msg)}}
          </p>
        </div>
    @endif
>>>>>>> 5866415510aff0cf208ce83d7e5f37261f17c762
@endforeach
