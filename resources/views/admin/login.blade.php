@extends('layout.main')

@section('content')
    <div class="container">
        
        <h2>Login</h2>
        @include('inc.messages')
        <div class="d-flex flex-column">
            <form action="{{ route('login.store') }}" method="post">
                @csrf
                <div class="form-group p-2">
                    <label for="Email">Email</label>
                    <input type="email" name="email" id="email">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group p-2">
                    <label for="Password">Password</label>
                    <input type="password" name="password" id="password">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group p-2">
                    <input type="submit" value="Login">
                </div>

                <div class="form-row">
                    <a href="{{ route('login.github', 'github') }}" class="btn btn-secondary btn-block">Sign In with Github</a>
                </div>
                <div class="form-row">
                    <a href="{{ route('login.google', 'google') }}" class="btn btn-secondary btn-block">Sign In with Google</a>
                </div>
                <div class="form-row">
                    <a href="{{ route('login.facebook', 'facebook') }}" class="btn btn-secondary btn-block">Sign In with Facebook</a>
                </div>
                
            </form>
        </div>
    </div>
@endsection

{{-- 
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/switches.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/authentication/form-2.js') }}"></script>
@endpush --}}
