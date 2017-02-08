@extends('layouts.lay_admin')

@if($errors->has('dedication_name') || old('dedication_name'))
    @php($dedication_type->dedication_name = old('dedication_name'))
@endif

@section('content')
    <section id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-file-archive-o"></i>{{$pageTitle}}</h2>
            <div class="breadcrumb-wrapper hidden-xs">
                <span class="label">Direktori anda:</span>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{url('/')}}">Beranda</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        {{$pageTitle}}
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">{{$upd_mode === 'create' ? 'Tambah' : 'Ubah'}}</li>
                </ol>
            </div><!-- /.breadcrumb-wrapper -->
        </div><!-- /.header-content -->
        <!--/ End page header -->

        <div class="body-content animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title">{{$upd_mode === 'create' ? 'Tambah' : 'Ubah'}} Jenis Pengabdian</h3>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-sm" data-action="collapse" data-container="body"
                                        data-toggle="tooltip" data-placement="top" data-title="Collapse"><i
                                            class="fa fa-angle-up"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- /.panel-heading -->

                        <div class="panel-body no-padding">
                            <form class="form-horizontal form-bordered submit-form"
                                  action="{{$upd_mode === 'create' ? url($deleteUrl . '/create') : url($deleteUrl, $dedication_type->id) . '/edit'}}"
                                  method="POST">
                                <div class="form-body">

                                    <div class="form-group">
                                        <label for="dedication_name" class="col-sm-4 col-md-3 control-label">
                                            Jenis Pengabdian
                                        </label>
                                        <div class="col-sm-7">
                                            <input name="dedication_name" class="form-control input-sm" type="text"
                                                   value="{{$dedication_type->dedication_name}}">
                                            @if($errors->has('dedication_name'))
                                                <label class="error" for="dedication_name"
                                                       style="display: inline-block;">
                                                    {{ $errors->first('dedication_name') }}
                                                </label>
                                            @endif
                                        </div>
                                    </div><!-- /.form-group -->

                                    {{ csrf_field() }}
                                    @if($upd_mode === 'edit')
                                        <input type="hidden" name="_method" value="PUT">
                                    @endif

                                    <div class="form-footer">
                                        <div class="col-sm-offset-3">
                                            <a href="{{url($deleteUrl)}}"
                                               class="btn btn-teal btn-slideright">Kembali</a>
                                            <button type="submit" class="btn btn-success btn-slideright submit">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>
                                </div><!-- /.form-body -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.body-content -->

        <!-- Start footer content -->
    @include('layouts._footer-admin')
    <!--/ End footer content -->
    </section><!-- /#page-content -->
@endsection