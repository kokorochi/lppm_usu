{{--Get Old Value And Place It To VARIABLE--}}
{{--@if(--}}
{{--$errors->has('annotation') || old('annotation')--}}
{{--)--}}
{{--@php--}}
{{--$dedication_output_method->annotation = old('annotation');--}}
{{--@endphp--}}
{{--@endif--}}
{{--Get Old Value And Place It To VARIABLE--}}

<div class="row">
    <div class="col-md-12">
        <div class="panel rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Luaran (Produk/Barang)</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <form action="{{url($deleteUrl, $dedication->id) . '/output-product'}}" method="post"
                      enctype="multipart/form-data"
                      class="form-body form-horizontal form-bordered">
                    <div class="form-group">
                        @if($dedication_output_product->file_blueprint_ori !== null)
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unduh Blueprint</label>
                            <div class="col-sm-7 mb-10">
                                <div class="input-group">
                                    <input name="file_blueprint_ori" class="form-control input-sm"
                                           type="text" disabled
                                           value="{{ $dedication_output_product->file_blueprint_ori }}">
                                        <span class="input-group-btn">
                                            <a href="{{url('dedications', $dedication_output_product->id) . '/output-download/3/1' }}"
                                               class="btn btn-primary btn-sm" target="_blank">Unduh</a>
                                        </span>
                                </div>
                            </div>
                        @endif

                        @if($upd_mode !== 'approve')
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unggah Blueprint</label>
                            <div class="col-sm-7">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control input-sm" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-success btn-file">
                                        <span class="fileinput-new">Pilih file</span>
                                        <span class="fileinput-exists">Ubah</span>
                                        <input type="file" name="file_blueprint"
                                               value="">
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                       data-dismiss="fileinput">Hapus</a>
                                </div>
                                @if($errors->has('file_blueprint'))
                                    <label class="error" for="file_blueprint"
                                           style="display: inline-block;">
                                        {{ $errors->first('file_blueprint') }}
                                    </label>
                                @endif
                            </div>
                        @endif
                    </div> <!-- /.form-group -->

                    <div class="form-group">
                        @if($dedication_output_product->file_finished_good_ori !== null)
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unduh Barang Jadi</label>
                            <div class="col-sm-7 mb-10">
                                <div class="input-group">
                                    <input name="file_finished_good_ori" class="form-control input-sm"
                                           type="text" disabled
                                           value="{{ $dedication_output_product->file_finished_good_ori }}">
                                        <span class="input-group-btn">
                                            <a href="{{url('dedications', $dedication_output_product->id) . '/output-download/3/2' }}"
                                               class="btn btn-primary btn-sm" target="_blank">Unduh</a>
                                        </span>
                                </div>
                            </div>
                        @endif

                        @if($upd_mode !== 'approve')
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unggah Barang Jadi</label>
                            <div class="col-sm-7">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control input-sm" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                <span class="input-group-addon btn btn-success btn-file">
                                    <span class="fileinput-new">Pilih file</span>
                                    <span class="fileinput-exists">Ubah</span>
                                    <input type="file" name="file_finished_good"
                                           value="">
                                </span>
                                    <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                       data-dismiss="fileinput">Hapus</a>
                                </div>
                                @if($errors->has('file_finished_good'))
                                    <label class="error" for="file_finished_good"
                                           style="display: inline-block;">
                                        {{ $errors->first('file_finished_good') }}
                                    </label>
                                @endif
                            </div>
                        @endif
                    </div> <!-- /.form-group -->

                    <div class="form-group">
                        @if($dedication_output_product->file_working_pic_ori !== null)
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unduh Gambar Kerja</label>
                            <div class="col-sm-7 mb-10">
                                <div class="input-group">
                                    <input name="file_working_pic_ori" class="form-control input-sm"
                                           type="text" disabled
                                           value="{{ $dedication_output_product->file_working_pic_ori }}">
                                        <span class="input-group-btn">
                                            <a href="{{url('dedications', $dedication_output_product->id) . '/output-download/3/3' }}"
                                               class="btn btn-primary btn-sm" target="_blank">Unduh</a>
                                        </span>
                                </div>
                            </div>
                        @endif

                        @if($upd_mode !== 'approve')
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unggah Gambar Kerja</label>
                            <div class="col-sm-7">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control input-sm" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                <span class="input-group-addon btn btn-success btn-file">
                                    <span class="fileinput-new">Pilih file</span>
                                    <span class="fileinput-exists">Ubah</span>
                                    <input type="file" name="file_working_pic"
                                           value="">
                                </span>
                                    <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                       data-dismiss="fileinput">Hapus</a>
                                </div>
                                @if($errors->has('file_working_pic'))
                                    <label class="error" for="file_working_pic"
                                           style="display: inline-block;">
                                        {{ $errors->first('file_working_pic') }}
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