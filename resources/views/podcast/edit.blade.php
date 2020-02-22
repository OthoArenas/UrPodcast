@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class='card'>
                    <div class='card-header'>
                        Editar Podcast
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('podcast.update') }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" value="{{$post->id}}" name="post_id">

                            <div class="form-group row">
                                <label for="post_path" class="col-md-3 col-form-label text-md-right">Podcast</label>
                                <div class="col-md-7">
                                    <audio controls class="audiocontrols">
                                        <source src="{{ route('podcast.file',[
                                            'filename' => $post->post_path
                                        ]) }}" type="audio/mp3">
                                    </audio>

                                    {{-- Mostrar con checkbox --}}
                                    Escoger otro archivo de audio: <input type="checkbox" id="checkPodcast" onclick="showChecked()">
                                    
                                    <input id="post_path" style="display:none" class="form-control @error('post_path') is-invalid mb-3 @enderror" type="file" name="post_path">

                                    @if($errors->has('post_path'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$errors->first('post_path')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-3 col-form-label text-md-right">Descripción</label>
                                <div class="col-md-7">
                                    <textarea id="description" class="form-control @error('description') is-invalid mb-3 @enderror" name="description">{{$post->description}}</textarea>
                                    @if($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$errors->first('description')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-3">
                                    {{-- <input class="btn btn-success" type="submit" name="podcast-submit" value="Subir Podcast"> --}}
                                    <button type="submit" class="btn btn-success" name="podcast-submit">Actualizar Podcast <i class="fas fa-cloud-upload-alt ml-1"></i></button>
                                    <a href="{{route('podcast.detail',['id' => $post->id])}}" class="btn btn-secondary float-right text-white" name="podcast-submit">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function showChecked() {
        // Get the checkbox
        var checkBox = document.getElementById("checkPodcast");
        // Get the output text
        var text = document.getElementById("post_path");

        // If the checkbox is checked, display the output text
        if (checkBox.checked == true){
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    }
</script>
