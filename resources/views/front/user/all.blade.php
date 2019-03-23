@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="container">
            <div class="row pt-3">
            @foreach($data as $k => $v)
                <!-- Author-->
                    <div class="col-lg-3 col-sm-6 mb-30 pb-2">
                        <div class="team-card-style-3 mx-auto">
                            <div class="team-thumb" ><img src="{{\App\Models\User::getPhoto($v['id'])}}"
                                                         alt="Author Picture">
                            </div>
                            <h4 class="team-name"><a
                                        href="{{route('user.index', ['id' => $v['id']])}}">{{$v['first_name'] . ' '. $v['last_name']}}</a>
                            </h4>

                        </div>
                    </div>
                    <!-- Author-->
                @endforeach
            </div>
        </div>
    </div>
@endsection