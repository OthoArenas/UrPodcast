@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.showmessage')
            @if(count($broadcasts)>=1)    
            <h2 class="text-center">Próximas transmisiones en vivo</h2>
                @foreach($broadcasts as $broadcast)
                    @if(strtotime(now()) >= (strtotime($broadcast->starts_at) + 4500))
                    @php
                        EndBroadcast::EndBroadcast($broadcast->id);
                    @endphp
                    @endif
                    @include('includes.broadcast',['broadcast'=>$broadcast])
                @endforeach
            <hr>
            @endif
            <h2 class="text-center">Podcasts de la comunidad</h2>
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

<script type="text/javascript">
   setTimeout(function(){
       console.log("Recargando");
       location.reload();
   },60000);
</script>
