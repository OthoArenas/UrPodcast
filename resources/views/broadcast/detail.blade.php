@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @include('includes.showmessage')
            
            <div class="card pub_image mb-4 pub_image_detail">
                <div class="card-header">
                    <h3>{{$broadcast->title}}</h3>
                    @if($broadcast->user->image)
                        <div class="mr-3">
                            <img src="{{ route('user.image',['filename'=>$broadcast->user->image]) }}" class="profilehomepic cropped-img"/>
                        </div>
                        <div class="data-user ml-5">
                            <a href="{{route('user.profile',['id'=>$broadcast->user->id])}}" class="text-dark">{{$broadcast->user->name.' '.$broadcast->user->surname}}<small class="username_header">{{' - @'.$broadcast->user->username}}</small></a>
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    <audio controls class="audiocontrols">
                        <source src="{{ route('podcast.file',[
                            'filename' => $broadcast->post_path
                        ]) }}" type="audio/mp3">
                    </audio>
                    <div class="description px-3 mt-3">
                        <span class="username_description">{{'@'.$broadcast->user->username}}</span>
                        <span class="username_description">{{'  |  '.\FormatTime::LongTimeFilter($broadcast->created_at)}}</span>
                        <p class="mt-2">{{$broadcast->description}}</p> 
                        @php
                            /* Para traducción al español */
                            setlocale(LC_TIME, 'es_ES.UTF-8');
                        @endphp
                        @if(strtotime(now())>=strtotime($broadcast->starts_at))    
                            <span class="username_description">Inició a las {{date('H:i A', strtotime($broadcast->starts_at))}} y terminará aproximadamente a las {{date('H:i A', (strtotime($broadcast->starts_at)+4500))}}</span>
                            <p class="username_description mt-3">Posteriormente este Podcast será guardado y publicado para que puedas volver a escucharlo. </p>
                        @else
                            <span class="username_description">La transmisión iniciará: {{strftime("%A, %d de %B de %Y", strtotime($broadcast->starts_at))}} a las {{date('h:i A',strtotime($broadcast->starts_at))}}</span>
                        @endif
                    </div>

                    @if($broadcast->user_id == \Auth::user()->id && strtotime(now())>=strtotime($broadcast->starts_at))    
                        <div class="end-btn">
                            <a href="" class="btn btn-danger float-right" data-toggle="modal" data-target="#deleteBroadcastModal">Concluir transmisión</a>
                        </div>

                        @include('includes.endBroadcastModal')
                    @else
                        <div class="actions float-right">
                            <a href="{{route('broadcast.edit',['id' => $broadcast->id])}}" class="mx-2 text-success"><i class="fas fa-edit mr-1"></i> Editar</a>
                            <a href="" data-toggle="modal" data-target="#deleteBroadcastModal" class="mx-2 text-success"><i class="fas fa-trash mr-1"></i> Borrar</a>

                            @include('includes.deleteBroadcastModal')
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
