<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-lg-12">
                <span class="last_name">{{ $last_name }}</span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p>{{ $first_name }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <img src="profile_photos/photo.jpg">
    </div>
</div>
<hr>

<div class="row">
    <div class="col-lg-12">
        <a href="{{ url('tasks/create') }}">Zadať úlohu</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <a href="{{ url('tasks/ordered/unfinished') }}">Vami zadané úlohy</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        Nahlásiť problém
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        Vami nahlásené problémy
    </div>
</div>

