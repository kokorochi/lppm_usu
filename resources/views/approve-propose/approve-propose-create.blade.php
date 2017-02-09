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
                    <li class="active">Assign</li>
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

            @if(!$dedication_reviewers->isEmpty())
                @include('form-input.propose-reviewer')
            @endif

            <form class="submit-form" action="{{url('approve-proposes', $propose_relation->propose->id) . '/approve'}}" method="POST">

                @include('form-input.propose-revision')

                {{ csrf_field() }}

                <input type="hidden" name="_method" value="PUT">

                <div class="form-footer">
                    <div class="col-sm-offset-4 col-md-offset-3">
                        <a href="{{url($deleteUrl)}}" class="btn btn-teal btn-slideright">Kembali</a>
                        <button name="rejected" value="1" type="submit" class="btn btn-danger btn-slideright submit">Ditolak
                        </button>
                        <button name="approved" value="1" type="submit" class="btn btn-success btn-slideright submit">
                            Disetujui
                        </button>
                    </div><!-- /.col-sm-offset-3 -->
                </div>
                <!-- /.form-footer -->
            </form>
        </div><!-- /.body-content -->

        <!-- Start footer content -->
    @include('layouts._footer-admin')
    <!--/ End footer content -->
    </section><!-- /#page-content -->
@endsection