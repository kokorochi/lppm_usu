<div class="row">
    <div class="col-md-12">
        <div class="panel rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Perbaikan</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <div class="form-body form-horizontal form-bordered">
                    <div class="form-group">
                        <label for="title" class="col-sm-4 col-md-3 control-label">Alasan Perbaikan</label>
                        <div class="col-sm-7">
                        <textarea name="revision_text" class="form-control input-sm"
                                  rows="3" {{$upd_mode === 'output' ? "disabled" : ""}}>{{$dedication_output_revision->revision_text}}</textarea>
                            @if($errors->has('revision_text'))
                                <label class="error" for="revision_text" style="display: inline-block;">
                                    {{ $errors->first('revision_text') }}
                                </label>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>