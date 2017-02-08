@extends('layouts.lay_admin')

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
                        <a href="{{url('/')}}">Beranda</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        {{ $pageTitle }}
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">Ubah Pengabdian</li>
                </ol>
            </div><!-- /.breadcrumb-wrapper -->
        </div><!-- /.header-content -->
        <!--/ End page header -->

        <div class="body-content animated fadeIn">

            @include('form-input.panel-errors')

            @include('form-input.propose-scheme')

            @include('form-input.propose-partner')

            @include('form-input.propose-member')

            @include('form-input.propose-detail')

            @include('form-input.propose-upload')

            @include('form-input.propose-revision')

            <form class="submit-form" action="{{url($deleteUrl, $dedication->id) . '/edit-progress'}}" method="POST"
                  enctype="multipart/form-data">
                @include('form-input.dedication-progress')
            </form>

            @if($status_code !== 'LK')
                <form class="submit-form" action="{{url($deleteUrl, $dedication->id) . '/edit-final'}}" method="POST"
                      enctype="multipart/form-data">
                    @include('form-input.dedication-final')
                </form>
            @endif
        </div><!-- /.body-content -->

        <!-- Start footer content -->
    @include('layouts._footer-admin')
    <!--/ End footer content -->
    </section><!-- /#page-content -->
@endsection