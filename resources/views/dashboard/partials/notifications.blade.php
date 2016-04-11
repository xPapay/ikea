{{--max 6 notifications--}}
<div class="row">
    <div class="col-lg-12">
        <h4>Notifikácie</h4>
        <hr>
    </div>
</div>

<div class="row">
    {{--WHO--}}
    <div class="col-sm-3">
        <h4>Kto</h4>
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        <h4>Kedy</h4>
    </div>
    {{--WHAT--}}
    <div class="col-sm-5">
        <h4>Čo</h4>
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        <h4>Info</h4>
    </div>
</div>

@foreach ($notifications as $notification)
    <div class="row">
        {{--WHO--}}
        <div class="col-sm-3">
            {{ $notification->user->name }}
        </div>
        {{--DATE--}}
        <div class="col-sm-3">
            {{ $notification->created_at }}
        </div>
        {{--WHAT--}}
        <div class="col-sm-5">
            {{ $notification->type }}: {{ $notification->task->name }}
        </div>
        {{--ICON--}}
        <div class="col-sm-1">
            <a href="{{ url("tasks/{$notification->task->id}") }}"><span class='glyphicon glyphicon-info-sign'></span></a>
        </div>
    </div>
@endforeach

<style>
    .glyphicon {
        font-size: 25px;
    }
    .glyphicon-info-sign {
        color: #00d;
    }
</style>

<script>
    $(document).ready(function(){
//        setInterval(function(){
            $.ajax({url: "/tasks/8", success: function(result){
                $("#result").html(result.name);
            }});

//        }, 3000)
    });
</script>