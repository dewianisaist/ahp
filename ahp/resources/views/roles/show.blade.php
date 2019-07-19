@extends('layouts.master_admin')

@section('sidebar_menu')
	@include('layouts.sidebar')
@endsection
  
@section('content_header')
<h1>
  Detail <dfn>Role</dfn>
</h1>
<ol class="breadcrumb">
  <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('roles.index') }}"><i class="fa fa-key"></i> Manajemen <dfn>Role</dfn></a></li>
  <li class="active">Detail <dfn>Role</dfn></li>
</ol>
@endsection

@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><dfn>Role</dfn> {{ $role->display_name }}</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nama:</strong>
                    {{ $role->display_name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Deskripsi:</strong>
                    {{ $role->description }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong><dfn>Permission</dfn>:</strong>
                    @if(!empty($rolePermissions))
                        @foreach($rolePermissions as $v)
                            <label class="label label-success">{{ $v->display_name }}</label>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection