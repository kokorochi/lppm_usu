{{--Get Old Value And Place It To VARIABLE--}}
@php($ctr = 0)

@php
    while($errors->has('file_name.' . $ctr) || old('file_name.' . $ctr))
    {
        $dedication_output_service = $dedication_output_services->get($ctr);
        if($dedication_output_service === null)
        {
            $dedication_output_service->file_name = old('file_name.' . $ctr);
            $dedication_output_services->add($dedication_output_service);
        }else
        {
            $dedication_output_services[$ctr]->file_name = old('file_name.' . $ctr);
        }

        $ctr++;
    }
@endphp
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
        <div class="panel rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Luaran (Jasa)</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <form action="{{url($deleteUrl, $dedication->id) . '/output-service'}}" method="post"
                      enctype="multipart/form-data"
                      class="form-body form-horizontal form-bordered">
                    <div class="dedication-service-wrapper">
                        @foreach($dedication_output_services as $key => $dedication_output_service)
                            <div class="form-group">
                                @if($dedication_output_service->file_name_ori !== null)
                                    <div class="clearfix"></div>
                                    <label class="control-label col-sm-4 col-md-3">Unduh Dokumentasi</label>
                                    <div class="col-sm-6 mb-10">
                                        <div class="input-group">
                                            <input name="file_name_ori[]" class="form-control input-sm"
                                                   type="text" disabled
                                                   value="{{ $dedication_output_service->file_name_ori }}">
                                                        <span class="input-group-btn">
                                                            <a href="{{url('dedications', $dedication_output_service->id) . '/output-download/1' }}"
                                                               class="btn btn-primary btn-sm" target="_blank">Unduh</a>
                                                        </span>
                                        </div>
                                    </div>
                                @endif

                                @if($upd_mode !== 'approve' && $status_code !== 'PS')
                                    <div class="clearfix"></div>
                                    <label class="control-label col-sm-4 col-md-3">Unggah Dokumentasi</label>
                                    <div class="col-sm-6">
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control input-sm" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                            <span class="input-group-addon btn btn-success btn-file">
                                                <span class="fileinput-new">Pilih file</span>
                                                <span class="fileinput-exists">Ubah</span>
                                                <input type="file" name="file_name[]"
                                                       value="">
                                            </span>
                                            <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                               data-dismiss="fileinput">Hapus</a>
                                        </div>
                                        @if($errors->has('file_name.' . $key))
                                            <label class="error" for="file_name[]"
                                                   style="display: inline-block;">
                                                {{ $errors->first('file_name.' . $key) }}
                                            </label>
                                        @endif
                                    </div>

                                    <div class="col-sm-1">
                                        <a href="#" class="remove_field btn btn-sm btn-danger btn-stroke">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </div>
                                @endif
                            </div> <!-- /.form-group -->
                        @endforeach
                    </div>

                    @if($upd_mode !== 'approve' && $status_code !== 'PS')
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">

                        <div class="clearfix"></div>
                        <div class="form-footer">
                            <div class="col-sm-offset-4 col-md-offset-3">
                                <a id="add-dedication-service" href="#"
                                   class="add-dedication-service-button btn btn-success btn-stroke btn-slideright"><i
                                            class="fa fa-plus"></i></a>
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