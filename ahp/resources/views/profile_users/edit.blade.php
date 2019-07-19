@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
 
@section('content_header')
<h1>
  Edit Profil
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('profile_users.show') }}"><i class="fa fa-user"></i> Profil Pengguna</a></li>
  <li class="active">Edit Profil</li>
</ol>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-body">
	    @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Maaf!</strong> Ada kesalahan dengan data yang Anda masukkan.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
	    @endif
        {!! Form::model($profile_user, ['method' => 'PATCH','route' => ['profile_users.update', $profile_user->id]]) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Nama:</strong>
                        {!! Form::text('name', null, array('placeholder' => 'Nama','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Password:</strong>
                        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Konfirmasi Password:</strong>
                        {!! Form::password('confirm-password', array('placeholder' => 'Konfirmasi Password','class' => 'form-control')) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection