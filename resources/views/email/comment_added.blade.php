@extends('email_layout')
@section('content')
<h2>{{ $headline }}</h2>
@foreach($notification->task->comments as $comment)
            <div class="col-sm-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if($comment->owner)
                        <strong>{{ $comment->owner->name }}</strong>
                    @endif
                    <span class="text-muted">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->diffForHumans() }}</span>
                    <span class="text-muted">({{ Carbon\Carbon::parse($comment->created_at)->format('d.m.Y H:i') }})</span>
                </div>
                <div class="panel-body">
                    {{ $comment->content }}
                    
                </div><!-- /panel-body -->
            </div><!-- /panel panel-default -->
</div><!-- /col-sm-5 -->
@endforeach

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
        </div>
    </div>
