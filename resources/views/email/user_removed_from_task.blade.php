@extends('email_layout')
@section('content')
<h2>{{ $headline }} {{ $notification->task->name }} užívateľom: {{ $notification->user->name }} dna: {{ $notification->created_at }}</h2>
@endsection