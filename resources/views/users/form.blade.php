<div class="form-group">
    {!! Form::label('name', 'Meno') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('email', 'Email') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('roles', 'Role') !!}
    {!! Form::select('rolesList[]', $roles, null, ['class' => 'form-control', 'id' => 'roles', 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButton, ['class' => 'btn btn-primary form-control']) !!}
</div>

@section('footer')
    <link href="/css/select2.css" rel="stylesheet" />
    <script src="/js/select2.js"></script>
    <script>
        $('#roles').select2({
            placeholder: "Vyber role"
        });
    </script>
@endsection