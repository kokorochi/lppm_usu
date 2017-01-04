@extends('layouts.lay_admin')

<!-- START @PAGE CONTENT -->
@section('content')
    <section id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-black-tie"></i> {{ $pageTitle }} </h2>
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
                    <li class="active">Luaran</li>
                </ol>
            </div><!-- /.breadcrumb-wrapper -->
        </div><!-- /.header-content -->
        <!--/ End page header -->

        <!-- Start body content -->
        <div class="body-content animated fadeIn">
            @include('form-input.panel-errors')
            @if($output_code === 'JS')
                @include('form-input.dedication-output-service')
            @elseif($output_code === 'MT')
                @include('form-input.dedication-output-method')
            @elseif($output_code === 'PB')
                @include('form-input.dedication-output-product')
            @elseif($output_code === 'PT')
                @include('form-input.dedication-output-patent')
            @elseif($output_code === 'BP')
                @include('form-input.dedication-output-guidebook')
            @endif
            @if($upd_mode === 'approve')
                @include('form-input.dedication-approve')
            @endif
        </div><!-- /.body-content -->
        <!--/ End body content -->

        <!-- Start footer content -->
    @include('layouts._footer-admin')
    <!--/ End footer content -->

    </section><!-- /#page-content -->
@endsection
<!--/ END PAGE CONTENT -->
