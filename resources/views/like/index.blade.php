@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Mis Podcast Favoritos</h1>
            <hr>
        
            @foreach($likes as $like)
                @include('includes.post',['post'=>$like->post])
            @endforeach

            {{-- Paginación --}}
            <div class="clearfix">
                {{$likes->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
