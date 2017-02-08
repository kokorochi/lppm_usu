@extends('layouts.lay_admin')

@php
    if( $errors->has('image_name') ||
        $errors->has('title') ||
        $errors->has('content'))
    {
        $announce->title = old('title');
        $announce->content = old('content');
    }
@endphp

@section('content')
    <section id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-bullhorn"></i>Pengumuman</h2>
            <div class="breadcrumb-wrapper hidden-xs">
                <span class="label">Direktori anda:</span>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{url('/')}}">Beranda</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        Pengumuman
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
                                <h3 class="panel-title">{{$upd_mode === 'create' ? 'Tambah' : 'Ubah'}} Pengumuman</h3>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-sm" data-action="collapse" data-container="body"
                                        data-toggle="tooltip" data-placement="top" data-title="Collapse"><i
                                            class="fa fa-angle-up"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- /.panel-heading -->

                        <div class="panel-body no-padding">
                            <form class="form-horizontal form-bordered submit-form" action="{{$form_action}}"
                                  enctype="multipart/form-data"
                                  method="POST">
                                <div class="form-body">
                                    @if($upd_mode === 'edit')
                                        @if($announce->image_name !== null)
                                            <div class="form-group">
                                                <label class="control-label col-sm-4 col-md-3">Gambar Pengumuman</label>
                                                <div class="col-sm-7">
                                                    <img src="{{url('images/upload/announces', $announce->image_name)}}"
                                                         class="announce-image mb-10" alt="">
                                                </div>
                                                <div class="clearfix"></div>
                                                <label class="control-label col-sm-4 col-md-3">Hapus Gambar</label>
                                                <div class="col-sm-7">
                                                    <div class="ckbox ckbox-danger">
                                                        <input name="delete_image" id="checkbox-danger2" type="checkbox"
                                                               value="x">
                                                        <label for="checkbox-danger2"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    <div class="form-group">
                                        <div class="clearfix"></div>
                                        <label class="control-label col-sm-4 col-md-3">Unggah Gambar Pengumuman</label>
                                        <div class="col-sm-7">
                                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="form-control input-sm" data-trigger="fileinput">
                                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                    <span class="fileinput-filename"></span>
                                                </div>
                                            <span class="input-group-addon btn btn-success btn-file">
                                                <span class="fileinput-new">Pilih file</span>
                                                <span class="fileinput-exists">Ubah</span>
                                                <input type="file" name="image_name"
                                                       value="">
                                            </span>
                                                <a href="#" class="input-group-addon btn btn-danger fileinput-exists"
                                                   data-dismiss="fileinput">Hapus</a>
                                            </div>
                                            @if($errors->has('image_name'))
                                                <label class="error" for="image_name"
                                                       style="display: inline-block;">
                                                    {{ $errors->first('image_name') }}
                                                </label>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="col-sm-4 col-md-3 control-label">Judul
                                            Pengumuman</label>
                                        <div class="col-sm-7">
                                            <input name="title" class="form-control input-sm" type="text"
                                                   value="{{ $announce->title }}">
                                            @if($errors->has('title'))
                                                <label class="error" for="title" style="display: inline-block;">
                                                    {{ $errors->first('title') }}
                                                </label>
                                            @endif
                                        </div>
                                    </div><!-- /.form-group -->

                                    <div class="form-group">
                                        <div class="inner-all">
                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <textarea name="content" id="summernote-textarea"
                                                              class="form-control" rows="10"
                                                              placeholder="Konten pengumuman...">
                                                        {{$announce->content}}
                                                    </textarea>
                                                    @if($errors->has('content'))
                                                        <label class="error" for="content"
                                                               style="display: inline-block;">
                                                            {{ $errors->first('content') }}
                                                        </label>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{ csrf_field() }}
                                    @if($upd_mode === 'edit')
                                        <input type="hidden" name="_method" value="PUT">
                                    @endif

                                    <div class="form-footer">
                                        <div class="col-sm-offset-3">
                                            <a href="{{url($deleteUrl)}}"
                                               class="btn btn-teal btn-slideright">Kembali</a>
                                            <button type="submit" class="btn btn-success btn-slideright submit">{{$upd_mode === 'create' ? 'Tambah' : 'Ubah'}}</button>
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