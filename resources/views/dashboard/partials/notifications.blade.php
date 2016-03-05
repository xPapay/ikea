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

<div class="row">
    {{--WHO--}}
    <div class="col-sm-3">
        Jozef Novák
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        06. 11. 2015
    </div>
    {{--WHAT--}}
    <div class="col-sm-5">
        <i>Pridal komentár k úlohe:</i> Reklamovať lepidlo
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        <span class='glyphicon glyphicon-info-sign'></span>
    </div>
</div>
<style>
.glyphicon {
    font-size: 25px;
}
.glyphicon-info-sign {
    color: #00d;
}
</style>

{{--DELETE THES, THEY'RE JUST FOR TESTING PURPOSE--}}
<div class="row">
    {{--WHO--}}
    <div class="col-sm-3">
        Marek Slovák
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        05. 11. 2015
    </div>
    {{--WHAT--}}
    <div class="col-sm-5">
        <i>Zaevidoval problém:</i> Pokazená ...
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        <span class='glyphicon glyphicon-info-sign'></span>
    </div>
</div>

<div class="row">
    {{--WHO--}}
    <div class="col-sm-3">
        James Bond
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        03. 11. 2015
    </div>
    {{--WHAT--}}
    <div class="col-sm-5">
        <i>Splinl úlohu:</i> Objednať nity
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        <span class='glyphicon glyphicon-info-sign'></span>
    </div>
</div>

<div class="row">
    {{--WHO--}}
    <div class="col-sm-3">
        Marek Viedenský
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        02. 11. 2015
    </div>
    {{--WHAT--}}
    <div class="col-sm-5">
        Napísal správu k follow-up
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        <span class='glyphicon glyphicon-info-sign'></span>
    </div>
</div>

<div class="row">
    {{--WHO--}}
    <div class="col-sm-3">
        Tomáš Zátopek
    </div>
    {{--DATE--}}
    <div class="col-sm-3">
        02. 11. 2015
    </div>
    {{--WHAT--}}
    <div class="col-sm-5">
        <i>Pridal komentár k úlohe:</i> Reklamovať lepidlo
    </div>
    {{--ICON--}}
    <div class="col-sm-1">
        <span class='glyphicon glyphicon-info-sign'></span>
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