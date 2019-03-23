@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Kaydedilmiş Sorular</div>
                    <div class="card-body">
                        @foreach($data as $k => $v)
                            <li class="list-group-item">
                                <a href="{{route('view', ['id' => $v['questionId'], 'selflink' => \App\Models\Question::getSelfLink($v['questionId'])])}}">{{\App\Models\Question::getTitle($v['questionId'])}}</a>
                            </li>
                        @endforeach
                    </div>
                </div>
                {{$data->links()}}
            </div>
            <div class="col-md-4">
                @include('layouts.sidebar.settings')
            </div>
        </div>
    </div>
@endsection
