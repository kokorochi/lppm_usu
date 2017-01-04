@extends('layouts.lay_admin')

<!-- START @PAGE CONTENT -->
@section('content')
    <div id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-home"></i> Home </h2>
            <div class="breadcrumb-wrapper hidden-xs">
                <span class="label">Direktori anda: </span>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{url('dashboard/index')}}">Home</a>
                    </li>
                </ol>
            </div><!-- /.breadcrumb-wrapper -->
        </div><!-- /.header-content -->
        <!--/ End page header -->

        <!-- Start body content -->
        <div class="body-content animated fadeIn">

            <div id="blog-grid" class="row">
                @foreach($announces as $announce)
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="blog-item rounded shadow">
                            <a href="blog-single.html" class="blog-img">
                                <img src="{{$announce->image_name !== null ? url('images/upload/announces', $announce->image_name) : url('images/upload/announces', 'blank.png')}}"
                                     class="img-responsive full-width" alt="..."/>
                            </a>
                            <div class="blog-details">
                                <h4 class="blog-title"><a href="">{{$announce->title}}</a>
                                </h4>
                                <ul class="blog-meta">
                                    <li>By: {{$announce->created_by}}</li>
                                    <li>@php(echo date("d M Y", strtotime($announce->created_at)))</li>
                                </ul>
                                <div class="blog-summary">
                                    <p>{{$announce->content}}</p>
                                    <a href="{{ url('announce/' . $announce->id) }}" class="btn btn-sm btn-success">Read
                                        More</a>
                                </div>
                            </div>
                        </div><!-- /.blog-item -->
                    </div><!-- col-md-3 -->

                    {{--<div class="blog-item blog-quote rounded shadow">--}}
                    {{--<div class="quote quote-primary">--}}
                    {{--<a href="blog-single.html">--}}
                    {{--{{ $announce->title }}--}}
                    {{--<small class="quote-author">{{ $announce->created_by }}</small>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                    {{--<div class="blog-details">--}}
                    {{--<h4 class="blog-title"><a--}}
                    {{--href="{{ url('announce/' . $announce->id) }}">{{ $announce->title }}</a>--}}
                    {{--</h4>--}}
                    {{--<ul class="blog-meta">--}}
                    {{--<li>By: {{ $announce->created_by }}</li>--}}
                    {{--<li>--}}
                    {{--<?php echo date("d M Y", strtotime($announce->created_at)) ?>--}}
                    {{--</li>--}}
                    {{--<li><a href="">3 Comments</a></li>--}}
                    {{--</ul>--}}
                    {{--<div class="blog-summary">--}}
                    {{--<p>{{ $announce->content }}</p>--}}
                    {{--<a href="{{ url('announce/' . $announce->id) }}" class="btn btn-sm btn-success">Read--}}
                    {{--More</a>--}}
                    {{--</div>--}}
                    {{--</div><!-- blog-details -->--}}
                    {{--</div><!-- /.blog-item -->--}}
                @endforeach
            </div>
        </div>

        <!--/ End blog-list -->
        {{ $announces->render() }}

        {{--        <p class="text-center"><img src="{{$assetUrl}}global/img/loader/general/2.gif" alt="..."/> Load more post</p>--}}

    </div><!-- /.body-content -->
    <!--/ End body content -->

    <!-- Start footer content -->
    @include('layouts._footer-admin')
    <!--/ End footer content -->

    </section><!-- /#page-content -->
@stop
<!--/ END PAGE CONTENT -->
