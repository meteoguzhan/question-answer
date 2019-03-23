@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 >{{$q}}</h3>
                @if(count($data)!=0)
                    <ul class="list-unstyled">
                        @foreach($data as $k => $v)
                            <li class="media">
                                <img class="mr-3" src="{{\App\Models\User::getPhoto($v['userId'])}}" alt="Generic placeholder image">
                                <div class="media-body">
                                    <div class="title">
                                        <a href="{{route('view', ['selflink' => $v['selflink'], 'id' => $v['id']])}}" class="mt-0">{{$v['title']}}</a> - {{\App\Helper\mHelper::time_ago($v['created_at'])}}
                                    </div>
                                    <div class="description">
                                        {!! \App\Helper\mHelper::split($v['text'], 120) !!}
                                    </div>
                                    <div class="detail">
                                        <a href="">{{\App\Models\Comment::getCount($v['id'])}} Yorum</a> - <a href="">{{ \App\Models\Visitor::getCount($v['id']) }} Görüntülenme</a> - <a href="{{route('view', ['selflink' => $v['selflink'], 'id' => $v['id']])}}">Devamını Oku</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-info">Soru bulunamadı</div>
                @endif
                {!! $data->links() !!}
            </div>
            <div class="col-md-4">
                @include('layouts.sidebar.app')
            </div>
        </div>
    </div>
@endsection
