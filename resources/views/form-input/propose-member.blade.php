{{--Get Old Value And Place It To VARIABLE--}}
@php($ctr_old = 0)

@while(
$errors->has('member_display.' . $ctr_old) || old('member_display.' . $ctr_old) ||
$errors->has('member_nidn.' . $ctr_old) || old('member_nidn.' . $ctr_old) ||
$errors->has('member_areas_of_expertise.' . $ctr_old) || old('member_areas_of_expertise.' . $ctr_old) ||
$errors->has('external' . $ctr_old) || old('external' . $ctr_old) ||
$errors->has('external_name.' . $ctr_old) || old('external_name.' . $ctr_old) ||
$errors->has('external_affiliation.' . $ctr_old) || old('external_affiliation.' . $ctr_old)
)
    @php
        $member = new \App\Member;
        $member['external'] = old('external' . $ctr_old);
        $member['external_name'] = old('external_name.' . $ctr_old);
        $member['external_affiliation'] = old('external_affiliation.' . $ctr_old);
        $member['member_display'] = old('member_display.' . $ctr_old);
        $member['member_nidn'] = old('member_nidn.' . $ctr_old);
        $member['areas_of_expertise'] = old('member_areas_of_expertise.' . $ctr_old);
        if($propose_relation->members->get($ctr_old) === null){
            $propose_relation->members->add($member);
        }else{
            $propose_relation->members[$ctr_old] = $member;
        }
        $ctr_old++;
    @endphp
@endwhile

@if($errors->has('areas_of_expertise') || old('areas_of_expertise'))
    @php($propose_relation->propose->areas_of_expertise = old('areas_of_expertise'))
@endif
{{--Get Old Value And Place It To VARIABLE--}}

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Anggota Pengabdian</h3>
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
                        <label for="full_name" class="col-sm-4 col-md-3 control-label">Ketua</label>
                        <div class="col-sm-7">
                            <input name="full_name" class="form-control input-sm mb-15" type="text"
                                   value="{{$propose_relation->lecturer->full_name}}" disabled>
                        </div>
                        <div class="clearfix"></div>
                        <label for="areas_of_expertise" class="col-sm-4 col-md-3 control-label">Bidang Keahlian</label>
                        <div class="col-sm-7">
                            <input name="areas_of_expertise" type="text"
                                   class="form-control input-sm"
                                   value="{{$propose_relation->propose->areas_of_expertise}}" {{$disabled}} />
                            @if($errors->has('areas_of_expertise'))
                                <label class="error" for="areas_of_expertise" style="display: inline-block;">
                                    {{$errors->first('areas_of_expertise')}}
                                </label>
                            @endif
                        </div>
                    </div><!-- /.form-group -->

                    <div class="member-wrapper">
                        @foreach($propose_relation->members as $key => $member)
                            <div class="form-group">
                                <label class="control-label col-sm-4 col-md-3">Dosen Luar</label>
                                <div class="col-sm-7 mb-10">
                                    <div class="ckbox ckbox-default">
                                        <input name="external{{$key}}" id="external{{$key}}" type="checkbox" value="1"
                                               class="external-checkbox" {{$member->external === '1' ? "checked" : ""}} {{$disabled}}>
                                        <label for="external{{$key}}">*Tick ini jika anggota merupakan dosen dari luar
                                            USU</label>
                                    </div>
                                </div>
                                <div class="external-member-wrapper">
                                    <label for="external_name[]" class="col-sm-4 col-md-3 control-label">Nama</label>
                                    <div class="col-sm-7 input-icon right">
                                        <input name="external_name[]" type="text"
                                               class="form-control input-sm mb-15"
                                               value="{{$member->external_name}}" {{$disabled}} />
                                    </div>
                                    <label for="external_affiliation[]"
                                           class="col-sm-4 col-md-3 control-label">Afiliasi</label>
                                    <div class="col-sm-7 input-icon right">
                                        <input name="external_affiliation[]" type="text"
                                               class="form-control input-sm mb-15"
                                               value="{{$member->external_affiliation}}" {{$disabled}} />
                                    </div>
                                </div>
                                <div class="internal-member-wrapper">
                                    <label for="member_nidn[]" class="col-sm-4 col-md-3 control-label">Anggota</label>
                                    <div class="col-sm-7 input-icon right">
                                        @if($member->status === 'waiting')
                                            <i class="fa fa-circle-o-notch fa-spin fg-warning"
                                               style="bottom: 18px;"></i>
                                        @elseif($member->status === 'accepted')
                                            <i class="fa fa-check-circle fg-success" style="bottom: 18px;"></i>
                                        @elseif($member->status === 'rejected')
                                            <i class="fa fa-times-circle fg-danger" style="bottom: 18px;"></i>
                                        @endif
                                        <input name="member_display[]" type="text"
                                               class="input-member form-control input-sm mb-15"
                                               value="{{$member->member_display}}" {{$disabled}} />
                                        <input name="member_nidn[]" type="text" class="input-value" hidden="hidden"
                                               value="{{$member->member_nidn}}"/>
                                        @if($errors->has('member_display.' . $key))
                                            <label class="error" for="member_display[]" style="display: inline-block;">
                                                {{ $errors->first('member_display.' . $key) }}
                                            </label>
                                        @endif
                                        @if($errors->has('member_nidn.' . $key))
                                            <label class="error" for="member_display[]" style="display: inline-block;">
                                                Pemilihan anggota harus dilakukan via autocomplete
                                            </label>
                                        @endif
                                    </div>
                                </div>
                                <label for="member_areas_of_expertise[]" class="col-sm-4 col-md-3 control-label">Bidang
                                    Keahlian</label>
                                <div class="col-sm-7">
                                    <input name="member_areas_of_expertise[]" type="text"
                                           class="form-control input-sm mb-15"
                                           value="{{$member->areas_of_expertise}}" {{$disabled === null ? '' : ( $member->member_nidn === Auth::user()->nidn ? ($upd_mode === 'display' ? 'disabled' : '') : 'disabled') }} />
                                    @if($errors->has('member_areas_of_expertise.' . $key))
                                        <label class="error" for="member_areas_of_expertise[]"
                                               style="display: inline-block;">
                                            {{ $errors->first('member_areas_of_expertise.' . $key) }}
                                        </label>
                                    @endif
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-offset-4 col-md-offset-3">
                                    <div class="col-sm-1">
                                        @if($disabled === null)
                                            <a href="#" class="remove_field btn btn-sm btn-danger btn-stroke">
                                                <i class="fa fa-minus"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- /.form-group -->
                        @endforeach
                    </div> <!-- /.member-wrapper -->
                </div><!-- /.form-body -->
                @if($disabled === null)
                    <div class="form-footer">
                        <div class="col-sm-offset-4 col-md-offset-3">
                            <a href="#" class="add-member-button btn btn-success btn-stroke btn-slideright"><i
                                        class="fa fa-plus"></i></a>
                        </div><!-- /.col-sm-offset-3 -->
                    </div><!-- /.form-footer -->
                @endif
            </div>
        </div>
    </div>
</div>