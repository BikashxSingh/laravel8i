<div class="message-wrapper">
    <ul class="messages">
        @foreach($messages as $message)
            <li class="message clearfix">
                {{--if message from id is equal to auth id then it is sent by logged in user --}}
                <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'received' }}">
                    <p>{{ $message->message }}</p>
                    <p class="date">{{ date('d M y, h:i a', strtotime($message->created_at)) }}</p>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<div class="input-text">
    {{-- <div class="d-flex"> --}}
        {{-- <div class="mr-auto p-2"> --}}
            <input type="text" name="message" class="submit">
        {{-- </div> --}}
        {{-- <div class="ml-auto p-2"> --}}
            <button type="submit" id="submit_message" class="btn btn-primary">Send</button>
        {{-- </div> --}}
    {{-- </div> --}}
</div>