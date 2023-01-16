{{-- <!DOCTYPE html>
<html>

<head>
    <title>Multiple Payment Gateway Integration With Laravel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
</head>

<body> --}}
@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="invoice">
            @include('inc.messages')

            <div class="container">
                <div class="pt-md-5">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4">
                                <div class="card" style="width: 18rem;">
                                    <div class="image_container" style="height: 150px;">
                                        <img src="{{ asset(Storage::url($product->pImage ?? '')) }}" class="card-img-top"
                                            style="width: 150px; height: 150px;">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->title }}</h5>
                                        <p class="card-text">Rs. {{ $product->price }}</p>
                                        <p class="card-text">{{ $product->short_description }}</p>
                                        <form method="post" action="{{ route('checkout') }}">
                                            {{-- {{ csrf_field() }} --}}
                                            @csrf
                                            <input type="hidden" name="pid" value="{{ $product->id }}">
                                            <input type="submit" name="submit" value="Buy Now">
                                        </form>
                                    </div>
                                    <br>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
{{-- </body>

</html> --}}
