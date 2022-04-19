<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use App\Helpers\LogActivity;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    
    public function getUserList()
    {

        $userList = User::orderBy('id', 'desc')->whereNotIn('name', ['super admin'])->get();
        foreach($userList as $role){
            $role = $role->name;
            // dd($role);
        }
        // $userList = DB::table('users')->whereNotIn('name', ['super admin'])->select('id', 'name', 'email')->get();
        return DataTables::of($userList)
            ->addColumn('action', function ($data) {
                $delete_url= ''.route('user.delete' , $data->id );
                $btn = '';
                $btn = '<a href=" ' . route('user.edit') . '/' . $data->id . ' " class="edit btn btn-primary btn-sm mr-3">Edit</a>';
                // $btn .=  '<a href=" ' . route('user.delete') . '/' . $data->id . ' " class="delete btn btn-danger btn-sm deleteuser">Delete</a>';
                $btn .= '<a href="JavaScript:void(0);" data-action="' . route('user.delete') . '/' . $data->id . '" data-type="delete" class="delete btn btn-danger btn-sm mr-3 deleteuser" title="Delete">Delete</a>';
                return $btn;
            })
            // ->addColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {

        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $values = $request->only('name', 'email', 'password');
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100|regex:/[a-zA-Z0-9\s]+/',
            'email' => 'required|email:rfc,dns|max:100|unique:users',
            'password' => 'required|min:8',
            'confirmPassword' => 'required|same:password|min:8'
        ]);
        if ($validator->fails()) {
            // return redirect()->back()->withErrors($validator)->with('error', 'Validation failed')->withInput();
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $user = new User;
            $user->name = $values['name'];
            $user->email = $values['email'];
            $user->password = Hash::make($values['password']);

            // $user = User::create($values);
            if ($user->save()) {
                // return view('admin.user.index',  compact('user'));
                $user->assignRole('user');
                return response()->json(['status' => 1, 'msg' => 'New user added successfully']);
            } else {
                return response()->json(['status' => 0, 'msg' => 'Problem occured']);;
            }
        }
    }

    public function edit($id)
    {
        $roles = Role::all();
        // $permissions = Permission::all();
        $permissions = DB::table('permissions')->whereNotIn('name', ['add', 'edit', 'delete', 'details'])->select('id', 'name')->get();
        // dd($permissions);
        $user = User::where('id', $id)->first();
        // dd($user);
        return view('admin.user.edit', compact('user', 'roles', 'permissions'));
    }


    public function update(Request $request)
    {
        $roleName = '';
        
        // $validated = $request->validate([
        //     'name' => 'required|min:2',
        //     'email' => 'required|email:rfc,dns|max:100',
        // ]);

        $values = $request->only('name', 'email');
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100|regex:/[a-zA-Z0-9\s]+/',
            'email' => 'required|email:rfc,dns',
        ]);
        
        if($validator->fails()){
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }else{

            $user = User::where('id', $request->id)->first();
            // dd($user->roles);
            foreach ($user->roles as $user_role) {
                $roleName = $user_role->name;
                
            }
            // dd($roleName);
            if($user->hasAnyRole($roleName)){
                
                if ($request->roles != null){
                    if ($roleName != $request->roles) {
                        $user->removeRole($roleName);
                        $user->assignRole($request->roles);
                        User::where('id', $request->id)->update($values);
                        return response()->json(['status' => 1, 'msg' => 'Role added, User updated successfully']);
                    
                    }else {
                        User::where('id', $request->id)->update($values);
                        return response()->json(['status' => 1, 'msg' => 'User updated successfully']);
                    }
                }else {
                    
                    User::where('id', $request->id)->update($values);
                    return response()->json(['status' => 1, 'msg' => 'User updated successfully']);
                }
            }
            else {
                if($request->roles != null){
                    $user->assignRole($request->roles);
                    return response()->json(['status' => 1, 'msg' => 'Role assigned']);
                }else{
                    return response()->json(['status' => 1, 'msg' => 'Role cannot be null']);
                }
                
            }


            // if($user->hasAnyRole($roleName)){
            //     dd($roleName);
            // }

        }
        












        // $values = $request->only('name', 'email');
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|min:2|max:100',
        //     'email' => 'required|email:rfc,dns',
        // ]);

       
        // if ($validator->fails()) {
        //     return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        // } else {
        //     // $userDetails = new User;
        //     $user = User::where('id', $request->id)->first();
        //     // dd($user->permissions);

        //     foreach ($user->roles as $user_role) {
        //         $roleName = $user_role->name;
               
        //     }
        //     // foreach ($user->permissions as $user_permissions) {
        //     //     print_r($user_permissions->name);
        //     //     exit();
        //     //     $permissionsName = $user_permissions->name;
        //     //     print_r($permissionsName);
                
        //     // }

        //     if ($user->hasAnyRole($roleName)) {
        //         if ($request->roles != null && $request->permission != null) {
        //             if ($roleName != $request->roles) {
        //                 $user->removeRole($roleName);
        //                 $user->assignRole($request->roles);
        //                 $user->givePermissionTo([$request->permission]);
        //                 User::where('id', $request->id)->update($values);
        //                 // DB::table('users')->where('id', $request->id)
        //                 return response()->json(['status' => 1, 'msg' => 'User updated successfully']);
        //             } else {
        //                 User::where('id', $request->id)->update($values);
        //                 return response()->json(['status' => 1, 'msg' => 'User updated successfully']);
        //             }
        //         } else {
        //             // $user->syncPermissions([$request->permission]);
        //             User::where('id', $request->id)->update($values);
        //             return response()->json(['status' => 1, 'msg' => 'User updated successfully']);
        //         }
        //     }
        //     else{
        //         return response()->json(['status' => 1, 'msg' => 'Role cannot be null']);
        //     }
        // }


        // if ($request->roles != null) {
        //     echo('not null');
        // }
        // else{
        //     echo('null');
        // }
    }

    public function userRoleDelete($userId, $roleId)
    {
        // dd($userId, $roleId);
    }

    public function delete($id)
    {   
        // return response()->json(['status'=>1, 'msg'=>'User delete successsfully'.$id]);

        $user = User::find($id)->delete();
        if ($user) {
            // return redirect()->route('user.index')->with('message', 'Item delete successful');
           return response()->json(['status'=>1, 'type' => "success", 'title' => "Delete", 'msg'=>'User delete successsfully']);
        } else {
            return response()->json(['status'=>0, 'msg'=>'User not deleted']);
        }
    }
    public function testUrl()
    {
        return route('user.delete', 1);
    }
}
