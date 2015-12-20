@extends('layout')
@section('content')
    <h1>Vaše úlohy</h1>
    <hr>
    <div class="row">
        <div class="col-sm-4">
            Názov
        </div>
        <div class="col-sm-3">
            Termín
        </div>
        <div class="col-sm-2">
            Zadal
        </div>
        <div class="col-sm-3">
            Dátum splnenia
        </div>
    </div>

    @foreach($tasks as $task)
        <div class="row">
            <div class="col-sm-4">
                {{ $task->name }}
            </div>
            <div class="col-sm-3">
                {{ $task->deadline }}
            </div>
            <div class="col-sm-2">
                {{ $task->orderer->name }}
            </div>
            <div class="col-sm-3">
                @if (! is_null($task->accomplish_date))
                    {{ $task->accomplish_date }}
                @else
                    ikon
                @endif
            </div>
        </div>
    @endforeach
@endsection