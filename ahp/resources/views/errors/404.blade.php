@extends('layouts.error')

@section('title')
<title>404. Halaman tidak ditemukan.</title>
@endsection

@section('content')
<img src="../../errors/404_asset.png" alt="404 Page Not Found">
<div class="title">Maaf! Halaman tidak ditemukan.</div>
<br/>
<a class="button" href="/"> Home</a>
@endsection