@extends('layouts.error')

@section('title')
<title>503. Sedang dalam perbaikan.</title>
@endsection

@section('content')
<img src="../../errors/503_asset.png" alt="503 Under Maintenance">
<div class="title">Maaf! Sedang dalam perbaikan.</div>
<br/>
<a class="button" href="/"> Home</a>
@endsection