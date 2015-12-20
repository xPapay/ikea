@extends('layout')

@section('content')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form action="/auth/login" method="POST">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Heslo:</label>
                    <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" required>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="remember"> Zapamätať prihlásenie
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Prihlásiť</button>
                </div>
            </form>

            @include('auth.partials.errors')
        </div>
    </div>

@endsection