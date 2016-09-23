<div class="form-group">
    {!! Form::label('name', 'Názov úlohy') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Popis') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('deadline', 'Termín', ['class' => 'control-label']) !!}
    <div class="input-group date" id="datetimepicker1">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        {!! Form::text('deadline', null, ['class' => 'form-control']) !!}
    </div>

    {{--{!! Form::input('date', 'deadline', null, ['class' => 'form-control']) !!}--}}
    {{--<i class="glyphicon glyphicon-calendar form-control-feedback"></i>--}}
</div>

<div class="form-group">
    {!! Form::label('singleExecutor', 'Len jeden exekútor') !!}
    {!! Form::checkbox('singleExecutor', 1, false, ['id' => 'singleExecutor']) !!}
</div>

<div class="form-group">
    {!! Form::label('executorsList', 'Priradený pracovníci') !!}
    {!! Form::select('executorsList[]', $users, null, ['class' => 'form-control', 'id' => 'executorsList', 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::label('supportersList', 'Pracovníci na support') !!}
    {!! Form::select('supportersList[]', $users, null, ['class' => 'form-control', 'id' => 'supportersList', 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::label('tagsList', 'Tagy') !!}
    {!! Form::select('tagsList[]', $tags, null, ['class' => 'form-control', 'id' => 'tagsList', 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::label('files', 'Súbory') !!}
    {!! Form::file('files[]', ['id' => 'files', 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButton, ['class' => 'btn btn-primary form-control']) !!}
</div>

@section('footer')
    <link href="/css/select2.css" rel="stylesheet" />
    <script src="/js/select2.js"></script>
    <script>
        $('#executorsList').select2({
            placeholder: "Vyber pracovníkov"
        });

        $('#supportersList').select2({
            placeholder: "Vyber pracovníkov na support"
        });

        $('#tagsList').select2({
            placeholder: "Vyber tagy"
        });
    </script>

    <link href="/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="/js/moment.js"></script>
    <script src="/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker({
                locale: "sk",
                format: "DD. MM. YYYY",
                allowInputToggle: true,
                widgetPositioning: {
                    horizontal: 'left',
                    vertical: 'bottom'
                }
            })

            $("#singleExecutor").change(function() {
                if(this.checked) {
                    $("#executorsList").select2({
                      maximumSelectionLength: 1
                    });
                }

                if(this.checked == false) {
                    $("#executorsList").select2({
                      maximumSelectionLength: 0
                    });
                }
            });
        });
    </script>
@endsection