<div class="card pub_image mb-4">
    <div class="card-header">
        @if($post->user->image)
            <div class="mr-3 image-circle">
                <img src="{{ route('user.image',['filename'=>$post->user->image]) }}" class="profilehomepic cropped-img"/>
            </div>
        @endif
        <div class="data-user ml-5">
            <a href="{{ route('user.profile', ['id' => $post->user->id]) }}" class="text-reset">
                {{$post->user->name.' '.$post->user->surname}}<small class="username_header">{{' - @'.$post->user->username}}</small>
            </a>
        </div>
        
    </div>

    <div class="card-body">
        <audio controls class="audiocontrols">
            <source src="{{ route('podcast.file',[
                'filename' => $post->post_path
            ]) }}" type="audio/mp3">
        </audio>
        <a href="{{ route('podcast.detail', ['id' => $post->id]) }}" class="float-right text-success"><i class="fas fa-eye mr-1"></i> Ver detalle</a>
        <div class="description px-4 mt-3">
            <span class="username_description"><i class="fa fa-user mr-2" aria-hidden="true"></i>{{'@'.$post->user->username}}</span>
            <span class="username_description">{{'  |  '.\FormatTime::LongTimeFilter($post->created_at)}}</span>
            <p>{{$post->description}}</p> 
        </div>
        <div class="likes ml-4 mt-2 text-secondary row align-items-center">
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
            <div class="comments-post float-right ml-auto mr-3">    
                <a href="{{ route('podcast.detail', ['id' => $post->id]) }}" class="btn btn-warning btn-comments">
                    <i class="fas fa-comment-dots mr-1 text-secondary"></i> Comentarios ({{count($post->comments)}})
                </a>
            </div>
        </div>
    </div>
</div>
