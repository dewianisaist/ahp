@extends('layouts.error')

@section('title')
<title>403. Forbidden.</title>
@endsection

@section('content')
<img src="../../errors/403_asset.png" alt="403 Forbidden">
<div class="title">Maaf! Anda tidak mempunyai hak akses.</div>
<br/>
<a class="button" href="/"> Home</a>
@endsection