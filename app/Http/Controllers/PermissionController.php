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
        $permissionList = DB::table('permissions')->whereIn('name', ['add', 'edit', 'delete', 'details'])->select('id', 'name')->get();
        return DataTables::of($permissionList)
            ->addIndexColumn()
            // ->addColumn('action', function ($data){
            //     $btn = '';
            //     $btn = '<a href=" ' . route('permission.edit') . '/' . $data->id. ' " class="edit btn btn-primary btn-sm">Edit</a>';
            //     $btn .=  '<a href=" ' . route('permission.delete') .' " class="delete btn btn-danger btn-sm deleteuser">Delete</a>';
            //     return $btn;
            // })

            // ->rawColumns(['action'])
            ->make(true);
    }

    public function getTableList()
    {
        $permissionTable = DB::table('permissions')->whereNotIn('name', ['add', 'edit', 'delete', 'details'])->select('id', 'name')->get();
        // dd($permissionTable);
        return DataTables::of($permissionTable)
            ->addIndexColumn()
            ->addColumn('action', function ($data){
                    $btn = '';
                    $btn = '<a href=" ' . route('permission.edit', $data->id) .' " class="edit btn btn-primary btn-sm">Edit</a>';
                    return $btn;
                })
    
                ->rawColumns(['action'])
            ->make(true);
    }
    
    public function create()
    {
        return view('admin.setup_admin.permission.create');
    }
    
    public function store(Request $request)
    {   
        // $table = '';
        // $tables = DB::connection('mysql2')->select('SHOW TABLES');
        // foreach($tables as $table){
        //     Permission::create($tables);
        // }
        // dd($request);

        $values = $request->only('name');
        $validator = Validator::make($request->only('name'), [
            'name' => 'required|min:2|max:100|unique:permissions'
        ]);
        

        if ($validator->fails()) {
           return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        } else {
            $permission = new Permission;
            $permission->name = $values['name'];
            if ($permission->save()) {

                // $superAdmin = User::where('name', 'super admin')->first();
                // $superAdmin->givePermissionTo($permission->id);
                
                return response()->json(['status'=>1, 'msg'=>'New permission added successfully']);
            } else {
                return response()->json(['status'=>0, 'msg'=>'Permission not added']);
            }
        }
        // $validated = $request->validate(['name' => ['required', 'min:3']]);
        // Permission::create($validated);
        // return redirect()->route('permission.index');
    }

    public function edit($id)
    {
        
        // $permission = Permission::where('id', $id)->first();
        $permission = Permission::findOrFail($id);
        // dd($permission);
        // dd($permission);
        return view('admin.setup_admin.permission.edit', compact('permission'));
    }


    public function update(Request $request)
    {
        // $validated = $request->validate(['name' => ['required']]);
        
        // $permission = Permission::where('id', $request->id)->update($validated);
        // if($permission){
        //     return redirect()->route('permission.index');
        // }
        // else{
        //     return redirect()->back()->with('message', 'not updated');
        // }



        $values = $request->only('name');
        $validator = Validator::make($request->only('name'), [
            'name' => 'required|min:2|max:100'
        ]);
        

        if ($validator->fails()) {
           return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);
        } else {
            $permission = new Permission;
            $permission->name = $values['name'];
            if ($permission->save()) {

                // $superAdmin = User::where('name', 'super admin')->first();
                // $superAdmin->givePermissionTo($permission->id);
                
                return response()->json(['status'=>1, 'msg'=>'Permission updated successfully']);
            } else {
                return response()->json(['status'=>0, 'msg'=>'Permission not added']);
            }
        }

    }



    public function delete($id)
    {
        $permission=Permission::find($id)->delete();
        if($permission){
            return redirect()->route('permission.index')->with('message', 'Item delete successful');
        }
        else{
            return redirect()->route('permission.index')->with('message', 'Item delete unsuccessful');
        }
    }

    
}
