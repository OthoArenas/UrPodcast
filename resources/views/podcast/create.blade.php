@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class='card'>
                    <div class='card-header'>
                        Subir nuevo Podcast
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('podcast.save') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="post_path" class="col-md-3 col-form-label text-md-right">Podcast</label>
                                <div class="col-md-7">
                                    <input id="post_path" class="form-control @error('post_path') is-invalid mb-3 @enderror" type="file" name="post_path" >

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
                                    <textarea id="description" class="form-control @error('description') is-invalid mb-3 @enderror" name="description"></textarea>
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
                                    <button type="submit" class="btn btn-success" name="podcast-submit">Subir Podcast <i class="fas fa-cloud-upload-alt ml-1"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

