@php
    $counter=0;
@endphp
@if(count($post->likes)>1)
A    
    @foreach($post->likes as $like)
        {{'@'.$like->user->username}}
        @php
            $counter++;
            break;
        @endphp
    @endforeach
    @foreach($post->likes as $like)
        @if($like->user->id == \Auth::user()->id)
            @php
                $counter++;
            @endphp
            @if((count($post->likes)-$counter)>0)
                , a ti
            @else
                y a ti les gusta esto.
            @endif
            @php
                break;
            @endphp
        @endif
    @endforeach
    @if((count($post->likes)-$counter)>0)
        y a {{count($post->likes)-$counter}} persona(s) más les gusta esto.
    @endif
@elseif(count($post->likes)==1)
A
    @foreach($post->likes as $like)
        @if($like->user->id == \Auth::user()->id)
            ti te gusta esto.
        @else
        {{'@'.$like->user->username}} le gusta esto.
        @endif
    @endforeach
@elseif(count($post->likes)==0)
Sé el primero en decir que te gusta.
@endif