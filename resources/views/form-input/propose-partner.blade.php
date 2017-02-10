{{--Get Old Value And Place It To VARIABLE--}}
@php($ctr_old = 0)

@while(
$errors->has('partner_name.' . $ctr_old) || old('partner_name.' . $ctr_old) ||
$errors->has('partner_territory.' . $ctr_old) || old('partner_territory.' . $ctr_old) ||
$errors->has('partner_city.' . $ctr_old) || old('partner_city.' . $ctr_old) ||
$errors->has('partner_province.' . $ctr_old) || old('partner_province.' . $ctr_old) ||
$errors->has('partner_distance.' . $ctr_old) || old('partner_distance.' . $ctr_old)
)
    @php
        $dedication_partner = new \App\Dedication_partner();
        $dedication_partner['name'] = old('partner_name.' . $ctr_old);
        $dedication_partner['territory'] = old('partner_territory.' . $ctr_old);
        $dedication_partner['city'] = old('partner_city.' . $ctr_old);
        $dedication_partner['province'] = old('partner_province.' . $ctr_old);
        $dedication_partner['distance'] = old('partner_distance.' . $ctr_old);
        if($propose_relation->dedication_partners->get($ctr_old) === null){
            $propose_relation->dedication_partners->add($dedication_partner);
        }else{
            $propose_relation->dedication_partners[$ctr_old] = $dedication_partner;
        }
        $ctr_old++;
    @endphp
@endwhile
{{--Get Old Value And Place It To VARIABLE--}}

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Mitra Pengabdian</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <div class="form-body form-horizontal form-bordered">
                    <div class="partner-wrapper">
                        @foreach($propose_relation->dedication_partners as $key => $dedication_partner)
                            <div class="form-group">
                                <label for="partner_name[]" class="col-sm-4 col-md-3 control-label">Nama Mitra</label>
                                <div class="col-sm-7">
                                    <input name="partner_name[]" class="form-control input-sm mb-10" type="text"
                                           value="{{ $dedication_partner->name }}" {{$disabled}}>
                                    @if($errors->has('partner_name.' . $key))
                                        <label class="error" for="partner_name[]" style="display: inline-block;">
                                            {{ $errors->first('partner_name.' . $key) }}
                                        </label>
                                    @endif
                                </div><!-- /.col-sm-7 -->

                                <label for="partner_territory[]" class="col-sm-4 col-md-3 control-label">Wilayah Mitra
                                    (Desa/Kecamatan)</label>
                                <div class="col-sm-7">
                                    <input name="partner_territory[]" class="form-control input-sm mb-10" type="text"
                                           value="{{ $dedication_partner->territory }}" {{$disabled}}>
                                    @if($errors->has('partner_territory.' . $key))
                                        <label class="error" for="partner_name[]" style="display: inline-block;">
                                            {{ $errors->first('partner_territory.' . $key) }}
                                        </label>
                                    @endif
                                </div><!-- /.col-sm-7 -->

                                <div class="clearfix"></div>
                                <label for="partner_city[]"
                                       class="col-sm-4 col-md-3 control-label">Kabupaten/Kota</label>
                                <div class="col-sm-7">
                                    <input name="partner_city[]" class="form-control input-sm mb-10" type="text"
                                           value="{{ $dedication_partner->city }}" {{$disabled}}>
                                    @if($errors->has('partner_city.' . $key))
                                        <label class="error" for="partner_name[]" style="display: inline-block;">
                                            {{ $errors->first('partner_city.' . $key) }}
                                        </label>
                                    @endif
                                </div><!-- /.col-sm-7 -->

                                <label for="partner_province[]" class="col-sm-4 col-md-3 control-label">Provinsi</label>
                                <div class="col-sm-7">
                                    <input name="partner_province[]" class="form-control input-sm mb-10" type="text"
                                           value="{{ $dedication_partner->province }}" {{$disabled}}>
                                    @if($errors->has('partner_province.' . $key))
                                        <label class="error" for="partner_name[]" style="display: inline-block;">
                                            {{ $errors->first('partner_province.' . $key) }}
                                        </label>
                                    @endif
                                </div><!-- /.col-sm-7 -->

                                <label for="partner_distance[]" class="col-sm-4 col-md-3 control-label">Jarak PT ke
                                    lokasi mitra (KM)</label>
                                <div class="col-sm-7">
                                    <input name="partner_distance[]" class="form-control input-sm mb-10" type="text"
                                           maxlength="2" data-inputmask="'alias': 'numeric', 'rightAlign': false"
                                           value="{{ $dedication_partner->distance }}" {{$disabled}}>
                                    @if($errors->has('partner_distance.' . $key))
                                        <label class="error" for="partner_name[]" style="display: inline-block;">
                                            {{ $errors->first('partner_distance.' . $key) }}
                                        </label>
                                    @endif
                                </div><!-- /.col-sm-7 -->

                                @if($disabled === null)
                                    <div class="clearfix"></div>
                                    <label class="control-label col-sm-4 col-md-3">Unggah Surat Kesediaan
                                        Kerjasama</label>
                                    <div class="col-sm-7">
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename">{{$dedication_partner->file_partner_contract}}</span>
                                            </div>
                                        <span class="input-group-addon btn btn-success btn-file">
                                            <span class="fileinput-new">Select file</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="file_partner_contract[]"
                                                   value="{{$dedication_partner->file_partner_contract}}">
                                        </span>
                                            <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                               data-dismiss="fileinput">Remove</a>
                                        </div>
                                        @if($errors->has('file_partner_contract.' . $key))
                                            <label class="error" for="file_partner_contract[]"
                                                   style="display: inline-block;">
                                                {{ $errors->first('file_partner_contract.' . $key) }}
                                            </label>
                                        @endif
                                    </div>
                                @else
                                    <div class="clearfix"></div>
                                    <label class="control-label col-sm-4 col-md-3">Unduh Surat Kesediaan
                                        Kerjasama</label>
                                    <div class="col-sm-7 mb-10">
                                        <div class="input-group">
                                            <input name="file_partner_contract[]" class="form-control input-sm"
                                                   type="text" disabled
                                                   value="{{ $dedication_partner->file_partner_contract_ori }}">
                                            <span class="input-group-btn">
                                                <a href="{{url('proposes', $dedication_partner->id) . '/download/1' }}"
                                                   class="btn btn-primary btn-sm">Unduh</a>
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                @if($disabled === null)
                                    <div class="col-sm-offset-4 col-md-offset-3 col-sm-7">
                                        <a href="#"
                                           class="remove_field btn btn-sm btn-danger btn-stroke btn-slideright">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </div>
                                @endif
                            </div><!-- /.form-group -->
                        @endforeach
                    </div>
                </div><!-- /.form-body -->

                @if($disabled === null)
                    <div class="form-footer">
                        <div class="col-sm-offset-4 col-md-offset-3">
                            <a id="add-partner" href="#"
                               class="add-partner-button btn btn-success btn-stroke btn-slideright"><i
                                        class="fa fa-plus"></i></a>
                        </div><!-- /.col-sm-offset-3 -->
                    </div><!-- /.form-footer -->
                @endif

            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-md-12 -->
</div><!-- /.row -->