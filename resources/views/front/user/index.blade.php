@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="profile-card-4 z-depth-3">
                    <div class="card">
                        <div class="card-body text-center bg-primary rounded-top">
                            <div class="user-box">
                                <img src="{{\App\Models\User::getPhoto($data[0]['id'])}}" alt="user avatar">
                            </div>
                            <h5 class="mb-1 text-white">{{\App\Models\User::getName($data[0]['id'])}}</h5>
                            <h6 class="text-light">{{$data[0]['job']}}</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-group shadow-none">
                                <li class="list-group-item">
                                    <div class="list-icon">
                                        <i class="fa fa-phone-square"></i>
                                    </div>
                                    <div class="list-details">
                                        <span>{{$data[0]['phone']}}</span>
                                        <small>Telefon Numarası</small>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-icon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <div class="list-details">
                                        <span>{{$data[0]['email']}}</span>
                                        <small>E-posta Adresi</small>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="list-icon">
                                        <i class="fa fa-globe"></i>
                                    </div>
                                    <div class="list-details">
                                        <span>{{$data[0]['website']}}</span>
                                        <small>Website Adresi</small>
                                    </div>
                                </li>
                            </ul>
                            <div class="row text-center mt-4">
                                <div class="col p-2">
                                    <h4 class="mb-1 line-height-5">{{\App\Models\Question::where('userId', $data[0]['id'])->count()}}</h4>
                                    <small class="mb-0 font-weight-bold">Toplam Soru</small>
                                </div>
                                <div class="col p-2">
                                    <h4 class="mb-1 line-height-5">{{\App\Models\Comment::where('userId', $data[0]['id'])->count()}}</h4>
                                    <small class="mb-0 font-weight-bold">Toplam Yorum</small>
                                </div>
                                <div class="col p-2">
                                    <h4 class="mb-1 line-height-5">{{\App\Models\Comment::where('userId', $data[0]['id'])->where('isCorrect', 1)->count()}}</h4>
                                    <small class="mb-0 font-weight-bold">Doğru Cevap</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card z-depth-3">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-pills-primary nav-justified">
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#profile" data-toggle="pill"
                                   class="nav-link active show"><i class="icon-user"></i> <span
                                            class="hidden-xs">Profil</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#messages" data-toggle="pill"
                                   class="nav-link"><i class="icon-envelope-open"></i> <span
                                            class="hidden-xs">Sorular</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link"><i
                                            class="icon-note"></i> <span class="hidden-xs">Cevaplar</span></a>
                            </li>
                        </ul>
                        <div class="tab-content p-3">
                            <div class="tab-pane active show" id="profile">
                                <h5 class="mb-3">Hakkımda</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        {{str_replace("\n","<br\>",$data[0]['bio'])}}
                                    </div>
                                </div>
                                <!--/row-->
                            </div>
                            <div class="tab-pane" id="messages">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                    @foreach($questions as $k => $v)
                                        <tr>
                                            <td>
                                                <span class="float-right font-weight-bold">{{\App\Helper\mHelper::time_ago($v['created_at'])}}</span>
                                                <a href="{{route('view', ['id' => $v['id'], 'selflink' => $v['selflink']])}}">{{$v['title']}}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="edit">
                                <table class="table table-hover table-striped">
                                    <tbody>
                                    @foreach($comments as $k => $v)
                                        <tr>
                                            <td>
                                                <span class="float-right font-weight-bold">{{\App\Helper\mHelper::time_ago($v['created_at'])}}</span>
                                                <a href="{{route('view', ['id' => $v['questionId'], 'selflink' => \App\Models\Question::getSelfLink($v['questionId']) ])}}">{{$v['text']}}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection