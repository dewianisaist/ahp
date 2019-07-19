@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group mb-0">
                <div class="card p-2">
                    <div class="card-block">
                        <h1>Reset Password</h1>
                        <p class="text-muted">Masukkan email Anda.</p>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div>
                                        @if ($errors->has('email'))
                                            <span class="help-block font-italic">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="input-group mb-1">
                                        <input id="email" type="email" class="form-control" name="email" placeholder="Email" required value="{{ $email or old('email') }}">
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

                                    <div class="input-group mb-1">
                                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <div>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block font-italic">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="input-group mb-1">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Ulangi Password" required>
                                    </div>
                                </div>

                                <div class="row my-1">
                                    <div class="col-6"> Kembali ke 
                                        <a class="btn btn-link px-0" href="{{ url('login') }}">Login</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
