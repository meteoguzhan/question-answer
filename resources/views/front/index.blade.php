@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>{{$title}}</h3>
                <a href="{{route('index')}}">Son Sorular</a>
                - <a href="{{route('cevaplanmis')}}">Cevaplanmış</a>
                - <a href="{{route('cozumlenmis')}}">Çözümlenmiş</a>
                <ul class="list-unstyled">
                    @foreach($data as $k => $v)
                        <li class="media">
                            <img class="mr-3" src="{{\App\Models\User::getPhoto($v['userId'])}}"
                                 alt="Generic placeholder image">
                            <div class="media-body">
                                <div class="title">
                                    <a href="{{route('view', ['selflink' => $v['selflink'], 'id' => $v['id']])}}"
                                       class="mt-0">{{$v['title']}}</a>
                                    @foreach(\App\Models\QuestionCategory::getCategoryList($v['id']) as $k2 => $v2)
                                          <span class="category--item" onclick='window.location.href = "{{route('category.index', ['selflink' => $v2['selflink']])}}"'>{{$v2['name']}}</span>
                                    @endforeach
                                </div>
                                <div class="description">
                                    {!! \App\Helper\mHelper::split($v['text'], 120) !!}
                                </div>
                                <div class="detail">
                                    <a href="">{{\App\Models\Comment::getCount($v['id'])}} Yorum</a> - <a
                                            href="">{{ \App\Models\Visitor::getCount($v['id']) }} Görüntülenme</a>
                                    - {{\App\Helper\mHelper::time_ago($v['created_at'])}} - <a
                                            href="{{route('view', ['selflink' => $v['selflink'], 'id' => $v['id']])}}">Devamını
                                        Oku</a>
                                </div>
                                @if(\App\Models\Comment::getCount($v['id'])!=0)
                                    <div class="detail">
                                        {{\App\Models\Comment::getLastComment($v['id'])}}
                                    </div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                {!! $data->links() !!}
            </div>
            <div class="col-md-4">
                @include('layouts.sidebar.app')
            </div>
        </div>
    </div>
@endsection
