<form action="{{ route('statuses.store') }}" method="POST">
  @include('shared._errors')
  {{ csrf_field() }}
<textarea class="form-control" rows="3" placeholder="聊聊新鲜事儿..." name="content">{{ old('content') }}
</textarea>
<!--  textarea之间不能有空格，不然 placeholder 出不来
 -->  <div class="text-right">
    <button type="submit" class="btn btn-primary mt-3">发布</button>
  </div>
</form>
