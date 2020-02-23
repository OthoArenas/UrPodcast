@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="user-profile">
                <div class="row align-items-center">
                    <div class="profile-picture col-md-4">    
                        @if($user->image)
                            <div class="text-center ml-5">
                                <img src="{{ route('user.image',['filename'=>$user->image]) }}" class="profilepicture cropped-profile-img"/>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="user-info ml-4">    
                            <p class="h1">Perfil de {{$user->name.' '.$user->surname}} | <span class="h3">{{'@'.$user->username}}</span></p>
                            <p>Se unió {{\FormatTime::LongTimeFilter($user->created_at)}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <h3 class="text-center">Próximamente transmitirá</h3>
            @foreach($broadcasts as $broadcast)
                @include('includes.broadcast',['broadcast'=>$broadcast])
            @endforeach
            <hr>

            <h3 class="text-center">Podcast de {{$user->name}}</h3>
            @foreach($user->posts as $post)
                @include('includes.post',['post'=>$post])
            @endforeach
        </div>
    </div>
</div>
@endsection
