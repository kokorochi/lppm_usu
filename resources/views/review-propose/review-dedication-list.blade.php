@extends('layouts.lay_admin')

@section('content')
    <section id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-pencil"></i>Review</h2>
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
                    <li class="active">List Pengabdian</li>
                </ol>
            </div><!-- /.breadcrumb-wrapper -->
        </div><!-- /.header-content -->
        <!--/ End page header -->

        <div class="body-content animated fadeIn">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title">Scheme</h3>
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
                                    <label for="scheme" class="col-sm-4 col-md-3 control-label">Scheme</label>
                                    <div class="col-sm-7 mb-10">
                                        <select id="scheme-review-dedication" name="scheme" class="form-control input-sm">
                                            @foreach($periods as $item)
                                                <option value="{{$item->id}}" {{$period->id == $item->id ? 'selected' : null}}>{{$item->scheme}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input name="user_login" type="hidden" value="{{Auth::user()->nidn}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start datatable using ajax -->
                    <div class="panel rounded shadow">
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h3 class="panel-title">List Pengabdian Berdasarkan Scheme</h3>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-sm" data-action="collapse" data-container="body"
                                        data-toggle="tooltip" data-placement="top" data-title="Collapse"><i
                                            class="fa fa-angle-up"></i></button>
                            </div>
                            <div class="clearfix"></div>
                        </div><!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Start datatable -->
                            <table id="table-review-dedication-ajax" class="table table-striped table-success">
                                <thead>
                                <tr>
                                    <th data-class="expand">Judul</th>
                                    <th data-hide="phone">Ketua</th>
                                    <th data-hide="phone">Scheme</th>
                                    <th data-hide="phone">Status</th>
                                    <th data-hide="phone,tablet">Detail</th>
                                </tr>
                                </thead>
                                <!--tbody section is required-->
                                <tbody></tbody>
                                <!--tfoot section is optional-->
                                <tfoot>
                                <tr>
                                    <th>Judul</th>
                                    <th>Ketua</th>
                                    <th>Scheme</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                </tr>
                                </tfoot>
                            </table>
                            <!--/ End datatable -->
                        </div><!-- /.panel-body -->
                    </div><!-- /.panel -->
                    <!--/ End datatable using ajax -->
                </div>
            </div>
        </div><!-- /.body-content -->

        <!-- Start footer content -->
    @include('layouts._footer-admin')
    <!--/ End footer content -->
    </section><!-- /#page-content -->
@endsection