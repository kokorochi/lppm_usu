{{--Get Old Value And Place It To VARIABLE--}}
@if(
$errors->has('title') || old('title') ||
$errors->has('book_year') || old('book_year') ||
$errors->has('publisher') || old('publisher') ||
$errors->has('isbn') || old('isbn')
)
    @php
        $dedication_output_guidebook->title = old('title');
        $dedication_output_guidebook->book_year = old('book_year');
        $dedication_output_guidebook->publisher = old('publisher');
        $dedication_output_guidebook->isbn = old('isbn');
    @endphp
@endif
{{--Get Old Value And Place It To VARIABLE--}}

<div class="row">
    <div class="col-md-12">
        <div class="panel rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Luaran (Buku Panduan)</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <form action="{{url($deleteUrl, $dedication->id) . '/output-guidebook'}}" method="post"
                      enctype="multipart/form-data"
                      class="form-body form-horizontal form-bordered">
                    <div class="form-group">
                        <label for="title" class="col-sm-4 col-md-3 control-label">Judul Buku</label>
                        <div class="col-sm-7">
                            <input name="title" class="form-control input-sm" type="text"
                                   value="{{ $dedication_output_guidebook->title }}" {{$upd_mode !== 'approve' && $status_code !== 'PS' ? '' : 'disabled'}}>
                            @if($errors->has('title'))
                                <label class="error" for="title" style="display: inline-block;">
                                    {{ $errors->first('title') }}
                                </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="book_year" class="col-sm-4 col-md-3 control-label">Tahun Buku</label>
                        <div class="col-sm-7">
                            <input name="book_year" class="form-control input-sm" type="text"
                                   value="{{ $dedication_output_guidebook->book_year }}" {{$upd_mode !== 'approve' && $status_code !== 'PS' ? '' : 'disabled'}}>
                            @if($errors->has('book_year'))
                                <label class="error" for="book_year" style="display: inline-block;">
                                    {{ $errors->first('book_year') }}
                                </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="publisher" class="col-sm-4 col-md-3 control-label">Penerbit</label>
                        <div class="col-sm-7">
                            <input name="publisher" class="form-control input-sm" type="text"
                                   value="{{ $dedication_output_guidebook->publisher }}" {{$upd_mode !== 'approve' && $status_code !== 'PS' ? '' : 'disabled'}}>
                            @if($errors->has('publisher'))
                                <label class="error" for="publisher" style="display: inline-block;">
                                    {{ $errors->first('publisher') }}
                                </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="isbn" class="col-sm-4 col-md-3 control-label">ISBN</label>
                        <div class="col-sm-7">
                            <input name="isbn" class="form-control input-sm" type="text"
                                   value="{{ $dedication_output_guidebook->isbn }}" {{$upd_mode !== 'approve' && $status_code !== 'PS' ? '' : 'disabled'}}>
                            @if($errors->has('isbn'))
                                <label class="error" for="isbn" style="display: inline-block;">
                                    {{ $errors->first('isbn') }}
                                </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        @if($dedication_output_guidebook->file_cover_ori !== null)
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unduh Sampul Depan</label>
                            <div class="col-sm-7 mb-10">
                                <div class="input-group">
                                    <input name="file_cover_ori" class="form-control input-sm"
                                           type="text" disabled
                                           value="{{ $dedication_output_guidebook->file_cover_ori }}">
                                                        <span class="input-group-btn">
                                                            <a href="{{url('dedications', $dedication_output_guidebook->id) . '/output-download/5/1' }}"
                                                               class="btn btn-primary btn-sm" target="_blank">Unduh</a>
                                                        </span>
                                </div>
                            </div>
                        @endif

                        @if($upd_mode !== 'approve' && $status_code !== 'PS')
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unggah Sampul Depan</label>
                            <div class="col-sm-7">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control input-sm" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                <span class="input-group-addon btn btn-success btn-file">
                                    <span class="fileinput-new">Pilih file</span>
                                    <span class="fileinput-exists">Ubah</span>
                                    <input type="file" name="file_cover"
                                           value="">
                                </span>
                                    <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                       data-dismiss="fileinput">Hapus</a>
                                </div>
                            </div>
                        @endif
                    </div> <!-- /.form-group -->

                    <div class="form-group">
                        @if($dedication_output_guidebook->file_back_ori !== null)
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unduh Sampul Belakang</label>
                            <div class="col-sm-7 mb-10">
                                <div class="input-group">
                                    <input name="file_back_ori" class="form-control input-sm"
                                           type="text" disabled
                                           value="{{ $dedication_output_guidebook->file_back_ori }}">
                                    <span class="input-group-btn">
                                        <a href="{{url('dedications', $dedication_output_guidebook->id) . '/output-download/5/2' }}"
                                           class="btn btn-primary btn-sm" target="_blank">Unduh</a>
                                    </span>
                                </div>
                            </div>
                        @endif

                        @if($upd_mode !== 'approve' && $status_code !== 'PS')
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unggah Sampul Belakang</label>
                            <div class="col-sm-7">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control input-sm" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                <span class="input-group-addon btn btn-success btn-file">
                                    <span class="fileinput-new">Pilih file</span>
                                    <span class="fileinput-exists">Ubah</span>
                                    <input type="file" name="file_back"
                                           value="">
                                </span>
                                    <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                       data-dismiss="fileinput">Hapus</a>
                                </div>
                            </div>
                        @endif
                    </div> <!-- /.form-group -->

                    <div class="form-group">
                        @if($dedication_output_guidebook->file_table_of_contents_ori !== null)
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unduh Daftar Isi</label>
                            <div class="col-sm-7 mb-10">
                                <div class="input-group">
                                    <input name="file_table_of_contents_ori" class="form-control input-sm"
                                           type="text" disabled
                                           value="{{ $dedication_output_guidebook->file_table_of_contents_ori }}">
                                                        <span class="input-group-btn">
                                                            <a href="{{url('dedications', $dedication_output_guidebook->id) . '/output-download/5/3' }}"
                                                               class="btn btn-primary btn-sm" target="_blank">Unduh</a>
                                                        </span>
                                </div>
                            </div>
                        @endif

                        @if($upd_mode !== 'approve' && $status_code !== 'PS')
                            <div class="clearfix"></div>
                            <label class="control-label col-sm-4 col-md-3">Unggah Daftar Isi</label>
                            <div class="col-sm-7">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control input-sm" data-trigger="fileinput">
                                        <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                        <span class="fileinput-filename"></span>
                                    </div>
                                    <span class="input-group-addon btn btn-success btn-file">
                                        <span class="fileinput-new">Pilih file</span>
                                        <span class="fileinput-exists">Ubah</span>
                                        <input type="file" name="file_table_of_contents"
                                               value="">
                                    </span>
                                    <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                       data-dismiss="fileinput">Hapus</a>
                                </div>
                            </div>
                        @endif
                    </div> <!-- /.form-group -->

                    @if($upd_mode !== 'approve' && $status_code !== 'PS')
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