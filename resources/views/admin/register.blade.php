@extends('layout.main')

@section('content')
    <div class="container">
        <h2>Register</h2>

        @include('inc.messages')

        <form action="{{ route('register.store') }}" method="post">
            @csrf
            <div class="div">
                <label for="Name">Name</label>
                <input type="text" name="name" id="name">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="div">
                <label for="Email">Email</label>
                <input type="email" name="email" id="email">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="div">

                <label for="Username">Username</label>
                <input type="text" name="username" id="username">
                @error('username')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="div">
                <label for="Password">Password</label>
                <input type="password" name="password" id="password">
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="div">
                <label for="Password_confirmation">Password Confirmation</label>
                <input type="password" name="password_confirmation" id="password">
                @error('password_confirmation')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="div">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
@endsection
