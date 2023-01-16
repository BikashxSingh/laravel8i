@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="invoice">

<div class="container">
    <div class="justify-content-center">
        
        @include('inc.messages')
        
        <div class="card">
            <div class="card-header">Create New permission
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('permissions.index') }}">Permissions List</a>
                </span>
            </div>
            <div class="card-body">
                <form action="{{ route('permissions.store') }}" method="post">
                    @csrf
                    {{-- @include('roles.commonForm') --}}
                    
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <input type="text" name="name" id="name" value="{{ old('name') }}">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                
                {{-- {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
                    <div class="form-group">
                        <strong>Name:</strong>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                {!! Form::close() !!} --}}
            </div>
        </div>
    </div>
</div>
</section>
</div>
@endsection