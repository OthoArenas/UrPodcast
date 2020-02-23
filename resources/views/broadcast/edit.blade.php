@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class='card'>
                    <div class='card-header'>
                        Editar Transmisión en vivo
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('broadcast.update') }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" value="{{$broadcast->id}}" name="broadcast_id">

                            <div class="form-group row">
                                <label for="title" class="col-md-3 col-form-label text-md-right">Título</label>
                                <div class="col-md-7">
                                <input type="text" id="title" class="form-control @error('title') is-invalid mb-3 @enderror" name="title" value="{{$broadcast->title}}">
                                    @if($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$errors->first('title')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="post_path" class="col-md-3 col-form-label text-md-right">Podcast</label>
                                <div class="col-md-7">
                                    <audio controls class="audiocontrols">
                                        <source src="{{ route('podcast.file',[
                                            'filename' => $broadcast->post_path
                                        ]) }}" type="audio/mp3">
                                    </audio>

                                    {{-- Mostrar con checkbox --}}
                                    <div class="mt-3">
                                        Escoger otro archivo de audio: <input type="checkbox" id="checkPodcast" onclick="showChecked()">
                                    </div>
                                    
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
                                    <textarea id="description" class="form-control @error('description') is-invalid mb-3 @enderror" name="description">{{$broadcast->description}}</textarea>
                                    @if($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$errors->first('description')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="starts_at" class="col-md-3 col-form-label text-md-right">Cambiar fecha y hora de inicio</label>
                                <div class="col-md-7">
                                <input type="datetime-local" id="starts_at" class="form-control @error('starts_at') is-invalid mb-3 @enderror" name="starts_at" value="{{date('Y-m-d\TH:i:s',strtotime($broadcast->starts_at))}}">
                                    <p class="mt-3">Aviso: La duración máxima por Podcast es de 1:15 horas.</p>
                                    @if($errors->has('starts_at'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{$errors->first('starts_at')}}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-3">
                                    {{-- <input class="btn btn-success" type="submit" name="podcast-submit" value="Subir Podcast"> --}}
                                    <button type="submit" class="btn btn-success" name="broadcast-submit">Actualizar transmisión <i class="fas fa-broadcast-tower"></i></button>
                                    <a href="{{route('broadcast.detail',['id' => $broadcast->id])}}" class="btn btn-secondary float-right text-white" name="podcast-submit">Cancelar</a>
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
