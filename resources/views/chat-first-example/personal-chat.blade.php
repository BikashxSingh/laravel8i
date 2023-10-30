<!-- resources/views/chat.blade.php -->

@extends('layout.main')

@section('content')
    {{-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Chats</div>

                <div class="panel-body">
                    <chat-messages :messages="messages"></chat-messages>
                </div>
                <div class="panel-footer">
                    <chat-form
                        v-on:messagesent="addMessage"
                        :user="{{ Auth::user() }}"
                    ></chat-form>
                </div>
            </div>
        </div>
    </div>
</div> --}}

    <div class="app">
        <header>
            <h1>Chat Application</h1>
            <label for="name" class="text text-danger">From: {{ Auth::user()->name }} @
                {{ Auth::user()->username ?? (Auth::user()->email ?? '') }}</label>
            @auth
                <label for="name" class="user" id="{{ $user->id }}">To: {{ $user->name }} @
                    {{ $user->username ?? ($user->email ?? '') }}</label>
                <input type="hidden" name="username" value="{{ $user->username }}" id="username" class="username">

                <div class="row">
                    <div class="col-2">
                        <a href="{{ url('chat-first-example/chat-users') }}" class="container text text-danger" class="">
                            <button class="btn btn-success">
                                Chat Users
                            </button>
                        </a>
                    </div>
                    <div class="col-2">
                        <a href="{{ url('chat-first-example/chat') }}" class="container text text-danger" class="">
                            <button class="btn btn-success">
                                Public Chat
                            </button>
                        </a>
                    </div>
                </div>
            @endauth
        </header>
        {{-- @if (Auth::user())
            
        @endif --}}

        <div id="messages">

        </div>
        <form action="post" id="message_form">
            <input type="hidden" name="userid" value="{{ $user->id }}">
            <input type="text" name="message" id="message_input" placeholder="Enter message">
            <button type="submit" id="message_send">Send</button>
            {{-- onclick="myFunction()" --}}
            {{-- <script>
                function myFunction() {
                    const element = document.getElementById("message_send");
                    element.scrollIntoView();
                }
            </script> --}}
        </form>
    </div>
@endsection

@push('styles')
@endpush
@push('scripts')
    <script>
        // const message_el = document.getElementById("messages");
        // // const username_input = document.getElementById("username");
        // const message_input = document.getElementById("message_input");
        // const message_form = document.getElementById("message_form");


        // message_form.addEventListener('submit', function(e) {
        //     e.preventDefault();
        //     console.log(e);
        //     let has_errors = false;

        //     // if (username_input.value == "") {
        //     //     alert('Enter a username');
        //     //     has_errors = true;
        //     // }

        //     if (message_input.value == "") {
        //         alert('Enter a message');
        //         has_errors = true;
        //     }

        //     if (has_errors) {
        //         return;
        //     }

        //     const options = {
        //         method: 'post',
        //         url: "{{ route('chat-first-example.sendMessages', $user->id) }}",
        //         data: {
        //             // username: $username_input.value,
        //             message: message_input.value
        //         }
        //     }

        //     axios(options);

        // });

        // console.log('sdf');
        // console.log(Echo);

        // window.Echo.channel('chat')
        // .listen('.data', (e) => {
        //         console.log(e);
        //         message_el.innerHTML += '<div class="message"><strong>' + e.username + ':</strong>' + e.message +
        //             '</div>';
        //     });
        // . in message is required casue we are returning 'message' in Message Event and without . returning wont work cause we
        // have to add app/event/message

        const message_el1 = document.getElementById("messages");
        // const username_input = document.getElementById("username");
        const message_input1 = document.getElementById("message_input");
        const message_form1 = document.getElementById("message_form");

        var data = $('#message_form').serialize(); //form data

        message_form1.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log(e);
            let has_errors = false;

            // if (username_input.value == "") {
            //     alert('Enter a username');
            //     has_errors = true;
            // }

            if (message_input1.value == "") {
                alert('Enter a message');
                has_errors = true;
            }

            if (has_errors) {
                return;
            }

            // $('.user').on('click', function() {
            // user_id = $(this).attr('id');
            // });

            console.log("{{ $user->id }}");
            // var url = "{{ route('chat-first-example.sendMessages', ':id') }}";
            // url = url.replace(':id', user_id);
            const options = {
                method: 'post',
                url: "{{ route('chat-first-example.sendMessages') }}",
                data: {
                    data,
                    // username: $username_input.value,

                    // message: message_input1.value,
                    // userid: "{{ $user->id }}"
                }
            }

            axios(options);

        });
    </script>
@endpush
