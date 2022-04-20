<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    public function index()
    {
        // $roles = Role::all();
        // $roles = Role::whereNotIn('name', ['super admin'])->get();
        return view('admin.setup_admin.roles.index');
    }

    public function getRoleList()
    {
        $roleList = DB::table('roles')->orderBy('id', 'desc')->whereNotIn('name', ['super admin'])->select('id', 'name')->get();
        
        $roleHasPermission = DB::table('roles')->whereNotIn('name', ['super admin'])
                            ->select('id', 'name')
                            ->join('role_has_permissions','')
                            ->where('role_id');
        
        return DataTables::of($roleList)
            ->addColumn('action', function ($data){
                $btn = '';
                $btn = '<a href=" ' . route('roles.edit', $data->id) . ' " class="edit btn btn-primary btn-sm mr-3">Edit</a>';
                $btn .=  '<a href="JavaScript:void(0);" data-action="' . route('roles.delete') . '/' . $data->id . '" data-type="delete" class="delete btn btn-danger btn-sm mr-3 deleterole" title="Delete">Delete</a>';
                $btn .= '<a href="'. route('roles.permission', $data->id) .' " class="edit btn btn-success btn-sm">Manage Permission</a>';
                return $btn;
            })
            // ->addColumn('manage', function($data){
                // url('roles/'.$data->id.'/permission')
            //     $manageBtn = '<a href="'.route('roles.permission') . "/". $data->id.'" class="edit btn btn-success btn-sm">Manage Permission</a>';
            // })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
    
        return view('admin.setup_admin.roles.create');
    }

    public function store(Request $request)
    {

        $values = $request->only('name');
        $validator = Validator::make($request->only('name'), [
            'name' => 'required|min:2|max:100|unique:roles'
        ],[
            'name.required' => 'The role name is required.',
            'name.min' => 'The role name must be at least 2 characters.',
            'name.max' => 'The role name cannot exit 100 characters',
            'name.unique' => 'The role name has already been taken',
        ]);

        if ($validator->fails()) {
            // return redirect()->back()->withErrors($validator)->with('error', 'Validation failed')->withInput();
            return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        } else {
            $role = new Role;
            // dd($role);
            $role->name = $values['name'];
            
            if ($role->save()) {
                
                return response()->json(['status'=>1, 'msg'=>'New role added successfully']);
            } else {
                return redirect()->back()->with('error', 'something wrong');
            }
        }
    }

    public function edit($id)
    {
        $roles = Role::findOrFail($id);
        return view('admin.setup_admin.roles.edit', compact('roles'));
    }


    public function update(Request $request)
    {
        // $validated = $request->validate(['name' => ['required']]);
        // $values = $request->only('name');
        $validator = Validator::make($request->only('name'), [
            'name' => 'required|min:2'
        ],[
            'name.required' => 'The role name is required.',
            'name.min' => 'The role name must be at least 2 characters.',
            'name.max' => 'The role name cannot exit 100 characters',
            'name.unique' => 'The role name has already been taken',
        ]);
        if($validator->fails()){
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
        else{
            $roles = Role::where('id', $request->id)->update($request->only('name'));
            if($roles){
                return response()->json(['status'=>1, 'msg'=>'Role updated successfully']);
            }
            else{
                return response()->json(['status'=>0, 'msg'=>'Role not updated']);
            }
        }
    }

    public function managePermission($id)
    {
        // $roleId = Role::pluck('id');
    
        $roles= Role::where('id', $id)->first();
        // dd($roles->permissions);
        $permissionView = DB::table('permissions')->whereIn('name', ['add', 'edit', 'details'])->get();
        $permissionTable = DB::table('permissions')->whereNotIn('name', ['add', 'edit', 'details', 'delete'])->get();
        // dd($permissionTable);
        // dd($permissions);
        $tables = DB::connection('mysql2')->select('SHOW TABLES');
        
        return view('admin.setup_admin.roles.manage_permission', compact('roles','permissionView', 'permissionTable'));
    }

    public function updatePermission(Request $request)
    {
    //    dd($request);
        $roles= Role::where('id', $request->id)->first();
        // dd($roles->hasAnyPermission(['add', 'edit', 'details', 'delete']));
        $modelRoles= DB::table('role_has_permissions')->where('role_id', $request->id)->get();
        
        // dd($modelRoles->permission_id);
        // dd($roles->hasPermissionTo($request->permission));
        // if($request != null){
        //     if($roles->hasPermissionTo($request->permission)){
        //         return response()->json(['status'=>1, 'msg'=>'Permission already exists']);
        //     }
        //     else{
        //         $roles->givePermissionTo($request->permission);
        //         return response()->json(['status'=>1, 'msg'=>'Permission added']);
        //     }
        // }
        // else{
        //     return response()->json(['status'=>1, 'msg'=>'Permission is null']);
        // }
        
        if($request->permission != null && $request->table_permission != null ){
            if($roles->hasPermissionTo($request->permission) && $roles->hasPermissionTo($request->table_permission)){
                return response()->json(['status'=>1, 'msg'=>'Permission already exists']);
            }
            else{
                $roles->givePermissionTo($request->permission);
                $roles->givePermissionTo($request->table_permission);
                app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
                return response()->json(['status'=>1, 'msg'=>'Permission added']);
            }
        }
        elseif($request->permission == null && $request->table_permission != null){
            if($roles->hasPermissionTo($request->table_permission)){
                return response()->json(['status'=>1, 'msg'=>'This table permission already exists']);
            }
            else{
                $roles->givePermissionTo($request->table_permission);
                // [\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
                app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
                return response()->json(['status'=>1, 'msg'=>'New table permission added']);
            }
            
        }
        elseif($request->permission != null && $request->table_permission == null){
            if($roles->hasPermissionTo($request->permission)){
                return response()->json(['status'=>1, 'msg'=>'Permission already exists']);
            }
            else{
                $roles->givePermissionTo($request->permission);
                app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
                return response()->json(['status'=>1, 'msg'=>'Permission added']);
            }
        }
        else{
            // if($request->permission == null){
            //     if($roles->hasAnyPermission(['add', 'edit', 'details', 'delete'])){
            //         return response()->json(['status'=>1, 'msg'=>'Table permission is null, Updated']);
            //     }
            // }

            if($roles->hasAnyPermission(['add', 'edit', 'details', 'delete'])){
                return response()->json(['status'=>1, 'msg'=>'Table permission is blank, Updated']);
            }
            else{
                return response()->json(['status'=>1, 'msg'=>'Permission is null, Please add one']);
            }
        }
    }

    public function delete($id)
    {
        $roles=Role::find($id)->delete();
        if($roles){
            return response()->json(['status'=>1, 'msg'=>'Role delete successfully']);
            // return redirect()->route('roles.index')->with('message', 'Item delete successful');
        }
        else{
            return response()->json(['status'=>1, 'msg'=>'Role not deleted']);
            // return redirect()->route('roles.index')->with('message', 'Item delete unsuccessful');
        }
    }

    public function deletePermission($rid, $pid)
    {
        // dd(Auth::user());
        $roles = DB::table('role_has_permissions')
                    ->where('role_id', $rid)
                    ->where('permission_id', $pid)
                    ->delete();
        if($roles){
            return response()->json(['status'=>1, 'msg'=>'Permission deleted successfully']);
        }
        else{
            return response()->json(['status'=>1, 'msg'=>'Permission not deleted']);
        }
    }

}
