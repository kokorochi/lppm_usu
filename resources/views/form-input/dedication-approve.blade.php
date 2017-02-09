{{--Get Old Value And Place It To VARIABLE--}}
@if(
$errors->has('sumErrors')
)
    @php
        if(old('revision_text')) $dedication_output_revision->revision_text = old('revision_text');
    @endphp
@endif
{{--Get Old Value And Place It To VARIABLE--}}

<div class="row">
    <div class="col-md-12">
        <div class="panel rounded shadow">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Luaran</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <form action="{{url($deleteUrl, $dedication->id) . '/approve'}}" method="post"
                      class="form-body form-horizontal form-bordered submit-form">
                    <div class="form-group">
                        <label for="is_approved" class="col-sm-4 col-md-3 control-label">Disetujui</label>
                        <div class="col-sm-7">
                            <div class="rdio rdio-theme circle">
                                <input id="radio-yes" value="yes" type="radio" name="is_approved" {{ ( old('is_approved') === "yes" || old('is_approved') === null ) ? 'checked="checked"' : ''}}>
                                <label for="radio-yes">Ya</label>
                            </div>
                            <div class="rdio rdio-theme circle">
                                <input id="radio-no" value="no" type="radio" name="is_approved" {{ old('is_approved') === "no"  ? 'checked="checked"' : ''}}>
                                <label for="radio-no">Tidak</label>
                            </div>
                        </div>
                        <div id="revision-text-wrapper">
                            @include('form-input.dedication-approve-revisiontext')
                        </div>
                    </div>

                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">

                    <div class="clearfix"></div>
                    <div class="form-footer">
                        <div class="col-sm-offset-4 col-md-offset-3">
                            <a href="{{url($deleteUrl . '/approve-list')}}" class="btn btn-teal btn-slideright">Kembali</a>
                            <button type="submit" class="btn btn-success btn-slideright submit">Simpan</button>
                        </div><!-- /.col-sm-offset-3 -->
                    </div><!-- /.form-footer -->
                </form>
            </div>
        </div>
    </div>
</div>