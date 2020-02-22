@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.showmessage')
            @foreach($posts as $post)
                @include('includes.post',['post'=>$post])
            @endforeach
            {{-- Paginación --}}
            <div class="clearfix">
                {{$posts->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
