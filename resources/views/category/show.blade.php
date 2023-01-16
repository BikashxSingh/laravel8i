@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="invoice">

            <!-- Table row -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 table-responsive">

                        <h2>{{ $category->title }} </h2>
                        <a href="/storage/{{ $category->myfile }}">
                            <img src="{{ asset(\Storage::url($category->myfile)) }}" style="max-width: 25%;max-height: 25%;">
                        </a>
                        <h3>{{ $category->status }}</h3>
                        <h3>{{ $category->parentCategory['title'] }}</h3>

                    </div><!-- /.col -->
                </div><!-- /.row -->

            </div>
        </section>
    </div>
@endsection
