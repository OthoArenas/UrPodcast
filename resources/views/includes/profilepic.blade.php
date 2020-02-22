@if (Auth::user()->image)
    <div class="text-center">
        <img src="{{ route('user.image',['filename'=>Auth::user()->image]) }}" class="profilepic rounded img-fluid"/>
    </div>
@endif