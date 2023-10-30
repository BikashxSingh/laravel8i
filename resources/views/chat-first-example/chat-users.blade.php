<!-- resources/views/chat.blade.php -->

@extends('layout.main')

@section('content')
    <div class="Chat Users">
        <header>
            <h1>Chat Application</h1>
            <label for="name" class="text text-danger">{{ Auth::user()->name }} @
                {{ Auth::user()->username ?? (Auth::user()->email ?? '') }}</label>
        </header>
        <div class="container">
            @foreach ($users as $user)
                <ul>
                    <li class="text-primary">
                        <h5>
                            <a href="{{ url('chat-first-example/personal-chat', $user->id) }}">
                                {{ $user->name }} @ {{ $user->username ?? ($user->email ?? '') }}
                        </h5>
                        </a>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush
