@extends('layouts.lay_admin')

@section('content')
    <section id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-balance-scale"></i> {{ $pageTitle }} </h2>
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
                    <li class="active">Penentuan Reviewer</li>
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

            <form class="submit-form" action="{{url('reviewers/assign', $propose->id)}}" method="POST">

                @include('form-input.propose-reviewer')

                {{ csrf_field() }}

                <div class="form-footer">
                    <div class="col-sm-offset-4 col-md-offset-3">
                        <a href="{{url($deleteUrl) . '/assign'}}" class="btn btn-teal btn-slideright">Kembali</a>
                        <button type="submit" class="btn btn-success btn-slideright submit">Submit</button>
                    </div><!-- /.col-sm-offset-3 -->
                </div><ss!-- /.form-footer -->
            </form>
        </div><!-- /.body-content -->

        <!-- Start footer content -->
    @include('layouts._footer-admin')
    <!--/ End footer content -->
    </section><!-- /#page-content -->
@endsection