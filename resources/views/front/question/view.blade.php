@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <ul class="list-unstyled">
                    <li class="media">
                        <img class="mr-3"
                             src="{{\App\Models\User::getPhoto($data[0]['userId'])}}"
                             alt="Generic placeholder image">
                        <div class="media-body">
                            <div class="title">
                                <a href="" class="mt-0">{{$data[0]['title']}}</a>
                                @foreach(\App\Models\QuestionCategory::getCategoryList($data[0]['id']) as $k => $v)
                                    <span class="category--item"
                                          onclick='window.location.href = "{{route('category.index', ['selflink' => $v['selflink']])}}"'>{{$v['name']}}</span>
                                @endforeach

                            </div>
                            <div class="description">
                                {!! $data[0]['text'] !!}
                            </div>
                            <div class="detail">
                                <a href="">{{\App\Models\Comment::getCount($data[0]['id'])}} Yorum</a>
                                - <a href="">{{\App\Models\Visitor::getCount($data[0]['id'])}} Görüntülenme</a>
                                - {{\App\Helper\mHelper::time_ago($data[0]['created_at'])}}
                                - <a href="{{route('save.store', ['id' => $data[0]['id']])}}">
                                    @if(\App\Models\SaveQuestion::isSave($data[0]['id']))
                                        Soruyu Kaydetmekten Vazgeç
                                    @else
                                    Soruyu kaydet
                                    @endif
                                </a>
                                @if(Auth::id() == $data[0]['userId'])
                                    - <a href="{{route('question.edit',['id' => $data[0]['id']])}}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    - <a href="{{route('question.delete',['id' => $data[0]['id']])}}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="category--list">
                    @foreach(\App\Models\QuestionTag::where('questionId', $data[0]['id'])->get() as $k => $v)
                        <a href="#">{{$v['name']}}</a>
                    @endforeach
                </div>
                <h3>Cevaplar;</h3>
                @if(\App\Models\Comment::getCount($data[0]['id'])!=0)
                    <ul class="list-unstyled">
                        @foreach($comments as $k => $v)
                            <li class="media @if($v['isCorrect'] == 1) onCorrect @endif">
                                <img class="mr-3"
                                     src="{{\App\Models\User::getPhoto($v['userId'])}}"
                                     alt="Generic placeholder image">
                                <div class="media-body">
                                    <div class="title">
                                        <a class="mt-0">{{ \App\Models\User::getName($v['userId']) }}</a>
                                        - {{\App\Helper\mHelper::time_ago($v['created_at'])}}
                                        @if($v['isCorrect'] == 1)
                                            <span class="isCorrect">Doğru Cevap</span>
                                        @endif
                                    </div>
                                    <div class="description">
                                        {!! $v['text'] !!}
                                    </div>
                                    <div class="detail">
                                        @if($v['userId'] != \Illuminate\Support\Facades\Auth::id())
                                            <a href="{{route('comment.likeordislike', ['id' => $v['id']])}}"><i
                                                        class="fa fa-thumbs-up"></i>
                                                ({{\App\Models\LikeComment::getCount($v['id'])}})</a>
                                        @else
                                            <a href="{{route('comment.delete', ['id' => $v['id']])}}"><i
                                                        class="fa fa-trash"></i></a>
                                        @endif
                                        @if(\Illuminate\Support\Facades\Auth::id() == $data[0]['userId'] and \App\Models\Comment::isCorrectVariable($data[0]['id']) == 0)
                                            - <a href="{{route('comment.correct', ['id' => $v['id']])}}"><i
                                                        class="fa fa-check"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="alert alert-info">Henüz cevap yazılmamış ilk sen olmalısın!</div>
                @endif
                @if(session('status'))
                    <div class="alert alert-info">{{session('status')}}</div>
                @endif
                <div class="card">
                    <div class="card-header">Cevap Yaz</div>
                    <div class="card-body">
                        <form method="POST" action="{{route('comment.store', $data[0]['id'])}}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="">Cevabınız</label>
                                    <textarea name="text" id="" class="form-control" cols="30" rows="10"
                                              required></textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Cevabı Gönder
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-card-style-3 mx-auto" style="margin-bottom:40px;">
                    <div class="team-thumb"><img class="mr-3" src="{{\App\Models\User::getPhoto($data[0]['userId'])}}"
                                                 alt="Author Picture">
                    </div>
                    <a href="{{route('user.index',['id' => $data[0]['userId']])}}" class="team-name">{{\App\Models\User::getName($data[0]['userId'])}}</a>
                    <span class="team-contact-link">
                        <i class="fe-icon-phone"></i>&nbsp;
                        Toplam {{\App\Models\Question::where('userId', $data[0]['userId'])->count()}} Soru Soruldu</span>
                    <span class="team-contact-link">
                        <i class="fe-icon-mail"></i>&nbsp; Toplam {{\App\Models\Comment::where('userId', $data[0]['userId'])->count()}} Cevap Verildi</span>
                    <div class="team-social-bar-wrap">
                        <div class="team-social-bar">
                            <a class="social-btn sb-style-1 sb-twitter" href="#">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a class="social-btn sb-style-1 sb-github" href="#">
                                <i class="fa fa-github"></i>
                            </a>
                            <a class="social-btn sb-style-1 sb-stackoverflow" href="#">
                                <i class="fa fa-linkedin"></i>
                            </a>
                            <a class="social-btn sb-style-1 sb-skype" href="#">
                                <i class="fa fa-skype"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <h3>Benzer Sorular</h3>
                <ul class="list-group">
                    @foreach(\App\Models\Question::likeQuestions($data[0]['id']) as $k => $v)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{route('view', ['id' => $v['id'],'selflink' => $v['selflink']])}}">{{$v['title']}}</a>
                        </li>
                    @endforeach
                </ul><br>
                @include('layouts.sidebar.app')

            </div>
        </div>
    </div>
@endsection
