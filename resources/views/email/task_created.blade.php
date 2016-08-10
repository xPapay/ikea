@extends('email_layout')
@section('content')
<h2>{{ $headline }}</h2>
    <div class="row">
        <div class="col-lg-5">
            <div class="row">
                <div class="col-lg-12">
                    <h3>{{ $notification->task->name }}</h3>
                </div>
                <hr>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h4>Popis</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <p>{{ $notification->task->description }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h4>Zadávateľ úlohy:</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                @if($notification->task->orderer)
                    {{ $notification->task->orderer->name }}
                @endif
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h4>Termín úlohy:</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    {{ $notification->task->deadline }}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h4>Zodpovedný za vykonanie:</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    @if (count($notification->task->executors) == 0)
                        nešpecifikované
                    @else
                        <ul>
                            @foreach ($notification->task->executors as $executor)
                                <li>{{ $executor->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    Úloha vytvorená: {{ Carbon\Carbon::parse($notification->task->created_at)->format('d. m. Y H:i') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if ($notification->task->created_at != $notification->task->updated_at)
                        Posledná úprava: {{ Carbon\Carbon::parse($notification->task->updated_at)->format('d. m. Y H:i') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection