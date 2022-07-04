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
                $dataArray = [
                    'id' => encrypt($data->id),
                ];
                $btn = '';
                $btn = '<a href=" ' . route('roles.edit', $dataArray['id']) . ' " class="edit btn btn-primary btn-sm mr-3">Edit</a>';
                $btn .=  '<a href="JavaScript:void(0);" data-action="' . route('roles.delete') . '/' . $dataArray['id'] . '" data-type="delete" class="delete btn btn-danger btn-sm mr-3 deleterole" title="Delete">Delete</a>';
                $btn .= '<a href="'. route('roles.permission', $dataArray['id']) .' " class="edit btn btn-success btn-sm">Manage Permission</a>';
                return $btn;
            })
            ->addColumn('checkbox', function($data){
                return '<input type="checkbox" name="single_checkbox" class="checkBoxClass" data-id="'.$data->id.'" />';
                 
            })
            ->rawColumns(['action', 'checkbox'])
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
        $id = decrypt($id);
        $roles = Role::findOrFail($id);
        return view('admin.setup_admin.roles.edit', compact('roles'));
    }


    public function update(Request $request)
    {
        
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
        $id = decrypt($id);
        $roles= Role::where('id', $id)->first();
        $permissionView = DB::table('permissions')->whereIn('name', ['add', 'edit', 'details'])->get();
        $permissionTable = DB::table('permissions')->whereNotIn('name', ['add', 'edit', 'details', 'delete'])->get();       
        $tables = DB::connection('mysql2')->select('SHOW TABLES');
        
        return view('admin.setup_admin.roles.manage_permission', compact('roles','permissionView', 'permissionTable'));
    }

    public function updatePermission(Request $request)
    {
   
        $roles= Role::where('id', $request->id)->first();
       
        $modelRoles= DB::table('role_has_permissions')->where('role_id', $request->id)->get();

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
        $id = decrypt($id);
        $roles=Role::find($id)->delete();
        if($roles){
            return response()->json(['status'=>1, 'msg'=>'Role delete successfully']);
        }
        else{
            return response()->json(['status'=>1, 'msg'=>'Role not deleted']);
            
        }
    }

    public function deleteSelected(Request $request)
    {
        $checked_roles_id=$request->checked_roles_ids;
        $checkedDeleted = Role::whereIn('id', $checked_roles_id)->delete();
        if($checkedDeleted){
            return response()->json(['status'=>1, 'msg'=>'Role delete successfully']);
        }
        else{
            return response()->json(['status'=>0, 'msg'=>'Role not deleted']);
            
        }
    }

    public function deletePermission($rid, $pid)
    {
        
        $roles = DB::table('role_has_permissions')
                    ->where('role_id', $rid)
                    ->where('permission_id', $pid)
                    ->delete();
        if($roles){
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
            return response()->json(['status'=>1, 'msg'=>'Permission deleted successfully']);
        }
        else{
            return response()->json(['status'=>0, 'msg'=>'Permission not deleted']);
        }
    }

}
