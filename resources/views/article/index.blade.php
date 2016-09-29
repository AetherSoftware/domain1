@extends('app')

@section('content')
    <a href="article/create">添加</a>
    @if(Session::has('flash_message'))
        <div class="alert alert-danger">{{session('flash_message')}}</div>
    @endif
    <?php foreach($articles as $article) {?>
    <div style="background:#dddddd;margin:20px;">
        <div><a href="article/{{$article->id}}">{{$article->title}}</a></div>
        <div>
            <a href="{{url('/article/'.$article->id.'/edit')}}">
            编辑
            </a>
            <form method="post" action="{{url('/article/'.$article->id)}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" >删除</button>
            </form>
        </div>
    </div>
    <?php } ?>
@endsection
