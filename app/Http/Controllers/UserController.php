<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserListResource;

class UserController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        // $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user-delete', ['only' => ['destroy']]);

        if (\Request::is('api*')) {
            $this->middleware(['auth:api'], ['except' => ['', '']]);
        }
    }
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->paginate(5);
        if (\Request::is('api*')) {
            return UserListResource::collection($users);
        } else {
            return view('users.index', compact('users'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:password_confirmation',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->get('roles')); //spatie

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        // $roles = Role::pluck('name', 'id')->all();
        $userRole = $user->roles->all();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'email' => 'required|email|unique:users,email,' . $id,
            'email' => 'required|email|unique:users,email,',
            'password' => 'same:password_confirmation',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')
            ->where('model_id', $id)
            ->delete();

        $user->assignRole($request->input('roles')); //Spatie

        // $user->update($request->validated());
        // $user->syncRoles($request->get('role'));


        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        if (\Request::is('api*')) {
            return new UserResource($user);
        } else {
            return view('users.show', compact('user'));
        }
    }


    public function loginIndex()
    {
        return view('admin.login');
    }

    public function loginStore(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('dashboard')->with('success', 'User Logged In');
        }

        return back()->with('error', 'Credentials do not match')
            ->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged Out');
    }
}
