@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group mb-0">
                <div class="card p-2">
                    <div class="card-block">
                        <h1>Login</h1>
                        <p class="text-muted">Masuk ke akun Anda</p>
                        <form role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('identity_number') ? ' has-error' : '' }}">
                                <div>
                                    @if ($errors->has('identity_number'))
                                        <span class="help-block font-italic">
                                            <strong>{{ $errors->first('identity_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="input-group mb-1">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input id="identity_number" type="text" class="form-control" name="identity_number" placeholder="Nomor Identitas" required value="{{ old('identity_number') }}">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div>
                                    @if ($errors->has('password'))
                                        <span class="help-block font-italic">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="input-group mb-2">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Ingat Saya
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary px-2"><i class="fa fa-btn fa-sign-in"></i> Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection