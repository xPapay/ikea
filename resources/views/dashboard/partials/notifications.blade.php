{{--max 6 notifications--}}
<div class="row">
    <div class="col-lg-12">
        <h4>Notifikácie</h4>
        <hr>
    </div>
</div>
<div class="row">
    {{--WHO--}}
    <div class="col-sm-2">
        STPO
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        27. 08. 2015
    </div>
    {{--WHAT--}}
    <div class="col-sm-6">
        Splinl úlohu
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        icon
    </div>
</div>

{{--DELETE THES, THEY'RE JUST FOR TESTING PURPOSE--}}
<div class="row">
    {{--WHO--}}
    <div class="col-sm-2">
        STPO
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        27. 08. 2015
    </div>
    {{--WHAT--}}
    <div class="col-sm-6">
        Splinl úlohu
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        icon
    </div>
</div>

<div class="row">
    {{--WHO--}}
    <div class="col-sm-2">
        STPO
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        27. 08. 2015
    </div>
    {{--WHAT--}}
    <div class="col-sm-6">
        Splinl úlohu
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        icon
    </div>
</div>

<div class="row">
    {{--WHO--}}
    <div class="col-sm-2">
        STPO
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        27. 08. 2015
    </div>
    {{--WHAT--}}
    <div class="col-sm-6">
        Splinl úlohu
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        icon
    </div>
</div>

<div class="row">
    {{--WHO--}}
    <div class="col-sm-2">
        STPO
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        27. 08. 2015
    </div>
    {{--WHAT--}}
    <div class="col-sm-6">
        Splinl úlohu
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        icon
    </div>
</div>

<div class="row">
    {{--WHO--}}
    <div class="col-sm-2">
        STPO
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        27. 08. 2015
    </div>
    {{--WHAT--}}
    <div class="col-sm-6">
        Splinl úlohu
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        icon
    </div>
</div>

<div id="result">

</div>

<script>
    $(document).ready(function(){
//        setInterval(function(){
            $.ajax({url: "/tasks/8", success: function(result){
                $("#result").html(result.name);
            }});

//        }, 3000)
    });
</script>