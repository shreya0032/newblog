<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::all();
        return view('admin.setup_admin.permission.index');
    }

    public function getPermissionList()
    {
        $permissionList = DB::table('permissions')->whereIn('name', ['add', 'edit', 'details'])->select('id', 'name')->get();
        return DataTables::of($permissionList)
            ->make(true);
    }

    public function getTableList()
    {
        $permissionTable = DB::table('permissions')->orderBy('id', 'asc')->whereNotIn('name', ['add', 'edit', 'details'])->select('id', 'name')->get();
        // $permissionTable = DB::table('permissions')->orderBy('id', 'asc')->select('id', 'name')->get();
        return DataTables::of($permissionTable)
            ->addColumn('action', function ($data) {
                $btn = '<a href="JavaScript:void(0);" data-action="' . route('permission.delete') . '/' . $data->id . '" data-type="delete" class="delete btn btn-danger btn-sm mr-3 deletepermission" title="Delete">Delete</a>';
                return $btn;
            })
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" name="permission_singlechkbx" class="checkBoxClass" data-id="' . $data->id . '" />';
            })

            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function create()
    {

        return view('admin.setup_admin.permission.create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $values = $request->only('name');
        $validator = Validator::make($request->only('name'), [
            'name' => 'required|min:2|max:100|unique:permissions'
        ], [
            'name.required' => 'The permission name is required.',
            'name.min' => 'The permission name must be at least 2 characters.',
            'name.max' => 'The permission name cannot exit 100 characters',
            'name.unique' => 'The table name for permission has already been taken',
        ]);


        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $permission = new Permission;
            $permission->name = $values['name'];
            if ($permission->save()) {
                // return redirect()->back()->withErrors($validator)->with('error', 'Validation failed')->withInput();
                return response()->json(['status' => 1, 'msg' => 'New permission added successfully']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Permission not added']);
            }
        }
    }

    // public function edit($id)
    // {
    //     $permission = Permission::findOrFail($id);
    //     return view('admin.setup_admin.permission.edit', compact('permission'));
    // }


    // public function update(Request $request)
    // {
    //     $values = $request->only('name');
    //     $validator = Validator::make($request->only('name'), [
    //         'name' => 'required|min:2|max:100'
    //     ],[
    //         'name.required' => 'The permission name is required.',
    //         'name.min' => 'The permission name must be at least 2 characters.',
    //         'name.max' => 'The permission name cannot exit 100 characters',
    //         'name.unique' => 'The permission name has already been taken',
    //     ]);


    //     if ($validator->fails()) {
    //        return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
    //     } else {
    //         $permission = new Permission;
    //         $permission->name = $values['name'];
    //         if ($permission->save()) {

    //             return response()->json(['status'=>1, 'msg'=>'Permission updated successfully']);
    //         } else {
    //             return response()->json(['status'=>0, 'msg'=>'Permission not added']);
    //         }
    //     }

    // }



    public function delete($id)
    {
        
        $permission = Permission::find($id)->delete();
        if ($permission) {
            return response()->json(['status' =>1, 'msg'=>'Permission for table deleted successfully']);
        } else {
            return response()->json(['status' =>0, 'msg'=>'Permission for table not deleted']);
        }
    }

    public function deleteSelectedPermission(Request $request)
    {
        $checked_permission_id=$request->checked_permission;
        $checkedDeleted = Permission::whereIn('id', $checked_permission_id)->delete();
        if($checkedDeleted){
            return response()->json(['status'=>1, 'msg'=>'Permission for table deleted successfully']);
        }
        else{
            return response()->json(['status'=>0, 'msg'=>'Permission for table not deleted']);
            
        }
    }
}
