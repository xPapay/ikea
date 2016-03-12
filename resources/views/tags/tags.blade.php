@extends('layout')
@section('content')
    @include('partials.validation_errors')
    @if (!empty($tags))
        <h2>Tagy:</h2>
        <div class="row">
            <div class="col-sm-4">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Názov</th>
                        <th>Editovať</th>
                        <th>Zmazať</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>{{ $tag->name }}</td>
                            <td><a href="{{ url("admin/tags/{$tag->id}/edit") }}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td>
                                {!! Form::open(['route' => ['admin.tags.destroy',$tag->id], 'method'=>'delete']) !!}
                                <button type="submit" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                </button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endif

    <h2>Pridať tag</h2>

    {!! Form::model(new \App\Tag(), ['action' => 'TagsController@store']) !!}

    @include('tags.form', ['submitButton' => 'Pridať tag'])

    {!! Form::close() !!}
@endsection