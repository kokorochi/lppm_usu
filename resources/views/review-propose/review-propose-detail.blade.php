@extends('layouts.lay_admin')

{{--Get Old Value And Place It To VARIABLE--}}
@php($ctr_old = 0)

@while(
$errors->has('score.' . $ctr_old) || old('score.' . $ctr_old)
)
    @php
        $review_proposes_i[$ctr_old]->score = old('score.' . $ctr_old);
        $review_proposes_i[$ctr_old]->comment = old('comment.' . $ctr_old);
        $ctr_old++;
    @endphp
@endwhile

@if(old('suggestion'))
    @php($review_propose->suggestion = old('suggestion'))
@endif
@if(old('conclusion_id'))
    @php($review_propose->conclusion_id = old('conclusion_id'))
@endif

@php
    foreach ($review_proposes_i as $item)
    {
        $item->total_score = $item->score * $item->quality;
    }
@endphp
{{--Get Old Value And Place It To VARIABLE--}}

<!-- START @PAGE CONTENT -->
@section('content')
    <section id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-pencil"></i> {{ $pageTitle }} </h2>
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
                    <li class="active">Penilaian</li>
                </ol>
            </div><!-- /.breadcrumb-wrapper -->
        </div><!-- /.header-content -->
        <!--/ End page header -->

        <!-- Start body content -->
        <div class="body-content animated fadeIn">

            @include('form-input.panel-errors')

            <div class="panel rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">{{$pageTitle}}</h3>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                                data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="form-body form-horizontal form-bordered no-padding">
                        <div class="form-group">
                            <label for="title" class="col-sm-4 col-md-3 control-label">Judul Pengabdian</label>
                            <div class="col-sm-7">
                                <input name="title" class="form-control input-sm" type="text"
                                       value="{{ $propose->title }}" disabled>
                            </div>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label class="control-label col-sm-4 col-md-3">Unduh Usulan</label>
                            <div class="col-sm-7 mb-10">
                                <div class="input-group">
                                    <input name="file_partner_contract[]" class="form-control input-sm"
                                           type="text" disabled
                                           value="{{ $propose->file_propose_ori }}">
                                        <span class="input-group-btn">
                                        {{--<button type="button" class="btn btn-default">Go!</button>--}}
                                            <a href="{{url('proposes', $propose->id) . '/download/2' }}"
                                               class="btn btn-primary btn-sm">Unduh</a>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form class="submit-form" action="{{url('review-proposes',$propose->id) . '/review'}}" method="POST">
                        <table class="table table-bordered table-striped">
                            <tbody>
                            @foreach($review_proposes_i as $key => $review_propose_i)
                                <tr>
                                    <td width="30%">{{$review_propose_i->aspect}}</td>
                                    <td width="15%">
                                        <div class="form-group">
                                            <input name="score[]" class="form-control input-sm input-score" type="text" value="{{$review_propose_i->score}}" {{$review_propose_i->disabled}}>
                                            @if($errors->has('score.' . $key))
                                                <label class="error" for="score[]" style="display: inline-block;">
                                                    {{ $errors->first('score.' . $key) }}
                                                </label>
                                            @endif
                                        </div>
                                    </td>
                                    <td width="10%">
                                        <input name="quality[]" class="form-control input-sm text-center" type="text" value="{{$review_propose_i->quality}}"
                                               disabled>
                                    </td>
                                    <td width="15%">
                                        <input name="final-score[]" class="form-control input-sm text-center output-score" type="text" value="{{$review_propose_i->total_score}}"
                                               disabled>
                                    </td>
                                    <td width="30%">
                                        <textarea name="comment[]" class="form-control input-sm" rows="2"
                                                  placeholder="" {{$review_propose_i->disabled}}>{{$review_propose_i->comment}}</textarea>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="form-body form-horizontal form-bordered no-padding">
                            <div class="form-group">
                                <label for="conclusion_id" class="col-sm-4 col-md-3 control-label">Kesimpulan</label>
                                <div class="col-sm-7 mb-10">
                                    <select name="conclusion_id" class="form-control input-sm" {{$review_propose->disabled}}>
                                        @foreach($conclusions as $conclusion)
                                            <option value="{{$conclusion->id}}"
                                                    {{$review_propose->conclusion_id == $conclusion->id ? 'selected' : null}}
                                            >
                                                {{$conclusion->conclusion_desc}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="suggestion" class="col-sm-4 col-md-3 control-label">Saran</label>
                                <div class="col-sm-7">
                                    <textarea name="suggestion" class="form-control input-sm" rows="3"
                                              placeholder="" {{$review_propose->disabled}}>{{$review_propose->suggestion}}</textarea>
                                </div>
                            </div><!-- /.form-group -->
                        </div><!-- /.form-body -->
                        {{ csrf_field() }}
                        <div class="form-footer">
                            <div class="col-sm-offset-4 col-md-offset-3">
                                @if($upd_mode === 'display')
                                    <a href="{{url('review-proposes', $review_propose->id) . '/print-review'}}" target="_blank" class="btn btn-default btn-slideright">
                                        <i class="fa fa-print"></i> Print
                                    </a>
                                @endif
                                <a href="{{url($deleteUrl)}}" class="btn btn-danger btn-slideright">Kembali</a>
                                @if($upd_mode === 'create')
                                    <button type="submit" class="btn btn-success btn-slideright submit">Simpan</button>
                                @endif
                            </div><!-- /.col-sm-offset-3 -->
                        </div><!-- /.form-footer -->
                    </form><!-- /form -->
                </div><!-- /.panel-body -->
            </div><!-- /.panel -->

        </div><!-- /.body-content -->
        <!--/ End body content -->

        <!-- Start footer content -->
    @include('layouts._footer-admin')
    <!--/ End footer content -->

    </section><!-- /#page-content -->

    <!-- Delete Confirmation Dialog Box -->
    @include('layouts._delete_modal');
    <!-- Delete Confirmation Dialog Box -->
@endsection
<!--/ END PAGE CONTENT -->
