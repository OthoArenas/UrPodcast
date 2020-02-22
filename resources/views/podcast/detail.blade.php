@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @include('includes.showmessage')
            
            <div class="card pub_image mb-4 pub_image_detail">
                <div class="card-header">
                    @if($post->user->image)
                        <div class="mr-3">
                            <img src="{{ route('user.image',['filename'=>$post->user->image]) }}" class="profilehomepic cropped-img"/>
                        </div>
                        <div class="data-user ml-5">
                            <a href="{{route('user.profile',['id'=>$post->user->id])}}" class="text-dark">{{$post->user->name.' '.$post->user->surname}}<small class="username_header">{{' - @'.$post->user->username}}</small></a>
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    <audio controls class="audiocontrols">
                        <source src="{{ route('podcast.file',[
                            'filename' => $post->post_path
                        ]) }}" type="audio/mp3">
                    </audio>
                    <div class="description px-3 mt-3">
                        <span class="username_description">{{'@'.$post->user->username}}</span>
                        <span class="username_description">{{'  |  '.\FormatTime::LongTimeFilter($post->created_at)}}</span>
                        <p>{{$post->description}}</p> 
                    </div>
                    <div>
                        <div class="likes ml-3 mt-2 text-secondary">
                        {{-- Comprobar si el usuario autenticado ha dado like a post --}}
                            @php
                                $user_like = false;
                            @endphp
                            @foreach($post->likes as $like)
                                @if($like->user->id == \Auth::user()->id)
                                    @php
                                        $user_like = true;
                                    @endphp
                                @endif
                            @endforeach

                            @if($user_like)
                                <i class="fa fa-heart fa-lg btn-dislike text-danger mr-1" data-id="{{$post->id}}" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-heart fa-lg btn-like mr-1" data-id="{{$post->id}}" aria-hidden="true"></i>
                            @endif
                            @include('includes.meGusta')
                            @if(\Auth::user() && \Auth::user()->id == $post->user->id)    
                                <div class="actions float-right">
                                    <a href="{{route('podcast.edit',['id' => $post->id])}}" class="mx-2 text-success"><i class="fas fa-edit mr-1"></i> Editar</a>
                                    <a href="" data-toggle="modal" data-target="#deleteModal" class="mx-2 text-success"><i class="fas fa-trash mr-1"></i> Borrar</a>

                                    @include('includes.deleteModal')
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="comments ml-3 mt-3">    
                        <h2>Comentarios ({{count($post->comments)}})</h2>
                    </div>

                    <hr class="mt-1 mb-4">

                    <form method="post" action="{{route('comment.save')}}">
                        @csrf
                        <input type="hidden" name="post_id" value="{{$post->id}}">
                        <p>
                            <div class="form-group">
                                <textarea id="content" class="form-control @error('content') is-invalid mb-3 @enderror" name="content" rows="3" placeholder="Ingresa un comentario..."></textarea>
                                @if($errors->has('content'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{$errors->first('content')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </p>
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                <button type="submit" class="btn btn-success float-right">Enviar comentario <i class="fa fa-share-square ml-1" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>
                    @foreach($post->comments as $comment)
                        <div class="comment">
                            <img src="{{ route('user.image',['filename'=>$comment->user->image]) }}" class="cropped-comment-img mr-1"/>
                            <a href="{{route('user.profile',['id'=>$comment->user->id])}}"><span class="username_description">{{'@'.$comment->user->username}}</span></a>
                            <span class="username_description">{{'  |  '.\FormatTime::LongTimeFilter($comment->created_at)}}</span>
                            <p class="card-header py-2 px-4 my-2">{{$comment->content}} 
                                @if(\Auth::check() && ($comment->user_id == \Auth::user()->id) || ($comment->post->user_id == \Auth::user()->id))    
                                    <a href="" class="text-danger font-weight-bold float-right" data-toggle="modal" data-target="#deleteCommentModal"> <i class="fas fa-trash mr-1"></i> Eliminar comentario </a>

                                    @include('includes.deleteCommentModal')
                                @endif
                            </p> 
                            
                        </div>
                    @endforeach
                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
