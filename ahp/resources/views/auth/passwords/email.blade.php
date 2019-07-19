@extends('layouts.auth')

<!-- Main Content -->
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-group mb-0">
                <div class="card p-2">
                    <div class="card-block">
                        <h1>Reset Password</h1>
                        <p class="text-muted">Masukkan email Anda.</p>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div>
                                    @if ($errors->has('email'))
                                        <span class="help-block font-italic">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="input-group mb-1">
                                    <span class="input-group-addon"><i class="icon-user"></i></span>
                                    <input id="email" type="email" class="form-control" name="email" placeholder="Email" required value="{{ old('email') }}">
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-block btn-success"><i class="fa fa-btn fa-envelope"></i> Send Password Reset Link</button>
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
@endsection
