<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view users')->only('index');
        $this->middleware('permission:edit users')->only('edit');
        $this->middleware('permission:create users')->only('create');
        $this->middleware('permission:delete users')->only('destroy');
    }

    public function index()
    {
        $users = User::latest()->paginate(25);

        return view('users.list',[
            'users' => $users
        ]);

    }

    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('users.create',[
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);


        if ($validator->fails()) {
            return redirect()->route('users.create')->withInput()->withErrors($validator);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User added successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $hasRoles = $user->roles->pluck('name');
        $roles = Role::orderBy('name', 'ASC')->get();

        return view('users.edit',[
            'user' => $user,
            'hasRoles' => $hasRoles,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, string $id)
    {

        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$id.',id',
        ]);


        if ($validator->fails()) {
            return redirect()->route('users.edit',$id)->withInput()->withErrors($validator);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $user->syncRoles($request->role);

        return redirect()->route('users.index',$id)->with('success', 'User updated successfully.');


    }

    public function destroy(string $id)
    {
        //
    }
}
