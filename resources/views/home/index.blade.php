@extends('layouts.lay_admin')

<!-- START @PAGE CONTENT -->
@section('content')
    <section id="page-content">

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
                <div class="announce-home">
                    @foreach($announces as $announce)
                        <div class="announce-item col-lg-3 col-md-3 col-sm-4 col-xs-12">
                            <div class="blog-item rounded shadow">
                                <a href="{{ url('announces/' . $announce->id) }}">
                                    <img src="{{$announce->image_name !== null ? url('images/upload/announces', $announce->image_name) : url('images/upload/announces', 'blank.png')}}"
                                         class="blog-img img-responsive full-width" alt="..."/>
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
                                        <a href="{{ url('announces/' . $announce->id) }}"
                                           class="btn btn-sm btn-success">Read
                                            More</a>
                                    </div>
                                </div>
                            </div><!-- /.blog-item -->
                        </div><!-- col-md-3 -->
                    @endforeach
                    {{ $announces->links() }}
                </div>
            </div>
            <p id="announce-load" class="text-center"></p>
        </div>

        <!-- Start footer content -->
    @include('layouts._footer-admin')
    <!--/ End footer content -->
    </section><!-- /#page-content -->
@endsection
<!--/ END PAGE CONTENT -->
