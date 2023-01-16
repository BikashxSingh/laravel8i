@extends('layout.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="invoice">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Create New Role</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                    </div>
                </div>
            </div>

            @include('inc.messages')

            <form action="{{ route('roles.store') }}" method="post">
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
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permission:</strong>
                            <br />
                            @foreach ($permission as $value)
                                <label>
                                    

                                    <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                                        placeholder="">{{ $value->name }}
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

{{-- in value checkbox                                    {{ $role->permissions == $value->id ? 'checked' : '' }} --}}
                                    