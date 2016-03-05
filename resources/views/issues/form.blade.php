<div class="form-group">
    {!! Form::label('name', 'Názov problému') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Popis') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('solution', 'Riešenie') !!}
    {!! Form::textarea('solution', null, ['class' => 'form-control']) !!}
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
    {!! Form::label('followup_date', 'Termín followupu', ['class' => 'control-label']) !!}
    <div class="input-group date" id="datetimepicker2">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        {!! Form::text('followup_date', null, ['class' => 'form-control']) !!}
    </div>

    {{--{!! Form::input('date', 'deadline', null, ['class' => 'form-control']) !!}--}}
    {{--<i class="glyphicon glyphicon-calendar form-control-feedback"></i>--}}
</div>

<div class="form-group">
    {!! Form::label('costs', 'Náklady') !!}
    {!! Form::text('costs', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('executors', 'Priradený pracovníci') !!}
    {!! Form::select('executorsList[]', $users, null, ['class' => 'form-control', 'id' => 'executorsList', 'multiple']) !!}
</div>

<div class="form-group">
    {!! Form::label('followup_by', 'Followup vykoná') !!}
    {!! Form::select('followup_by', $users, null, ['class' => 'form-control', 'id' => 'followup_by']) !!}
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

        $('#followup_executor').select2({
            placeholder: "Vyber pracovníkov"
        });
    </script>

    <link href="/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="/js/moment.js"></script>
    <script src="/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker({
                locale: "sk",
                format: "DD.MM.YYYY",
                allowInputToggle: true,
                minDate: 'moment',
                widgetPositioning: {
                    horizontal: 'left',
                    vertical: 'bottom'
                }
            });

            $('#datetimepicker2').datetimepicker({
                locale: "sk",
                format: "DD.MM.YYYY",
                allowInputToggle: true,
                minDate: 'moment',
                widgetPositioning: {
                    horizontal: 'left',
                    vertical: 'bottom'
                }
            });

            $('#datetimepicker1').on('dp.change', function(e) {
                $('#datetimepicker2').data('DateTimePicker').minDate(e.date);
            })
        });
    </script>
@endsection

