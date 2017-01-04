{{--Get Old Value And Place It To VARIABLE--}}
@if(
$errors->has('final_amount') || old('final_amount')
)
    @php
        $propose->final_amount = old('final_amount');
    @endphp
@endif
{{--Get Old Value And Place It To VARIABLE--}}

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Perbaikan Proposal</h3>
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
                        <label for="final_amount" class="col-sm-4 col-md-3 control-label">Jumlah Dana
                            (Perbaikan)</label>
                        <div class="col-sm-7">
                            <input name="final_amount" class="form-control input-sm" type="text"
                                   data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'rightAlign': false"
                                   value="{{$propose->final_amount}}" {{$disable_final_amount}}>
                            @if($errors->has('final_amount'))
                                <label class="error" for="final_amount" style="display: inline-block;">
                                    {{ $errors->first('final_amount') }}
                                </label>
                            @endif
                        </div>
                    </div> <!-- /.form-group -->
                    @if($status_code === 'PU')
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-md-3">Unggah Usulan (Perbaikan)</label>
                            <div class="col-sm-7">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control input-sm" data-trigger="fileinput"><i
                                                class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                class="fileinput-filename"></span></div>
                                            <span class="input-group-addon btn btn-success btn-file">
                                                <span class="fileinput-new">Select file</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="file_propose_final">
                                            </span>
                                    <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                       data-dismiss="fileinput">Remove</a>
                                </div>
                                @if($errors->has('file_propose_final'))
                                    <label class="error" for="file_propose_final" style="display: inline-block;">
                                        {{ $errors->first('file_propose_final') }}
                                    </label>
                                @endif
                            </div>
                        </div><!-- /.form-group -->
                    @endif
                    @if($propose->file_propose_final !== null)
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-md-3">Unduh Usulan</label>
                            <div class="col-sm-7 mb-10">
                                <div class="input-group">
                                    <input name="file_propose_final" class="form-control input-sm"
                                           type="text" disabled
                                           value="{{ $propose->file_propose_final_ori }}">
                                            <span class="input-group-btn">
                                            {{--<button type="button" class="btn btn-default">Go!</button>--}}
                                                <a href="{{url('proposes', $propose->id) . '/download/3' }}"
                                                   class="btn btn-primary btn-sm">Unduh</a>
                                            </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div><!-- /.form-body -->
            </div>
        </div>
    </div>
</div>