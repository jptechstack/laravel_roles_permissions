<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        $users = User::latest()->paginate(25);

        return view('users.list',[
            'users' => $users
        ]);

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
