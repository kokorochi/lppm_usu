{{--Get Old Value And Place It To VARIABLE--}}
@php($ctr_old = 0)

@while(
$errors->has('display.' . $ctr_old) || old('display.' . $ctr_old) ||
$errors->has('nidn.' . $ctr_old) || old('nidn.' . $ctr_old) )
    @php
        $dedication_reviewer = new \App\Dedication_reviewer;
        $dedication_reviewer['display']  = old('display.' . $ctr_old);
        $dedication_reviewer['nidn']     = old('nidn.' . $ctr_old);

        if($dedication_reviewers->get($ctr_old) === null){
            $dedication_reviewers->add($dedication_reviewer);
        }else{
            if($dedication_reviewers[$ctr_old]->disabled !== 'readonly')
            {
                $dedication_reviewers[$ctr_old] = $dedication_reviewer;
            }
        }
        $ctr_old++;
    @endphp
@endwhile
{{--Get Old Value And Place It To VARIABLE--}}

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="pull-left">
                    <h3 class="panel-title">Penentuan Reviewer</h3>
                </div>
                <div class="pull-right">
                    <a class="btn btn-sm" data-action="collapse" data-container="body" data-toggle="tooltip"
                       data-placement="top" data-title="Collapse"><i class="fa fa-angle-up"></i></a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body no-padding">
                <div class="form-body form-horizontal form-bordered">
                    <div class="reviewer-wrapper">
                        @foreach($dedication_reviewers as $key => $dedication_reviewer)
                            <div class="form-group">
                                <label for="nidn[]" class="col-sm-4 col-md-3 control-label">Reviewer</label>
                                <div class="col-sm-6 input-icon right chosen-select-container">
                                    <select name="nidn[]" class="chosen-select" {{$disable_reviewer === true ? 'disabled' : ''}}>
                                        @foreach($reviewers as $reviewer)
                                            <option value="{{$reviewer->nidn}}" {{$reviewer->nidn === $dedication_reviewer->nidn ? 'selected' : ''}}>{{$reviewer->full_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if($disable_reviewer !== true)
                                    <div class="col-sm-1">
                                        <a href="#" class="remove_field btn btn-sm btn-danger btn-stroke">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </div>
                                @endif
                            </div><!-- /.form-group -->
                        @endforeach
                    </div> <!-- /.member-wrapper -->
                </div><!-- /.form-body -->
                @if($disable_reviewer !== true)
                    <div class="form-footer">
                        <div class="col-sm-offset-4 col-md-offset-3">
                            <a href="#" class="add-reviewer-button btn btn-success btn-stroke btn-slideright"><i
                                        class="fa fa-plus"></i></a>
                        </div><!-- /.col-sm-offset-3 -->
                    </div><!-- /.form-footer -->
                @endif
            </div>
        </div>
    </div>
</div>