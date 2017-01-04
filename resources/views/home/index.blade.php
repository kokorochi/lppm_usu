@extends('layouts.lay_admin')

<!-- START @PAGE CONTENT -->
@section('content')
    <div id="page-content">

        <!-- Start page header -->
        <div class="header-content">
            <h2><i class="fa fa-home"></i>Beranda</h2>
            <div class="breadcrumb-wrapper hidden-xs">
                <span class="label">Direktori anda: </span>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="{{url('/')}}">Beranda</a>
                    </li>
                </ol>
            </div><!-- /.breadcrumb-wrapper -->
        </div><!-- /.header-content -->
        <!--/ End page header -->

        <!-- Start body content -->
        <div class="body-content animated fadeIn">

            <div id="blog-grid" class="announces row">
                @foreach($announces as $announce)
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="blog-item rounded shadow">
                            <a href="{{ url('announces/' . $announce->id) }}" class="blog-img">
                                <img src="{{$announce->image_name !== null ? url('images/upload/announces', $announce->image_name) : url('images/upload/announces', 'blank.png')}}"
                                     class="img-responsive full-width" alt="..."/>
                            </a>
                            <div class="blog-details">
                                <h4 class="blog-title"><a
                                            href="{{ url('announces/' . $announce->id) }}">{{$announce->title}}</a>
                                </h4>
                                <ul class="blog-meta">
                                    <li>Oleh: {{$announce->created_by_name}}</li>
                                    <li>{{ date("d M Y", strtotime($announce->created_at)) }}</li>
                                </ul>
                                <div class="blog-summary">
                                    <p>{{$announce->content}}</p>
                                    <a href="{{ url('announces/' . $announce->id) }}" class="btn btn-sm btn-success">Read
                                        More</a>
                                </div>
                            </div>
                        </div><!-- /.blog-item -->
                    </div><!-- col-md-3 -->
                @endforeach
            </div>
        </div>

        <!-- Start footer content -->
        @include('layouts._footer-admin')
        <!--/ End footer content -->
    </div><!-- /#blog-list -->

    <!--/ End blog-list -->
    {{--{{ $announces->render() }}--}}

    {{--        <p class="text-center"><img src="{{$assetUrl}}global/img/loader/general/2.gif" alt="..."/> Load more post</p>--}}
    </div><!-- /.body-content -->
    <!--/ End body content -->

    </section><!-- /#page-content -->
@stop
<!--/ END PAGE CONTENT -->
