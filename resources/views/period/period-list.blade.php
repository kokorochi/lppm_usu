@extends('layouts.lay_admin')

<!-- START @PAGE CONTENT -->
@section('content')
    <section id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-calendar"></i> {{ $pageTitle }} </h2>
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
                    <li class="active">List</li>
                </ol>
            </div><!-- /.breadcrumb-wrapper -->
        </div><!-- /.header-content -->
        <!--/ End page header -->

        <!-- Start body content -->
        <div class="body-content animated fadeIn">
            <div class="panel rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">List {{$pageTitle}}</h3>
                    </div>
                    <div class="pull-right">
                        {{--<button class="btn btn-sm" data-action="refresh" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Refresh"><i class="fa fa-refresh"></i></button>--}}
                        <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
                        {{--<button class="btn btn-sm" data-action="remove" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Remove"><i class="fa fa-times"></i></button>--}}
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive mb-20">
                                <table class="table table-striped table-success">
                                    <thead>
                                    <tr>
                                        <th class="text-center border-right">Id</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">Jenis Pengabdian</th>
                                        <th>Scheme</th>
                                        <th>Sumber Dana</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($periods as $period)
                                        <tr>
                                            <td class="text-center border-right">{{ $period->id }}</td>
                                            <td class="text-center border-right">{{ $period->years }}</td>
                                            <td class="text-center border-right">{{ $period->categoryType->category_name }}</td>
                                            <td class="text-center border-right">{{ $period->dedicationType->dedication_name }}</td>
                                            <td>{{ $period->scheme }}</td>
                                            <td>{{ $period->sponsor }}</td>
                                            <td class="text-center">
                                                <a href="{{url($deleteUrl . '/' . $period->id .'/edit')}}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" data-original-title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="#" class="modal_delete btn btn-danger btn-xs" data-id="{{$period->id}}" data-placement="top" data-original-title="Delete" data-toggle="modal" data-target=".bs-example-modal-sm">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center border-right">Id</th>
                                        <th class="text-center">Tahun</th>
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">Jenis Pengabdian</th>
                                        <th>Scheme</th>
                                        <th>Sumber Dana</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                {{ $periods->render() }}
                            </div><!-- /.table-responsive -->
                            <!--/ End table horizontal scroll -->
                        </div>
                    </div><!-- /.row -->

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
