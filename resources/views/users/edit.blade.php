@extends('layout.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="invoice">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>

@include('inc.messages')

{{-- {{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!} --}}
  

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            <input type="text" name="name" id="name" value="{{ $user->name }}">
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            <input type="email" name="email" id="email" value="{{ $user->email }}">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
            <strong>Username:</strong>
            <input type="text" name="username" id="username" value="{{ $user->username }}">
            @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
        <strong>Password:</strong>
        <input type="password" name="password" id="password">
        @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Confirm Password:</strong>
            <input type="password" name="password_confirmation" id="password">
            @error('password_confirmation')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Role:</strong>
            {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
            <select name="roles[]" id="roles" class="form-control" multiple>
                @foreach ($roles as $role)
                <option value="{{ old('roles', $role->id) }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center float-left">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>

</form>

</section>
</div>
@endsection