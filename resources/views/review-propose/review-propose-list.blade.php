@extends('layouts.lay_admin')

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
                        <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                                data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if(!$proposes->isEmpty())
                                <div class="table-responsive mb-20">
                                    <table class="table table-striped table-success">
                                        <thead>
                                        <tr>
                                            <th class="text-center border-right">Id</th>
                                            <th class="text-center">Judul</th>
                                            <th class="text-center">Scheme</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($proposes as $propose)
                                            <tr>
                                                <td class="text-center border-right">{{ $propose->id }}</td>
                                                <td class="text-center border-right">{{ $propose->title }}</td>
                                                <td class="text-center border-right">
                                                    @if($propose->is_own === null)
                                                        {{ $propose->period()->first()->scheme }}
                                                    @else
                                                        {{ $propose->proposesOwn()->first()->scheme }}
                                                    @endif
                                                </td>
                                                <td class="text-center border-right">{{ $propose->flowStatus()->orderBy('item', 'desc')->first()
                                                   ->statusCode()->first()->description }}</td>
                                                <td class="text-center">
                                                    <a href="{{url($deleteUrl . '/' . $propose->id .'/review')}}"
                                                       class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                       data-placement="top" data-original-title="Review">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    @if($propose->reviewPropose()->where('nidn', Auth::user()->nidn)->exists())
                                                        <a href="{{url($deleteUrl . '/' . $propose->reviewPropose()->where('nidn', Auth::user()->nidn)->first()->id .'/print-review')}}"
                                                           class="btn btn-default btn-xs" data-toggle="tooltip"
                                                           data-placement="top" data-original-title="Print"
                                                           target="_blank">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th class="text-center border-right">Id</th>
                                            <th class="text-center">Judul</th>
                                            <th class="text-center">Scheme</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.table-responsive -->
                                <!--/ End table horizontal scroll -->
                            @else
                                <blockquote><p>{{ $data_not_found }}</p></blockquote>
                            @endif
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
