@extends('app')
@section('content')
    <b>Свободные деньги: </b>{{ $freemoneys }} ₽
    <br>
    <b>Всего на депозитах: </b>{{ $deposites }} ₽
    <br>
    <b>Общий баланс: </b>{{ $deposites + $freemoneys }} ₽
@endsection


