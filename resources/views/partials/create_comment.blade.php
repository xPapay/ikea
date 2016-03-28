<div class="row">
    <div class="col-sm-6">
        {!! Form::open(['action' => 'CommentController@store', 'files' => true]) !!}
        {!! Form::hidden('executable_id', $executable_id) !!}
        {!! Form::hidden('executable_type', $executable_type) !!}
        <div class="form-group">
            {!! Form::textarea('content', null, ['class' => 'form-control', 'placeholder' => 'Váš komentár...']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('files', 'Súbory') !!}
            {!! Form::file('files[]', ['id' => 'files', 'multiple']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Pridaj komentár', ['class' => 'btn btn-primary form-control']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>