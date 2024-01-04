@props(['route'=>$route,'title'=>$title])

<!-- Delete Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acc_title">Supprimer {{$title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route($route)}}" method="post">  
                @csrf
                @method("DELETE")
                <div class="modal-body">
                    <p id="acc_msg">Êtes-vous sûr de vouloir supprimer ?</p>
                    <input type="hidden" name="id" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success si_accept_confirm">Oui</button>
                    <button type="button" class="btn btn-danger si_accept_cancel" data-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Delete Modal -->