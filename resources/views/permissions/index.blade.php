@extends('layout.app')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="invoice">

    <div class="container">
        <div class="justify-content-center">

            @include('inc.messages')

            <div class="card">
                <div class="card-header">Permissions
                    @can('role-create')
                        <span class="float-right">
                            <a class="btn btn-primary" href="{{ route('permissions.create') }}">New Permission</a>
                        </span>
                    @endcan
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th width="280px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $key => $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <a class="btn btn-success"
                                            href="{{ route('permissions.show', $permission->id) }}">Show</a>
                                        @can('role-edit')
                                            <a class="btn btn-primary"
                                                href="{{ route('permissions.edit', $permission->id) }}">Edit</a>
                                        @endcan
                                        @can('role-delete')
                                            {{-- {!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id], 'style' => 'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!} --}}
                                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $permissions->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
