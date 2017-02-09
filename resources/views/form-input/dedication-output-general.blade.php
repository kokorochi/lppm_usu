{{--Get Old Value And Place It To VARIABLE--}}
@php($ctr = 0)

@php
    $olds = session()->getOldInput();

    if(!empty($olds))
    {
        foreach ($olds as $key => $old)
        {
            if(is_array($old))
            {
                foreach ($old as $key_2 => $old_2)
                {
                    $dedication_output_general = $dedication_output_generals->get($key_2);
                    if($dedication_output_general === null)
                    {
                        $dedication_output_generals->add(new \App\DedicationOutputGeneral());
                    }

                    $dedication_output_generals[$key_2][$key] = $old_2;
                }
            }
        }
    }
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="panel rounded shadow">
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
                <form action="{{url($deleteUrl, $dedication->id) . '/output-general'}}" method="post"
                      enctype="multipart/form-data"
                      class="form-body form-horizontal form-bordered">
                    @if($output_code === 'RL')
                        <div class="form-group">
                            @include('form-input.dedication-approve-revisiontext')
                        </div>
                        <hr>
                    @endif
                    <div class="dedication-general-wrapper">
                        @foreach($dedication_output_generals as $key => $dedication_output_general)
                            <div class="form-group">
                                <label for="status[{{$key}}]" class="col-sm-4 col-md-3 control-label">Jenis</label>
                                <div class="col-sm-7">
                                    <div class="rdio rdio-theme circle pull-left mr-10">
                                        <input id="radio-draft[{{$key}}]" value="draft" type="radio"
                                               name="status[{{$key}}]" {{$dedication_output_general->status === 'draft' ? 'checked' : ''}} {{$disabled}}>
                                        <label for="radio-draft[{{$key}}]">Draft</label>
                                    </div>
                                    <div class="rdio rdio-theme circle pull-left mr-10">
                                        <input id="radio-submitted[{{$key}}]" value="submitted" type="radio"
                                               name="status[{{$key}}]"{{$dedication_output_general->status === 'submitted' ? 'checked' : ''}} {{$disabled}}>
                                        <label for="radio-submitted[{{$key}}]">Submitted</label>
                                    </div>
                                    <div class="rdio rdio-theme circle pull-left mr-10">
                                        <input id="radio-accepted[{{$key}}]" value="accepted" type="radio"
                                               name="status[{{$key}}]"{{$dedication_output_general->status === 'accepted' ? 'checked' : ''}} {{$disabled}}>
                                        <label for="radio-accepted[{{$key}}]">Accepted</label>
                                    </div>
                                    <div class="rdio rdio-theme circle pull-left mr-10">
                                        <input id="radio-publish[{{$key}}]" value="publish" type="radio"
                                               name="status[{{$key}}]"{{$dedication_output_general->status === 'publish' ? 'checked' : ''}} {{$disabled}}>
                                        <label for="radio-publish[{{$key}}]">Publish</label>
                                    </div>
                                </div>
                                @if($dedication_output_general->file_name_ori !== null)
                                    @if($upd_mode !== 'approve' && $status_code !== 'PS')
                                        <div class="clearfix"></div>
                                        <label class="control-label col-sm-4 col-md-3">Hapus Luaran</label>
                                        <div class="col-sm-6 mb-10">
                                            <div class="ckbox ckbox-danger">
                                                <input name="delete_output[{{$key}}]" type="hidden" value="0">
                                                <input name="delete_output[{{$key}}]" id="checkbox-danger{{$key}}"
                                                       type="checkbox" value="1">
                                                <label for="checkbox-danger{{$key}}"></label>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="clearfix"></div>
                                    <label class="control-label col-sm-4 col-md-3">Unduh Luaran</label>
                                    <div class="col-sm-6 mb-10">
                                        <div class="input-group">
                                            <input name="file_name_ori[]" class="form-control input-sm"
                                                   type="text" disabled
                                                   value="{{ $dedication_output_general->file_name_ori }}">
                                            <span class="input-group-btn">
                                                <a href="{{url('dedications', $dedication_output_general->id) . '/output-download' }}"
                                                   class="btn btn-primary btn-sm" target="_blank">Unduh</a>
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <div class="clearfix"></div>
                                <label for="output_description[]" class="control-label col-sm-4 col-md-3">Deskripsi
                                    Luaran</label>
                                <div class="col-sm-6 mb-10">
                                    <input name="output_description[]" class="form-control input-sm" type="text"
                                           value="{{ $dedication_output_general->output_description }}" {{$disabled}}>
                                    @if($errors->has('output_description.' . $key))
                                        <label class="error" for="output_description[]"
                                               style="display: inline-block;">
                                            {{ $errors->first('output_description.' . $key) }}
                                        </label>
                                    @endif
                                </div>

                                <div class="clearfix"></div>
                                <label for="url_address[]" class="control-label col-sm-4 col-md-3">Url Address</label>
                                <div class="col-sm-6 mb-10">
                                    <input name="url_address[]" class="form-control input-sm" type="text"
                                           value="{{ $dedication_output_general->url_address }}" {{$disabled}}>
                                    @if($errors->has('url_address.' . $key))
                                        <label class="error" for="url_address[]"
                                               style="display: inline-block;">
                                            {{ $errors->first('url_address.' . $key) }}
                                        </label>
                                    @endif
                                </div>

                                @if($upd_mode !== 'approve' && $status_code !== 'PS' && $disabled == null)
                                    <div class="clearfix"></div>
                                    <label class="control-label col-sm-4 col-md-3">Unggah Luaran</label>
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

                                    @if($dedication_output_general->file_name_ori === null)
                                        <div class="col-sm-1">
                                            <a href="#" class="remove_field btn btn-sm btn-danger btn-stroke">
                                                <i class="fa fa-minus"></i>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div> <!-- /.form-group -->
                        @endforeach
                    </div>

                    @if($upd_mode !== 'approve' && $status_code !== 'PS' && $disabled == null)
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">

                        <div class="clearfix"></div>
                        <div class="form-footer">
                            <div class="col-sm-offset-4 col-md-offset-3">
                                <a id="add-dedication-general" href="#"
                                   class="add-dedication-general-button btn btn-success btn-stroke btn-slideright"><i
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