@extends('layout.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="invoice">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>

@include('inc.messages')

<form action="{{ route('users.store') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            <input type="text" name="name" id="name">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email:</strong>
            <input type="email" name="email" id="email">
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
    </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Username:</strong>
            <input type="text" name="username" id="username">
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
        {{-- @dd($roles) --}}
        <div class="form-group">
            <strong>Role:</strong>
            {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
            <select name="roles[]" id="roles" class="form-control" multiple>
                @foreach ($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
                
                {{-- if pluck is used --}}
                {{-- @foreach ($roles as $id=>$role)
                <option value="{{ $id }}">{{ $role }}</option>
                @endforeach --}}
            </select>
        </div>
    </div>
    <br>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center ">
        <button type="submit" class="btn btn-primary" >Submit</button>
    </div>
    <br>
</div>

</form>
{{-- {!! Form::close() !!} --}}
</section>
</div>
@endsection