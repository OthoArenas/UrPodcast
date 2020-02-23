<!-- The Modal -->
<div class="modal" id="deleteBroadcastModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Concluir transmisión en vivo</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        ¿Estás seguro de que quieres concluir tu transmisión en vivo?
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <a href="{{route('broadcast.end',['id'=>$broadcast->id])}}" class="btn btn-danger">Concluir</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>