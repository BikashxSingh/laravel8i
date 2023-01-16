@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="invoice">

<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Opps!</strong> Something went wrong, please check below errors.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">Edit permission: {{ $permission->name }}
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
                                <input type="text" name="name" id="name" value="{{ old('name', $permission->name) }}">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                
                </form>
                {{-- {!! Form::model($permission, ['route' => ['permissions.update', $permission->id], 'method'=>'PATCH']) !!}
                    <div class="form-group">
                        <strong>Name:</strong>
                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                {!! Form::close() !!} --}}
            </div>
        </div>
    </div>
</div>
</section>
</div>
@endsection