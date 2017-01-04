@if($errors->has('sumErrors'))
    <div class="row">
        <div class="col-md-12">
            <div class="panel rounded shadow">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h3 class="panel-title">Errors</h3>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                           data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div><!-- /.panel-heading -->

                <div class="panel-body no-padding">
                    <div class="form-body form-horizontal form-bordered">
                        <div class="form-body">
                            <div class="form-group">
                                <ul class="list-group">
                                @foreach($errors->get("sumErrors") as $error)
                                    <div class="col-sm-3"></div>
                                    <label class="error col-sm-7 text-danger" for="sumErrors"
                                           style="display: inline-block;">
                                        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                                    </label>
                                @endforeach
                                </ul>
                            </div><!-- /.form-group -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif