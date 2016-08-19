<div class="row">
    <div class="col-lg-4">
        {!! Form::label('keyword', 'Kľúčové slovo') !!}
        {!! Form::input('text', 'keyword', $filters['keyword'], ['class' => 'form-control', 'placeholder' => 'Hľadaj podľa názvu']) !!}
    </div>
    <div class="col-lg-4">
        {!! Form::label('orderer', 'Zadávatelia') !!}
        {!! Form::select('orderersList[]', $selectableOptions['users'], $filters['orderersList'], ['class' => 'form-control', 'id' => 'orderers', 'multiple']) !!}
    </div>
    <div class="col-lg-4">
        {!! Form::label('tags', 'Tagy') !!}
        {!! Form::select('tagsList[]', $selectableOptions['tags'], $filters['tagsList'], ['class' => 'form-control', 'id' => 'tags', 'multiple']) !!}
    </div>
</div><!-- /.row -->
<div class="row">
    <div class="col-lg-2">
        {!! Form::label('deadline_from', 'Deadline od', ['class' => 'control-label']) !!}
        <div class="input-group date" id="deadlineFrom">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
            {!! Form::text('deadline_from', $filters['deadline_from'], ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-lg-2">
        {!! Form::label('deadline_to', 'Deadline do', ['class' => 'control-label']) !!}
        <div class="input-group date" id="deadlineTo">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
            {!! Form::text('deadline_to', $filters['deadline_to'], ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
@if (!isset($do_not_show_status))
    <div class="row">
        <div class="col-lg-2">
            {!! Form::label('status', 'Status') !!}
            {!! Form::select('status', $selectableOptions['status'], $filters['status'], ['class' => 'form-control', 'id' => 'status']) !!}
        </div>
    </div>
@endif
<div class="row">
    <div class="col-lg-2">
        {!! Form::input('submit', 'filter', 'Filtruj', ['class' => 'btn btn-primary form-control']) !!}
    </div>
</div>

<link href="/css/select2.css" rel="stylesheet" />
<script src="/js/select2.js"></script>
<script>
    $('#orderers').select2({
        placeholder: "Vyber zadávateľa"
    });

    $('#tags').select2({
        placeholder: "Vyber tagy"
    });
</script>

<link href="/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
<script src="/js/moment.js"></script>
<script src="/js/bootstrap-datetimepicker.min.js"></script>

<script>
    $(function () {
        $('#deadlineFrom').datetimepicker({
            locale: "sk",
            format: "DD. MM. YYYY",
            allowInputToggle: true,
            widgetPositioning: {
                horizontal: 'left',
                vertical: 'bottom'
            }
        }).on('dp.change', function (e) {
            $('#deadlineTo').data("DateTimePicker").minDate(e.date);
        })
        $('#deadlineTo').datetimepicker({
            locale: "sk",
            format: "DD. MM. YYYY",
            allowInputToggle: true,
            widgetPositioning: {
                horizontal: 'left',
                vertical: 'bottom'
            }
        })
    });
</script>