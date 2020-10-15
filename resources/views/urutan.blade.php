@extends('layouts.app')

@section('title','Urutan')

@section('content')

@foreach ($numbers as $number)
<h1>Urutan ke - {{ $number['ke'] }}</h1>
<h3>Nomor ke - {{ $number['nomor'] }}<h3>
@endforeach

@endsection

    
