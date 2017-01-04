{{--Get Old Value And Place It To VARIABLE--}}
{{--@if(--}}
{{--$errors->has('final_amount') || old('final_amount')--}}
{{--)--}}
{{--@php--}}
{{--$propose->final_amount = old('final_amount');--}}
{{--@endphp--}}
{{--@endif--}}
{{--Get Old Value And Place It To VARIABLE--}}

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Laporan Kemajuan</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <div class="form-body form-horizontal form-bordered">
                    @if($dedication->file_progress_activity !== null)
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-md-3">Unduh Laporan Kemajuan (Kegiatan)</label>
                            <div class="col-sm-7 mb-10">
                                <div class="input-group">
                                    <input name="file_progress_activity" class="form-control input-sm"
                                           type="text" disabled
                                           value="{{ $dedication->file_progress_activity_ori }}">
                                        <span class="input-group-btn">
                                            <a href="{{url($deleteUrl, $dedication->id) . '/download/1' }}"
                                               class="btn btn-primary btn-sm">Unduh</a>
                                        </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($upd_mode !== 'review')
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-md-3">Unggah Laporan Kemajuan (Kegiatan)</label>
                            <div class="col-sm-7">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control input-sm" data-trigger="fileinput"><i
                                                class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                class="fileinput-filename"></span></div>
                                                <span class="input-group-addon btn btn-success btn-file">
                                                    <span class="fileinput-new">Pilih file</span>
                                                    <span class="fileinput-exists">Ubah</span>
                                                    <input type="file" name="file_progress_activity">
                                                </span>
                                    <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                       data-dismiss="fileinput">Hapus</a>
                                </div>
                                @if($errors->has('file_progress_activity'))
                                    <label class="error" for="file_progress_activity" style="display: inline-block;">
                                        {{ $errors->first('file_progress_activity') }}
                                    </label>
                                @endif
                            </div>
                        </div><!-- /.form-group -->
                    @endif

                    @if($dedication->file_progress_budgets !== null)
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-md-3">Unduh Laporan Kemajuan (Anggaran)</label>
                            <div class="col-sm-7 mb-10">
                                <div class="input-group">
                                    <input name="file_progress_budgets" class="form-control input-sm"
                                           type="text" disabled
                                           value="{{ $dedication->file_progress_budgets_ori }}">
                                        <span class="input-group-btn">
                                            <a href="{{url($deleteUrl, $dedication->id) . '/download/2' }}"
                                               class="btn btn-primary btn-sm">Unduh</a>
                                        </span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($upd_mode !== 'review')
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-md-3">Unggah Laporan Kemajuan (Anggaran)</label>
                            <div class="col-sm-7">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control input-sm" data-trigger="fileinput"><i
                                                class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                class="fileinput-filename"></span></div>
                                            <span class="input-group-addon btn btn-success btn-file">
                                                <span class="fileinput-new">Pilih file</span>
                                                <span class="fileinput-exists">Ubah</span>
                                                <input type="file" name="file_progress_budgets">
                                            </span>
                                    <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                       data-dismiss="fileinput">Hapus</a>
                                </div>
                                @if($errors->has('file_progress_budgets'))
                                    <label class="error" for="file_progress_budgets" style="display: inline-block;">
                                        {{ $errors->first('file_progress_budgets') }}
                                    </label>
                                @endif
                            </div>
                        </div><!-- /.form-group -->
                    @endif
                </div><!-- /.form-body -->

                @if($upd_mode !== 'review')
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">

                    <div class="form-footer">
                        <div class="col-sm-offset-4 col-md-offset-3">
                            <a href="{{url($deleteUrl)}}" class="btn btn-teal btn-slideright">Kembali</a>
                            <button type="submit" class="btn btn-success btn-slideright">Update Laporan Kemajuan
                            </button>
                        </div><!-- /.col-sm-offset-3 -->
                    </div><!-- /.form-footer -->
                @endif
            </div>
        </div>
    </div>
</div>