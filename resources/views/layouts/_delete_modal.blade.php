<!-- Delete Confirmation Dialog Box -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-trash-o"></i> Konfirmasi Penghapusan</h4>
            </div>
            <div class="modal-body">
                <p>{{ $deleteQuestion }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tidak
                </button>
                {{--<button type="button" class="btn btn-theme"><i class="fa fa-check"></i> Ya</button>--}}
                <form class="delete_action pull-right" action="{{ url( $deleteUrl . '/actionid') }}" method="POST">
                    <button class="btn btn-theme" name="submit">
                        <i class="fa fa-check"></i> Ya
                    </button>
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="DELETE">
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->