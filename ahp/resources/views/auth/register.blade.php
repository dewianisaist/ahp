@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mx-2">
                <div class="card-block p-2">
                    <h1>Register</h1>
                    <p class="text-muted">Buat akun Anda</p>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="input-group mb-1">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input id="name" type="text" class="form-control" name="name" placeholder="Nama" required value="{{ old('name') }}">
                            </div>
                            <div>
                                @if ($errors->has('name'))
                                    <span class="help-block font-italic">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('identity_number') ? ' has-error' : '' }}">
                            <div class="input-group mb-1">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input id="identity_number" type="text" class="form-control" name="identity_number" placeholder="Nomor Identitas berupa NIK" required value="{{ old('identity_number') }}">
                            </div>
                            <div>
                                @if ($errors->has('identity_number'))
                                    <span class="help-block font-italic">
                                        <strong>{{ $errors->first('identity_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="input-group mb-1">
                                <span class="input-group-addon">@</span>
                                <input id="email" type="email" class="form-control" name="email" placeholder="Email" required value="{{ old('email') }}">
                            </div>
                            <div>
                                @if ($errors->has('email'))
                                    <span class="help-block font-italic">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="input-group mb-1">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <div>
                                @if ($errors->has('password'))
                                    <span class="help-block font-italic">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="input-group mb-2">
                                <span class="input-group-addon"><i class="fa fa-repeat"></i></span>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  placeholder="Ulangi Password" required>
                            </div>
                            <div>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block font-italic">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-block btn-success"><i class="fa fa-btn fa-user"></i> Buat Akun</button>
                        </div>
                    </form>
               
                    <div class="row my-1">
                        <div class="col-10"> Anda sudah punya akun? 
                            <a class="btn btn-link px-0" href="{{ url('login') }}">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection