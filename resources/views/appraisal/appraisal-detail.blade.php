@extends('layouts.lay_admin')

@php
    $ctr_old = 0;

    while(
    $errors->has('aspect.' . $ctr_old) || old('aspect.' . $ctr_old) ||
    $errors->has('quality.' . $ctr_old) || old('quality.' . $ctr_old) )
    {
        $appraisal_i = new \App\Appraisal_i();
        $appraisal_i->aspect = old('aspect.' . $ctr_old);
        $appraisal_i->quality = old('quality.' . $ctr_old);
        if($appraisals_i->get($ctr_old) === null){
            $appraisals_i->add($appraisal_i);
        }else{
            $appraisals_i[$ctr_old] = $appraisal_i;
        }
        $ctr_old++;
    }

    if($errors->has('name') || old('name'))
    {
        $appraisal->name = old('name');
    }
@endphp

@section('content')
    <section id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-star"></i>{{ $pageTitle }}</h2>
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
                                <h3 class="panel-title">{{$upd_mode === 'create' ? 'Tambah' : 'Ubah'}} {{$pageTitle}}</h3>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-sm" data-action="collapse" data-container="body"
                                        data-toggle="tooltip" data-placement="top" data-title="Collapse"><i
                                            class="fa fa-angle-up"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- /.panel-heading -->

                        <div class="panel-body no-padding">
                            <form class="form-horizontal form-bordered submit-form" action="{{$form_action}}" method="POST">
                                <div class="form-body">
                                    <div class="input_fields_wrap">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 control-label">Nama Aspek
                                                Penilaian</label>
                                            <div class="col-sm-6">
                                                <input name="name" class="form-control input-sm" type="text"
                                                       value="{{ $appraisal->name }}">
                                                @if($errors->has('name'))
                                                    <label class="error" for="name" style="display: inline-block;">
                                                        {{ $errors->first('name') }}
                                                    </label>
                                                @endif
                                            </div>
                                        </div><!-- /.form-group -->

                                        @foreach($appraisals_i as $key => $appraisal_i)
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Deskripsi Aspek</label>
                                                <div class="col-sm-6">
                                                    <input name="aspect[]" class="form-control input-sm" type="text"
                                                           value="{{ $appraisal_i->aspect }}">
                                                    @if($errors->has('aspect.' . $key))
                                                        <label class="error" for="aspect[]"
                                                               style="display: inline-block;">
                                                            {{ $errors->first('aspect.' . $key) }}
                                                        </label>
                                                    @endif
                                                </div>
                                                <label class="col-sm-1 control-label">Bobot</label>
                                                <div class="col-sm-2">
                                                    <input name="quality[]" class="form-control input-sm"
                                                           type="text" value="{{ $appraisal_i->quality }}">
                                                    @if($errors->has('quality.' . $key))
                                                        <label class="error" for="quality[]"
                                                               style="display: inline-block;">
                                                            {{ $errors->first('quality.' . $key) }}
                                                        </label>
                                                    @endif
                                                </div>
                                                <div class="col-sm-1">
                                                    <a href="#"
                                                       class="remove_field btn btn-sm btn-danger btn-stroke">
                                                        <i class="fa fa-minus"></i>
                                                    </a>
                                                </div>
                                            </div><!-- /.form-group -->
                                        @endforeach
                                    </div><!-- /.input_fields_wrap -->

                                    @if($errors->has('countQuality'))
                                        <div class="form-group">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-6">
                                                <label class="error control-label" for="countQuality"
                                                       style="display: inline-block;">{{ $errors->first('countQuality') }}</label>
                                            </div>
                                        </div><!-- /.form-group -->
                                    @endif

                                    {{ csrf_field() }}
                                    @if($upd_mode === 'edit')
                                        <input type="hidden" name="_method" value="PUT">
                                    @endif

                                    <div class="form-footer">
                                        <div class="col-sm-offset-2">
                                            <a href="#" class="add_field_button btn btn-success btn-stroke"><i
                                                        class="fa fa-plus"></i></a>
                                            <a href="{{url($deleteUrl)}}"
                                               class="btn btn-teal btn-slideright">Kembali</a>
                                            <button type="submit" class="btn btn-success btn-slideright submit">Submit</button>
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