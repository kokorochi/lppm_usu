@extends('layouts.lay_admin')

@section('content')
<section id="page-content">

    <!-- Start page header -->
    <div class="header-content">
        <h2><i class="fa fa-star"></i> {{ $pageTitle }} </h2>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">Direktori anda:</span>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{url('/')}}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    {{ $pageTitle }}
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="active">Edit</li>
            </ol>
        </div><!-- /.breadcrumb-wrapper -->
    </div><!-- /.header-content -->
    <!--/ End page header -->

    <div class="body-content animated fadeIn">

        @foreach($period_array as $key => $value)
            @if(old($key))
                @php($period[$key] = old($key))
            @endif
        @endforeach

        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Edit {{$pageTitle}}</h3>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div><!-- /.panel-heading -->

                    <div class="panel-body no-padding">
                        <form id="dp" class="form-horizontal" action="{{url('periods', $period->id) . '/edit'}}" method="POST">
                            <div class="form-body">

                                <div class="form-group">
                                    <label for="years" class="col-sm-3 control-label">Tahun</label>
                                    <div class="col-sm-7">
                                        <input name="years" class="form-control input-sm" type="text" value="{{ $period->years }}">
                                        @if($errors->has('years'))
                                            <label class="error" for="years" style="display: inline-block;">
                                                {{ $errors->first('years') }}
                                            </label>
                                        @endif
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="category_type" class="col-sm-3 control-label">Jenis Sumber Dana</label>
                                    <div class="col-sm-7">
                                        <select name="category_type" class="form-control input-sm">
                                            @foreach($category_types as $category_type)
                                                <option value="{{$category_type->id}}" {{$period->category_type == $category_type->id ? 'selected' : null}}>{{$category_type->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="dedication_type" class="col-sm-3 control-label">Jenis Pengabdian</label>
                                    <div class="col-sm-7">
                                        <select name="dedication_type" class="form-control input-sm">
                                            @foreach($dedication_types as $dedication_type)
                                                <option value="{{$dedication_type->id}}" {{$period->dedication_type == $dedication_type->id ? 'selected' : null}}>{{$dedication_type->dedication_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="appraisal_type" class="col-sm-3 control-label">Jenis Penilaian</label>
                                    <div class="col-sm-7">
                                        <select name="appraisal_type" class="form-control input-sm">
                                            @foreach($appraisals as $appraisal)
                                                <option value="{{$appraisal->id}}" {{$period->appraisal_type == $appraisal->id ? 'selected' : null}}>{{$appraisal->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="scheme" class="col-sm-3 control-label">Scheme</label>
                                    <div class="col-sm-7">
                                        <input name="scheme" class="form-control input-sm" type="text" value="{{ $period->scheme }}">
                                        @if($errors->has('scheme'))
                                            <label class="error" for="scheme" style="display: inline-block;">
                                                {{ $errors->first('scheme') }}
                                            </label>
                                        @endif
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="sponsor" class="col-sm-3 control-label">Sumber Dana</label>
                                    <div class="col-sm-7">
                                        <input name="sponsor" class="form-control input-sm" type="text" value="{{ $period->sponsor }}">
                                        @if($errors->has('sponsor'))
                                            <label class="error" for="sponsor" style="display: inline-block;">
                                                {{ $errors->first('sponsor') }}
                                            </label>
                                        @endif
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="min_member" class="col-sm-3 control-label">Jumlah Anggota</label>
                                    <div class="col-sm-3">
                                        <input name="min_member" class="form-control input-sm" type="text" value="{{ $period->min_member }}">
                                        @if($errors->has('min_member'))
                                            <label class="error" for="min_member" style="display: inline-block;">
                                                {{ $errors->first('min_member') }}
                                            </label>
                                        @endif
                                    </div>
                                    <label class="col-sm-1 control-label" style="text-align: center;"> - </label>
                                    <div class="col-sm-3">
                                        <input name="max_member" class="form-control input-sm" type="text" value="{{ $period->max_member }}">
                                        @if($errors->has('max_member'))
                                            <label class="error" for="max_member" style="display: inline-block;">
                                                {{ $errors->first('max_member') }}
                                            </label>
                                        @endif
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="propose_begda" class="col-sm-3 control-label">Periode Usulan</label>
                                    <div class="col-sm-3">
                                        <input id="dp-1" name="propose_begda" class="form-control input-sm" type="text" value="{{ $period->propose_begda }}">
                                        @if($errors->has('propose_begda'))
                                            <label class="error" for="propose_begda" style="display: inline-block;">
                                                {{ $errors->first('propose_begda') }}
                                            </label>
                                        @endif
                                    </div>
                                    <label class="col-sm-1 control-label" style="text-align: center;"> - </label>
                                    <div class="col-sm-3">
                                        <input id="dp-2" name="propose_endda" class="form-control input-sm" type="text" value="{{ $period->propose_endda }}">
                                        @if($errors->has('propose_endda'))
                                            <label class="error" for="propose_endda" style="display: inline-block;">
                                                {{ $errors->first('propose_endda') }}
                                            </label>
                                        @endif
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="review_begda" class="col-sm-3 control-label">Periode Review</label>
                                    <div class="col-sm-3">
                                        <input id="dp-3" name="review_begda" class="form-control input-sm" type="text" value="{{ $period->review_begda }}">
                                        @if($errors->has('review_begda'))
                                            <label class="error" for="review_begda" style="display: inline-block;">
                                                {{ $errors->first('review_begda') }}
                                            </label>
                                        @endif
                                    </div>
                                    <label class="col-sm-1 control-label" style="text-align: center;"> - </label>
                                    <div class="col-sm-3">
                                        <input id="dp-4" name="review_endda" class="form-control input-sm" type="text" value="{{ $period->review_endda }}">
                                        @if($errors->has('review_endda'))
                                            <label class="error" for="review_endda" style="display: inline-block;">
                                                {{ $errors->first('review_endda') }}
                                            </label>
                                        @endif
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="first_begda" class="col-sm-3 control-label">Periode Laporan Kemajuan</label>
                                    <div class="col-sm-3">
                                        <input id="dp-5" name="first_begda" class="form-control input-sm" type="text" value="{{ $period->first_begda }}">
                                        @if($errors->has('first_begda'))
                                            <label class="error" for="first_begda" style="display: inline-block;">
                                                {{ $errors->first('first_begda') }}
                                            </label>
                                        @endif
                                    </div>
                                    <label class="col-sm-1 control-label" style="text-align: center;"> - </label>
                                    <div class="col-sm-3">
                                        <input id="dp-6" name="first_endda" class="form-control input-sm" type="text" value="{{ $period->first_endda }}">
                                        @if($errors->has('first_endda'))
                                            <label class="error" for="first_endda" style="display: inline-block;">
                                                {{ $errors->first('first_endda') }}
                                            </label>
                                        @endif
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="monev_begda" class="col-sm-3 control-label">Periode Monev</label>
                                    <div class="col-sm-3">
                                        <input id="dp-7" name="monev_begda" class="form-control input-sm" type="text" value="{{ $period->monev_begda }}">
                                        @if($errors->has('monev_begda'))
                                            <label class="error" for="monev_begda" style="display: inline-block;">
                                                {{ $errors->first('monev_begda') }}
                                            </label>
                                        @endif
                                    </div>
                                    <label class="col-sm-1 control-label" style="text-align: center;"> - </label>
                                    <div class="col-sm-3">
                                        <input id="dp-8" name="monev_endda" class="form-control input-sm" type="text" value="{{ $period->monev_endda }}">
                                        @if($errors->has('monev_endda'))
                                            <label class="error" for="monev_endda" style="display: inline-block;">
                                                {{ $errors->first('monev_endda') }}
                                            </label>
                                        @endif
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="last_begda" class="col-sm-3 control-label">Periode Laporan Akhir</label>
                                    <div class="col-sm-3">
                                        <input id="dp-9" name="last_begda" class="form-control input-sm" type="text" value="{{ $period->last_begda }}">
                                        @if($errors->has('last_begda'))
                                            <label class="error" for="last_begda" style="display: inline-block;">
                                                {{ $errors->first('last_begda') }}
                                            </label>
                                        @endif
                                    </div>
                                    <label class="col-sm-1 control-label" style="text-align: center;"> - </label>
                                    <div class="col-sm-3">
                                        <input id="dp-10" name="last_endda" class="form-control input-sm" type="text" value="{{ $period->last_endda }}">
                                        @if($errors->has('last_endda'))
                                            <label class="error" for="last_endda" style="display: inline-block;">
                                                {{ $errors->first('last_endda') }}
                                            </label>
                                        @endif
                                    </div>
                                </div><!-- /.form-group -->

                                <div class="form-group">
                                    <label for="annotation" class="col-sm-3 control-label">Keterangan</label>
                                    <div class="col-sm-7">
                                        <textarea name="annotation" class="form-control input-sm" rows="5" placeholder="Enter text ...">{{ $period->annotation }}</textarea>
                                        @if($errors->has('annotation'))
                                            <label class="error" for="annotation" style="display: inline-block;">
                                                {{ $errors->first('annotation') }}
                                            </label>
                                        @endif
                                    </div>
                                </div><!-- /.form-group -->

                                @if($errors->has('sumErrors'))
                                    <div class="form-group">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-7">
                                            <label class="error control-label" for="sumErrors" style="display: inline-block;">{{ $errors->first('sumErrors') }}</label>
                                        </div>
                                    </div><!-- /.form-group -->
                                @endif

                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PUT">

                                <div class="form-footer">
                                    <div class="col-sm-offset-3">
                                        <a href="{{url($deleteUrl)}}" class="btn btn-danger btn-slideright">Kembali</a>
                                        <button type="submit" class="btn btn-success btn-slideright">Ubah</button>
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