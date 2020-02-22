@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1>Comunidad <i class="fas fa-users ml-3"></i></h1>
            <hr>
            <form method="get" action="{{route('user.index')}}">
                <div class="input-group mb-4">
                    <input class="form-control" type="text" name="search" id="search" placeholder="Buscar usuario..." aria-label="Buscar usuario..." aria-describedby="" value="">
                    <div class="input-group-append">
                        <button type="submit" class="input-group-text" id="search-btn"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            @foreach($users as $user)
                <div class="row align-items-center">
                    <div class="profile-picture col-md-4">    
                        @if($user->image)
                            <div class="text-center ml-md-5">
                                <img src="{{ route('user.image',['filename'=>$user->image]) }}" class="profilepicture cropped-users-img"/>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="user-info text-center text-md-left">    
                            <a href="{{route('user.profile',['id' => $user->id])}}" class="text-dark"><p class="h3">{{$user->name.' '.$user->surname}} | <span class="h5">{{'@'.$user->username}}</span></p>
                            <p>Se unió {{\FormatTime::LongTimeFilter($user->created_at)}}</p></a>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach

            {{-- Paginación --}}
            <div class="clearfix">
                {{$users->links()}}
            </div>

        </div>
    </div>
</div>
@endsection
