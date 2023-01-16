@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="invoice">

<div class="container">
    <div class="justify-content-center">
      
        @include('inc.messages')
        
        <div class="card">
            <div class="card-header">Permission
                @can('role-create')
                    <span class="float-right">
                        <a class="btn btn-primary" href="{{ route('permissions.index') }}">Back</a>
                    </span>
                @endcan
            </div>
            <div class="card-body">
                <div class="lead">
                    <strong>Name:</strong>
                    {{ $permission->name }}
                </div>
            </div>
        </div>
    </div>
</div>
    </section>
</div>
@endsection