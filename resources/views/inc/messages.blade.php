@if (count($errors)  > 0)
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            {{$error}}
        </div>
    @endforeach
    
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if (Session::get('error'))
    <div class="alert alert-danger">
        {{Session::get('error')}}
    </div>
@endif

{{-- @if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif --}}


{{-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif --}}