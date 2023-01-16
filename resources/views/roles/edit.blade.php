@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="invoice">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Edit Role: {{ $role->name }}</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                    </div>
                </div>
            </div>

            @include('inc.messages')


            {{-- {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!} --}}
            <form action="{{ route('roles.update', $role->id) }}" method="post">
                @csrf
                @method('PATCH')
                {{-- @include('roles.commonForm') --}}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permission:</strong>
                            <br />
                            @foreach ($permission as $value)
                                <label>
                                         <input type="checkbox" name="permission[]" value="{{ old('permission', $value->id) }}"
                                        {{ $role->permissions()->where('id', $value->id)->first() != null? 'checked': '' }}>{{ $value->name }}
                                </label>
                                <br />
                            @endforeach
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>

        </section>
    </div>
@endsection
{{-- {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
        {{ $value->name }} --}}
