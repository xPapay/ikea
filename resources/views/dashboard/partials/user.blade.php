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
        <div class="col-lg-12">
            <div class="col-md-6">
                <a href="{{ url('users/settings') }}"><span class="glyphicon glyphicon-cog"></span></a>
            </div>
        </div>
    </div>
    <div class="col-xs-1">
        <img src="profile_photos/photo.jpg">
    </div>
</div>
<hr>

<div class="row">
    <div class="col-lg-12">
        <a href="{{ url('tasks/create') }}" class="btn btn-primary" role="button">Zadať úlohu</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <a href="{{ url('tasks/ordered') }}" class="btn btn-primary" role="button">Vami zadané úlohy</a>
    </div>
</div>

{{--<div class="row">--}}
    {{--<div class="col-lg-12">--}}
        {{--<a href="{{ url('issues/create') }}">Zadať problém</a>--}}
    {{--</div>--}}
{{--</div>--}}

{{--<div class="row">--}}
    {{--<div class="col-lg-12">--}}
        {{--<button type="button" class="btn btn-default"><a href="{{ url('issues/reported') }}">Vami nahlásené problémy</a></button>--}}
    {{--</div>--}}
{{--</div>--}}

@if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
    <br>
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ url('admin/tasks') }}" class="btn btn-primary" role="button">Všetky úlohy</a>
        </div>
    </div>

    {{--<div class="row">--}}
        {{--<div class="col-lg-12">--}}
            {{--<a href="{{ url('admin/issues') }}">Všetky problémy</a>--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ url('admin/tags') }}" class="btn btn-warning" role="button">Správa tagov</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ url('admin/users') }}" class="btn btn-danger" role="button">Správa užívateľov</a>
        </div>
    </div>

@endif

