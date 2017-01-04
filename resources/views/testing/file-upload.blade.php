@extends('layouts.lay_admin')

@section('content')
<section id="page-content">

    <!-- Start page header -->
    <div class="header-content">
        <h2><i class="fa fa-bullhorn"></i> Upload Files </h2>
        <div class="breadcrumb-wrapper hidden-xs">
            <span class="label">Direktori anda:</span>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{url('/')}}">Home</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    Upload Files
                    <i class="fa fa-angle-right"></i>
                </li>
                <li class="active">Upload</li>
            </ol>
        </div><!-- /.breadcrumb-wrapper -->
    </div><!-- /.header-content -->
    <!--/ End page header -->

    <div class="body-content animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="panel rounded shadow">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h3 class="panel-title">Upload Files</h3>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip" data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div><!-- /.panel-heading -->

                    <div class="panel-body no-padding">
                        <form class="form-horizontal form-bordered" action="{{url('files/upload')}}" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label">File input widget type 1</label>
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                        <span class="input-group-addon btn btn-success btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="image"></span>
                                        <a href="#" class="input-group-addon btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>

                                </div><!-- /.form-group -->

                                {{ csrf_field() }}

                                <div class="form-footer">
                                    <div class="col-sm-offset-3">
                                        <a href="{{url('announces')}}" class="btn btn-danger btn-slideright">Cancel</a>
                                        <button type="submit" class="btn btn-success btn-slideright">Submit</button>
                                    </div>
                                </div>
                            </div><!-- /.form-body -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
     </div><!-- /.body-content -->

    <!-- Start footer content -->
    @include('layouts._footer-admin')
    <!--/ End footer content -->
</section><!-- /#page-content -->
@endsection