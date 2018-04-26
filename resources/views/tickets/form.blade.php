<div class="form-group">
    {!! Form::label('title', __('Tiêu đề') , ['class' => 'control-label required']) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-inline">
    <div class="form-group col-sm-4 removeleft">
        {!! Form::label('source_id', __('Nguồn gốc') , ['class' => 'control-label required']) !!}
        {!! Form::select('source_id', $sources, null, ['placeholder' => '', 'id'=>'source_id', 'name'=>'source_id','class'=>'form-control', 'style' => 'width:100%']) !!}
    </div>

    <div class="form-group  col-sm-4 removeleft">
        {!! Form::label('director_id', __('Giám đốc khối (nơi xảy ra SKPH)'), ['class' => 'control-label required']) !!}
        {!! Form::select('director_id', $directors, null, ['placeholder' => '', 'id'=>'director_id', 'name'=>'director_id','class'=>'form-control', 'style' => 'width:100%']) !!}
    </div>

    <div class="form-group col-sm-4 removeleft removeright">
        {!! Form::label('what', __('Cái gì đã xảy ra ?'), ['class' => 'control-label required']) !!}
        {!! Form::text('what', null, ['class' => 'form-control']) !!}
    </div>
</div>


<div class="form-inline">
    <div class="form-group col-sm-4 removeleft">
        {!! Form::label('why', __('Tại sao đây là một vấn đề ?'), ['class' => 'control-label required']) !!}
        {!! Form::text('why', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-4 removeleft">
        {!! Form::label('who', __('Ai phát hiện ra ?'), ['class' => 'control-label required']) !!}
        {!! Form::text('who', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-4 removeleft removeright">
        {!! Form::label('when', __('Nó xảy ra khi nào ?'), ['class' => 'control-label required']) !!}
        {!! Form::text('when',
        isset($ticket->when) ? date('m-d-Y h:i A', strtotime($ticket->when)) : null,
          ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-inline">
    <div class="form-group col-sm-4 removeleft">
        {!! Form::label('where', __('Phát hiện ra ở đâu ?'), ['class' => 'control-label required']) !!}
        {!! Form::text('where', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-4 removeleft">
        {!! Form::label('how_1', __('Bằng cách nào ?'), ['class' => 'control-label required']) !!}
        {!! Form::text('how_1', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-sm-4 removeleft removeright">
        {!! Form::label('how_2', __('Có bao nhiêu sự không phù hợp'), ['class' => 'control-label required']) !!}
        {!! Form::text('how_2', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-inline">
    <div class="form-group">
        {{ Form::label('image_path', __('Ảnh'), ['class' => 'control-label']) }}
        {!! Form::file('image_path',  null, ['class' => 'form-control']) !!}
    </div>
</div>
<br>
{!! Form::submit($submitButtonText, ['class' => 'btn btn-primary', 'style' => 'width:100%']) !!}

@push('scripts')
    <script type="text/javascript">
        $("#source_id").select2({
            placeholder: "Chọn nguồn gốc",
            allowClear: true
        });
    </script>
    <script type="text/javascript">
        $("#director_id").select2({
            placeholder: "Chọn giám đốc khối",
            allowClear: true
        });
    </script>

    <script type="text/javascript">
        $(function () {
            $('#when').datetimepicker(
                {
                    useCurrent: false,
                }
            );
        });
    </script>
@endpush