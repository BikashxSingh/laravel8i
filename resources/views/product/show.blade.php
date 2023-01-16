@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="invoice">

            <!-- Table row -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 table-responsive">

                        <div class="container">
                            <h1>{{ $showproduct->title }} </h1>
                        </div>
                        <a href="{{ asset(\Storage::url($showproduct->pImage)) }}">
                            <img src="{{ asset(\Storage::url($showproduct->pImage)) }}" alt=""
                                style="height: 100%; max-width: 50%; border: 1px solid red;">
                        </a>
                        <h3>Short Description:
                        </h3>
                        <div class="container">

                            <p>{{ $showproduct->short_description }}</p>
                        </div>

                        <h3>Long description:</h3>
                        <div class="container">

                            <p>{{ $showproduct->long_description }}</p>
                        </div>
                        <h3>Status:</h3>
                        <div class="container">

                            <p>{{ $showproduct->status }}</p>
                        </div>
                        <h3>Category:</h3>
                        <div class="container">
                            <p>{{ $showproduct->thecategory->title ?? '-' }}</p>

                        </div>

                        <h3>Price:</h3>
                        <div class="container">
                            <p>{{ $showproduct->price }}</p>

                        </div>

                        <h3>Specifications:</h3>
                        {{-- @foreach ($showproduct->theSpecifications as $item)
                        <h3>Title:</h3>
                        <div class="container">
                            <p>{{ $item->title }}</p>

                        </div>

                        <h3>Specification:</h3>
                        <div class="container">
                            <p>{{ $item->description }}</p>

                        </div>
                        @endforeach --}}
                        <div class="row">
                            <div class="col-md col-md-8">
                                <table class="table table-bordered table-specifications">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Title</th>
                                            <th>Specification</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($showproduct->theSpecifications as $key => $item)
                                            <tr data-row={{ $key + 1 }}>
                                                <th>{{ $key + 1 }}</th>
                                                <th>{{ $item->title }}</th>
                                                <th>{{ $item->description }}</th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div>
        </section>
    </div>
@endsection
