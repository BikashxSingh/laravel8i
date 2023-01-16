<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
    <strong>Name:</strong>
    <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '')  }}">
    @error('name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
    <strong>Email:</strong>
    <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}">
    @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12">
    <div class="form-group">
    <strong>Username:</strong>
    <input type="text" name="username" id="username" value="{{ old('username', $user->username ?? '') }}">
    @error('username')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<strong>Password:</strong>
<input type="password" name="password" id="password">
@error('password')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
    <strong>Confirm Password:</strong>
    <input type="password" name="password_confirmation" id="password">
    @error('password_confirmation')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
    <strong>Role:</strong>
    {{-- {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!} --}}
    <select name="roles[]" id="roles" class="form-control" multiple>
        @foreach ($roles as $role)
        <option value="{{ old('roles', $role->id) }}">{{ $role->name }}</option>
        @endforeach
    </select>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 text-center float-left">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
