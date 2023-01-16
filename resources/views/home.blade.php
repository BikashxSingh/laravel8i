@extends('layout.apps')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-4">
                <div class="user-wrapper">
                    <ul class="users">
                        @foreach ($users as $user)
                            <li class="user" id="{{ $user->id }}">
                                {{-- <span class="pending">1</span> --}}
                                @if($user->unread)
                                    <span class="pending">{{ $user->unread }}</span>
                                @endif

                                <div class="media">
                                    <div class="media-left">
                                        <img src="{{ $user->avatar }}" alt="" class="media-object">
                                    </div>

                                    <div class="media-body">
                                        <p class="name">{{ $user->name ?? '' }}</p>
                                        <p class="email">{{ $user->email ?? '' }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-sm-8" id="messages">
                
            </div>
        </div>
    </div>
@endsection
