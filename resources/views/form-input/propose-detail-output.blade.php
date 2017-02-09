@php
    $ctr_old = 0;
    while(
    $errors->has('output_type.' . $ctr_old) || old('output_type.' . $ctr_old)
    )
    {
        $propose_output_type = new \App\ProposeOutputType();
        $propose_output_type->output_type_id = old('output_type.' . $ctr_old);

        if($propose_relation->propose_output_types->get($ctr_old) === null){
            $propose_relation->propose_output_types->add($propose_output_type);
        }else{
            $propose_relation->propose_output_types[$ctr_old] = $propose_output_type;
        }
        $ctr_old++;
    }
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Luaran</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <div class="form-body form-horizontal form-bordered">
                    <div class="output-wrapper">
                        @foreach($propose_relation->propose_output_types as $propose_output_type)
                            <div class="form-group">
                                <label for="output_type" class="col-sm-4 col-md-3 control-label">Luaran yang
                                    dihasilkan</label>
                                <div class="col-sm-7">
                                    <select name="output_type[]" class="form-control input-sm" {{$disabled}}>
                                        @foreach($propose_relation->output_types as $output_type)
                                            <option value="{{$output_type->id}}" {{$propose_output_type->output_type_id == $output_type->id ? 'selected' : null}}>{{$output_type->output_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div><!-- /.form-group -->
                        @endforeach
                    </div><!-- /.output-wrapper -->
                </div><!-- /.form-body -->
            </div>
        </div>
    </div>
</div>