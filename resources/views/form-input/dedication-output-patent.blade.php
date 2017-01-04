{{--Get Old Value And Place It To VARIABLE--}}
@if(
$errors->has('patent_no') || old('patent_no') ||
$errors->has('patent_year') || old('patent_year') ||
$errors->has('patent_owner_name') || old('patent_owner_name') ||
$errors->has('patent_type') || old('patent_type')
)
    @php
        $dedication_output_patent->patent_no = old('patent_no');
        $dedication_output_patent->patent_year = old('patent_year');
        $dedication_output_patent->patent_owner_name = old('patent_owner_name');
        $dedication_output_patent->patent_type = old('patent_type');
    @endphp
@endif
{{--Get Old Value And Place It To VARIABLE--}}

<div class="row">
    <div class="col-md-12">
        <div class="panel rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Luaran (Paten)</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <form action="{{url($deleteUrl, $dedication->id) . '/output-patent'}}" method="post"
                      enctype="multipart/form-data"
                      class="form-body form-horizontal form-bordered">
                    <div class="form-group">
                        <label for="patent_no" class="col-sm-4 col-md-3 control-label">Nomor SK Paten</label>
                        <div class="col-sm-7">
                            <input name="patent_no" class="form-control input-sm" type="text"
                                   value="{{ $dedication_output_patent->patent_no }}" {{$upd_mode !== 'approve' ? '' : 'disabled'}}>
                            @if($errors->has('patent_no'))
                                <label class="error" for="patent_no" style="display: inline-block;">
                                    {{ $errors->first('patent_no') }}
                                </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="patent_year" class="col-sm-4 col-md-3 control-label">Tahun Paten</label>
                        <div class="col-sm-7">
                            <input name="patent_year" class="form-control input-sm" type="text"
                                   value="{{ $dedication_output_patent->patent_year }}" {{$upd_mode !== 'approve' ? '' : 'disabled'}}>
                            @if($errors->has('patent_year'))
                                <label class="error" for="patent_year" style="display: inline-block;">
                                    {{ $errors->first('patent_year') }}
                                </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="patent_owner_name" class="col-sm-4 col-md-3 control-label">Nama Pemilik
                            Paten</label>
                        <div class="col-sm-7">
                            <input name="patent_owner_name" class="form-control input-sm" type="text"
                                   value="{{ $dedication_output_patent->patent_owner_name }}" {{$upd_mode !== 'approve' ? '' : 'disabled'}}>
                            @if($errors->has('patent_owner_name'))
                                <label class="error" for="patent_owner_name" style="display: inline-block;">
                                    {{ $errors->first('patent_owner_name') }}
                                </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="patent_type" class="col-sm-4 col-md-3 control-label">Jenis Paten</label>
                        <div class="col-sm-7">
                            <input name="patent_type" class="form-control input-sm" type="text"
                                   value="{{ $dedication_output_patent->patent_type }}" {{$upd_mode !== 'approve' ? '' : 'disabled'}}>
                            @if($errors->has('patent_type'))
                                <label class="error" for="patent_type" style="display: inline-block;">
                                    {{ $errors->first('patent_type') }}
                                </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        @if($dedication_output_patent->file_patent_ori !== null)
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unduh Sertifikat Paten</label>
                            <div class="col-sm-7 mb-10">
                                <div class="input-group">
                                    <input name="file_patent_ori" class="form-control input-sm"
                                           type="text" disabled
                                           value="{{ $dedication_output_patent->file_patent_ori }}">
                                                        <span class="input-group-btn">
                                                            <a href="{{url('dedications', $dedication_output_patent->id) . '/output-download/4' }}"
                                                               class="btn btn-primary btn-sm" target="_blank">Unduh</a>
                                                        </span>
                                </div>
                            </div>
                        @endif

                        @if($upd_mode !== 'approve')
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unggah Sertifikat Paten</label>
                            <div class="col-sm-7">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control input-sm" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                            <span class="input-group-addon btn btn-success btn-file">
                                                <span class="fileinput-new">Pilh file</span>
                                                <span class="fileinput-exists">Ubah</span>
                                                <input type="file" name="file_patent"
                                                       value="">
                                            </span>
                                    <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                       data-dismiss="fileinput">Hapus</a>
                                </div>
                                @if($errors->has('file_patent'))
                                    <label class="error" for="file_patent"
                                           style="display: inline-block;">
                                        {{ $errors->first('file_patent') }}
                                    </label>
                                @endif
                            </div>
                        @endif
                    </div> <!-- /.form-group -->

                    @if($upd_mode !== 'approve')
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">

                        <div class="clearfix"></div>
                        <div class="form-footer">
                            <div class="col-sm-offset-4 col-md-offset-3">
                                <a href="{{url($deleteUrl)}}" class="btn btn-teal btn-slideright">Kembali</a>
                                <button type="submit" class="btn btn-success btn-slideright">Simpan</button>
                            </div><!-- /.col-sm-offset-3 -->
                        </div><!-- /.form-footer -->
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>