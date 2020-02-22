<!-- The Modal -->
<div class="modal" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Eliminar Podcast</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        ¿Estás seguro de que quieres eliminar tu podcast? Ya no habrá rastro de la publicación y comentarios...
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <a href="{{route('podcast.delete',['id'=>$post->id])}}" class="btn btn-danger">Eliminar</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>