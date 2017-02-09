<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Unggah Usulan</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <div class="form-body form-horizontal form-bordered">
                    @if($disabled === 'disabled')
                        @if($propose_relation->propose->file_propose !== null)
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3">Unduh Usulan</label>
                                <div class="col-sm-7 mb-10">
                                    <div class="input-group">
                                        <input name="file_partner_contract[]" class="form-control input-sm"
                                               type="text" disabled
                                               value="{{ $propose_relation->propose->file_propose_ori }}">
                                        <span class="input-group-btn">
                                        {{--<button type="button" class="btn btn-default">Go!</button>--}}
                                            <a href="{{url('proposes', $propose_relation->propose->id) . '/download/2' }}"
                                               class="btn btn-primary btn-sm">Unduh</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($disable_upload === false)
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3">Unggah Usulan</label>
                                <div class="col-sm-7">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control input-sm" data-trigger="fileinput"><i
                                                    class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                    class="fileinput-filename"></span></div>
                                        <span class="input-group-addon btn btn-success btn-file">
                                            <span class="fileinput-new">Pilih file</span>
                                            <span class="fileinput-exists">Ubah</span>
                                            <input type="file" name="file_propose">
                                        </span>
                                        <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                           data-dismiss="fileinput">Hapus</a>
                                    </div>
                                    @if($errors->has('file_propose'))
                                        <label class="error" for="file_propose" style="display: inline-block;">
                                            {{ $errors->first('file_propose') }}
                                        </label>
                                    @endif
                                </div>
                            </div><!-- /.form-group -->
                        @endif
                    @endif
                </div><!-- /.form-body -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-md-12 -->
</div><!-- /.row -->