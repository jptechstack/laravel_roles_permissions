<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //this method will show permissions page
    public function index() {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(25);

        return view('permissions.list',[
            'permissions' => $permissions
        ]);
    }

    //this method will show create permissions page
    public function create() {
        return view('permissions.create');
    }

    //this method will insert a permissions in DB
    public function store( Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions|min:3'
        ]);

        if($validator->passes()) {

            Permission::create(['name' => $request->name]);

            return redirect()->route('permissions.index')->with('success', 'Permission added successfully.');

        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    //this method will show edit permissions page
    public function edit($id) {
        $permissions = Permission::findOrFail($id);

        return view('permissions.edit',[
            $permissions => $permissions
        ]);
    }

    //this method will update a permissions
    public function update() {

    }

    //this method will delete a permissions in DB
    public function destroy() {

    }
}
