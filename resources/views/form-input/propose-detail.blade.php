{{--Get Old Value And Place It To VARIABLE--}}
@if(
$errors->has('faculty_code') || old('faculty_code') ||
$errors->has('title') || old('title') ||
$errors->has('output_type') || old('output_type') ||
$errors->has('total_amount') || old('total_amount') ||
$errors->has('time_period') || old('time_period') ||
$errors->has('bank_account_name') || old('bank_account_name') ||
$errors->has('bank_account_no') || old('bank_account_no')
)
    @php
        $propose_relation->propose->faculty_code          = old('faculty_code');
        $propose_relation->propose->title                 = old('title');
        $propose_relation->propose->total_amount          = old('total_amount');
        $propose_relation->propose->time_period           = old('time_period');
        $propose_relation->propose->bank_account_name     = old('bank_account_name');
        $propose_relation->propose->bank_account_no       = old('bank_account_no');
        $propose_relation->propose->address               = old('address');
        $propose_relation->propose->student_involved      = old('student_involved');
        $propose_relation->propose->areas_of_expertise    = old('areas_of_expertise');
    @endphp
@endif
{{--Get Old Value And Place It To VARIABLE--}}

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Detail Pengabdian</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <div class="form-body form-horizontal form-bordered" id="input-mask">
                    <div class="form-group">
                        <label for="faculty_code" class="col-sm-4 col-md-3 control-label">Fakultas</label>
                        <div class="col-sm-7">
                            <select name="faculty_code" class="form-control input-sm" {{$disabled}}>
                                @foreach($propose_relation->faculties as $faculty)
                                    <option value="{{$faculty->faculty_code}}" {{$propose_relation->propose->faculty_code === $faculty->faculty_code ? 'selected' : null}}>{{$faculty->faculty_name}}</option>
                                @endforeach
                            </select>
                        </div><!-- /.col-sm-7 -->

                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label for="title" class="col-sm-4 col-md-3 control-label">Judul Pengabdian</label>
                        <div class="col-sm-7">
                            <input name="title" class="form-control input-sm" type="text"
                                   value="{{ $propose_relation->propose->title }}" {{$disabled}}>
                            @if($errors->has('title'))
                                <label class="error" for="title" style="display: inline-block;">
                                    {{ $errors->first('title') }}
                                </label>
                            @endif
                        </div>
                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label for="total_amount" class="col-sm-4 col-md-3 control-label">Jumlah Dana</label>
                        <div class="col-sm-7">
                            <input name="total_amount" class="form-control input-sm" type="text"
                                   data-inputmask="'alias': 'decimal', 'groupSeparator': ',', 'autoGroup': true, 'rightAlign': false"
                                   value="{{ $propose_relation->propose->total_amount }}" {{$disabled}}>
                            @if($errors->has('total_amount'))
                                <label class="error" for="total_amount" style="display: inline-block;">
                                    {{ $errors->first('total_amount') }}
                                </label>
                            @endif
                        </div>
                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label for="time_period" class="col-sm-4 col-md-3 control-label">Jangka Waktu
                            Pelaksanaan (Bulan)</label>
                        <div class="col-sm-7">
                            <input name="time_period" class="form-control input-sm" type="text"
                                   maxlength="2" data-inputmask="'alias': 'decimal', 'rightAlign': false"
                                   value="{{ $propose_relation->propose->time_period }}" {{$disabled}}>
                            @if($errors->has('time_period'))
                                <label class="error" for="time_period" style="display: inline-block;">
                                    {{ $errors->first('time_period') }}
                                </label>
                            @endif
                        </div>
                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label for="student_involved" class="col-sm-4 col-md-3 control-label">Mahasiswa Yang
                            Terlibat</label>
                        <div class="col-sm-7">
                            <input name="student_involved" class="form-control input-sm" type="text"
                                   maxlength="2" data-inputmask="'alias': 'decimal', 'rightAlign': false"
                                   value="{{ $propose_relation->propose->student_involved }}" {{$disabled}}>
                            @if($errors->has('time_period'))
                                <label class="error" for="student_involved" style="display: inline-block;">
                                    {{ $errors->first('student_involved') }}
                                </label>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="col-sm-4 col-md-3 control-label">Alamat Kantor/Faks/Telepon</label>
                        <div class="col-sm-7">
                            <input name="address" class="form-control input-sm" type="text"
                                   value="{{ $propose_relation->propose->address }}" {{$disabled}}>
                            @if($errors->has('address'))
                                <label class="error" for="address" style="display: inline-block;">
                                    {{ $errors->first('address') }}
                                </label>
                            @endif
                        </div>
                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label for="bank_account_name" class="col-sm-4 col-md-3 control-label">Nama Pemilik Rekening
                            Bank</label>
                        <div class="col-sm-7">
                            <input name="bank_account_name" class="form-control input-sm" type="text"
                                   value="{{ $propose_relation->propose->bank_account_name }}" {{$disabled}}>
                            @if($errors->has('bank_account_name'))
                                <label class="error" for="bank_account_name" style="display: inline-block;">
                                    {{ $errors->first('bank_account_name') }}
                                </label>
                            @endif
                        </div>
                    </div><!-- /.form-group -->

                    <div class="form-group">
                        <label for="bank_account_no" class="col-sm-4 col-md-3 control-label">Nomor Pemilik Rekening
                            Bank</label>
                        <div class="col-sm-7">
                            <input name="bank_account_no" class="form-control input-sm" type="text"
                                   value="{{ $propose_relation->propose->bank_account_no }}" {{$disabled}}>
                            @if($errors->has('bank_account_no'))
                                <label class="error" for="bank_account_no" style="display: inline-block;">
                                    {{ $errors->first('bank_account_no') }}
                                </label>
                            @endif
                        </div>
                    </div><!-- /.form-group -->
                </div><!-- /.form-body -->
            </div>
        </div>
    </div>
</div>