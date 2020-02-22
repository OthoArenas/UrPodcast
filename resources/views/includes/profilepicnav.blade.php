@if (Auth::user()->image)
    <div class="ml-4 image-cropper">
        <img src="{{ route('user.image',['filename'=>Auth::user()->image]) }}" class="profilepic img-fluid cropped-img"/>
    </div>
@endif