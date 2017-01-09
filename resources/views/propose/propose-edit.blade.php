@extends('layouts.lay_admin')

@section('content')
    <section id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-file-powerpoint-o"></i> {{ $pageTitle }} </h2>
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
                    <li class="active">Ubah Usulan</li>
                </ol>
            </div><!-- /.breadcrumb-wrapper -->
        </div><!-- /.header-content -->
        <!--/ End page header -->

        <div class="body-content animated fadeIn">

            @include('form-input.panel-errors')

            @include('form-input.propose-scheme')

            @include('form-input.propose-partner')

            @include('form-input.propose-member')

            @include('form-input.propose-detail-output')

            @include('form-input.propose-detail')

            <form class="" action="{{url('proposes', $propose->id) . '/edit'}}" method="POST"
                  enctype="multipart/form-data">

                @include('form-input.propose-upload')

                @if($status_code === 'UD')
                    @include('form-input.propose-revision')
                @endif

                @include('form-input.propose-print-selection')

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">

                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-footer">
                                <div class="col-sm-offset-4 col-md-offset-3">
                                    <button name="submit_button" type="submit" value="print"
                                       class="btn btn-primary btn-stroke btn-dashed btn-slideright">
                                        <i class="fa fa-print"></i> Print
                                    </button>
                                    <a href="{{url($deleteUrl)}}" class="btn btn-teal btn-slideright">Kembali</a>
                                    @if($disable_upload === false)
                                        <button name="submit_button" type="submit" class="btn btn-success btn-slideright" value="edit">Ubah</button>
                                    @endif
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