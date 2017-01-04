@extends('layouts.lay_admin')

{{--Get Old Value And Place It To VARIABLE--}}
@if($errors->has('full_name') || old('full_name') ||
$errors->has('nidn') || old('nidn') ||
$errors->has('begin_date') || old('begin_date') ||
$errors->has('end_date') || old('end_date'))
    @php
        $auths['full_name']     = old('full_name');
        $auths['nidn']          = old('nidn');
        $auths['begin_date']    = old('begin_date');
        $auths['end_date']      = old('end_date');
    @endphp
@endif
{{--Get Old Value And Place It To VARIABLE--}}

@section('content')
    <section id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-balance-scale"></i> {{ $pageTitle }} </h2>
            <div class="breadcrumb-wrapper hidden-xs">
                <span class="label">Direktori anda:</span>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{url('/')}}">Beranda</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        {{ $pageTitle }}
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Ubah</li>
                </ol>
            </div><!-- /.breadcrumb-wrapper -->
        </div><!-- /.header-content -->
        <!--/ End page header -->

        <div class="body-content animated fadeIn">

            @include('form-input.panel-errors')

            <form class="" action="{{url('reviewers', $auths->id) . '/edit'}}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h3 class="panel-title">Ubah Reviewer</h3>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-sm" data-action="collapse" data-container="body"
                                       data-toggle="tooltip"
                                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body no-padding">
                                <div class="form-body form-horizontal form-bordered">
                                    <div class="form-group">
                                        <label for="full_name" class="col-sm-4 col-md-3 control-label">Nama</label>
                                        <div class="col-sm-7">
                                            <input name="full_name"
                                                   class="input-reviewer input-member form-control input-sm"
                                                   type="text"
                                                   value="{{$auths->full_name}}" readonly>
                                            <input name="nidn" type="text" class="input-value" hidden="hidden"
                                                   value="{{$auths->nidn}}"/>
                                            @if($errors->has('full_name'))
                                                <label class="error" for="full_name" style="display: inline-block;">
                                                    {{ $errors->first('full_name') }}
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="dp" class="form-group">
                                        <label for="begin_date" class="col-sm-4 col-md-3 control-label">Tanggal
                                            Mulai</label>
                                        <div class="col-sm-3">
                                            <input id="dp-1" name="begin_date" class="form-control input-sm" type="text"
                                                   value="{{$auths->begin_date}}">
                                            @if($errors->has('begin_date'))
                                                <label class="error" for="begin_date" style="display: inline-block;">
                                                    {{ $errors->first('begin_date') }}
                                                </label>
                                            @endif
                                        </div>
                                        <label for="end_date" class="col-sm-1 control-label"
                                               style="text-align: center;">-</label>
                                        <div class="col-sm-3">
                                            <input id="dp-2" name="end_date" class="form-control input-sm" type="text"
                                                   value="{{$auths->end_date}}">
                                            @if($errors->has('end_date'))
                                                <label class="error" for="end_date" style="display: inline-block;">
                                                    {{ $errors->first('end_date') }}
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h3 class="panel-title">Informasi Dosen Yang Dipilih</h3>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-sm" data-action="collapse" data-container="body"
                                       data-toggle="tooltip"
                                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body no-padding">
                                <div class="form-body form-horizontal form-bordered">
                                    <div class="form-group">
                                        <label class="col-sm-4 col-md-3 control-label">NIDN</label>
                                        <div class="col-sm-7">
                                            <input name="employee_card_serial_number" class="form-control input-sm"
                                                   type="text" value="{{$lecturer->employee_card_serial_number}}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 col-md-3 control-label">NIP</label>
                                        <div class="col-sm-7">
                                            <input name="number_of_employee_holding" class="form-control input-sm"
                                                   type="text" value="{{$lecturer->number_of_employee_holding}}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 col-md-3 control-label">Program Studi</label>
                                        <div class="col-sm-7">
                                            <input name="study_program" class="form-control input-sm" type="text"
                                                   value="{{$lecturer->study_program}}" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">

                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-footer">
                                <div class="col-sm-offset-4 col-md-offset-3">
                                    <a href="{{url($deleteUrl)}}" class="btn btn-teal btn-slideright">Kembali</a>
                                    <button type="submit" class="btn btn-success btn-slideright">Ubah</button>
                                </div><!-- /.col-sm-offset-3 -->
                            </div><!-- /.form-footer -->
                        </div><!-- /.panel -->
                    </div><!-- /.col-md-12 -->
                </div><!-- /.row -->
            </form>
        </div><!-- /.body-content -->

        <!-- Start footer content -->
    @include('layouts._footer-admin')
    <!--/ End footer content -->
    </section><!-- /#page-content -->
@endsection