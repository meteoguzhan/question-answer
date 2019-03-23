@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('status'))
                    <div class="alert alert-success">{{session('status')}}</div>
                @endif
                <div class="card">
                    <div class="card-header">Profili Düzenle</div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" method="POST" action="{{route('settings.store')}}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <img width="120" height="120" src="{{\App\Models\User::getPhoto(\Illuminate\Support\Facades\Auth::id())}}" alt="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="file" name="photo">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="">Adınız</label>
                                    <input type="text" name="first_name" required class="form-control" value="{{Auth::user()->first_name}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Soyadınız</label>
                                    <input type="text" name="last_name" required class="form-control" value="{{Auth::user()->last_name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="">E-Posta</label>
                                    <input type="email" name="email" required class="form-control" value="{{Auth::user()->email}}">
                                </div>
                                <div class="col-md-6">
                                    <label for="">Doğum Tarihiniz</label>
                                    <input type="date" name="birthday" required class="form-control" value="{{Auth::user()->birthday}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label for="">Telefon Numarası</label>
                                    <input type="tel" name="phone" required class="form-control" value="{{Auth::user()->phone}}">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Web Sitesi</label>
                                    <input type="text" name="website" required class="form-control" value="{{Auth::user()->website}}">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Meslek</label>
                                    <input type="text" name="job" required class="form-control" value="{{Auth::user()->job}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="">Hakkımda</label>
                                    <textarea name="bio" id="" cols="30" rows="10" class="form-control">{{Auth::user()->bio}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Güncelle
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @include('layouts.sidebar.settings')
            </div>
        </div>
    </div>
@endsection
