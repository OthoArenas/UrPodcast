<div class="card pub_image mb-4">
    <div class="card-header">
    <h4>"{{$broadcast->title}}"</h4>
        @if($broadcast->user->image)
            <div class="mr-3 image-circle">
                <img src="{{ route('user.image',['filename'=>$broadcast->user->image]) }}" class="profilehomepic cropped-img"/>
            </div>
        @endif
        <div class="data-user ml-5">
            <a href="{{ route('user.profile', ['id' => $broadcast->user->id]) }}" class="text-reset">
                {{$broadcast->user->name.' '.$broadcast->user->surname}}<small class="username_header">{{' - @'.$broadcast->user->username}}</small>
            </a>
        </div>
        
    </div>

    <div class="card-body">
        @php
            /* Para traducción al español */
            setlocale(LC_TIME, 'es_ES.UTF-8');
        @endphp
        @if(strtotime(now())>=strtotime($broadcast->starts_at))    
            <audio controls class="audiocontrols">
                <source src="{{ route('podcast.file',[
                    'filename' => $broadcast->post_path
                ]) }}" type="audio/mp3">
            </audio>
            <a href="{{ route('broadcast.detail', ['id' => $broadcast->id]) }}" class="float-right text-success">Ir a transmisión en vivo <i class="fas fa-broadcast-tower mx-1"></i></a>
        @endif
        @if($broadcast->user_id == \Auth::user()->id && strtotime(now())<strtotime($broadcast->starts_at))
            <a href="{{ route('broadcast.detail', ['id' => $broadcast->id]) }}" class="float-right text-success"><i class="fas fa-eye mr-1"></i> Ver detalle</a>
        @endif
        <div class="description px-4 mt-3">
            <span class="username_description"><i class="fa fa-user mr-2" aria-hidden="true"></i>{{'@'.$broadcast->user->username}}</span>
            <span class="username_description">{{'  |  Publicado: '.\FormatTime::LongTimeFilter($broadcast->created_at)}}</span>
            <p class="pt-3">{{$broadcast->description}}</p> 
            <p>La transmisión iniciará: {{strftime("%A, %d de %B de %Y", strtotime($broadcast->starts_at))}} a las {{date('h:i A',strtotime($broadcast->starts_at))}}</p>
        </div>
        <div class="likes ml-4 mt-2 text-secondary row align-items-center">
        
        </div>
    </div>
</div>
