<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            <input type="text" name="name" id="name" value="{{ old('name', $role->name ?? '') }}">
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
                    {{-- {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
    {{ $value->name }} --}}

                    {{-- in value   {{ $role->permissions == $value->id ? 'checked' : '' }} --}}
                    <input type="checkbox" name="permission[]" value="{{ old('permission', $value->id ?? '') }}"
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