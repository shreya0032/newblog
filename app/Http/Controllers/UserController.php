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

        $userList = User::whereNotIn('name', ['super admin'])->orderBy('id','asc')->get();
        foreach($userList as $role){
            $role = $role->name;
            // dd($role);
        }
        // $userList = DB::table('users')->whereNotIn('name', ['super admin'])->select('id', 'name', 'email')->get();
        return DataTables::of($userList)
            ->addColumn('action', function ($data) {
                $dataArray = [
                    'id' => encrypt($data->id),
                ];

                $btn = '';
                $btn = '<a href=" ' . route('user.edit') . '/' . $dataArray['id'] . ' " class="edit btn btn-primary btn-sm mr-3">Edit</a>';               
                $btn .= '<a href="JavaScript:void(0);" data-action="' . route('user.delete') . '/' . $dataArray['id'] . '" data-type="delete" class="delete btn btn-danger btn-sm mr-3 deleteuser" title="Delete">Delete</a>';
                return $btn;
            })
            ->addColumn('checkbox', function($data){
                return '<input type="checkbox" name="single_checkboxUser" data-id="'.$data->id.'" />';
                 
            })
            ->rawColumns(['action', 'checkbox'])
            ->make(true);
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $values = $request->only('name', 'email', 'password');
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100|regex:/[a-zA-Z0-9\s]+/',
            'email' => 'required|email:rfc,dns|max:100|unique:users',
            'password' => 'required|min:8',
            'confirmPassword' => 'required|same:password|min:8',
            'roles' => 'required',
            'avatar' => 'mimes:jpg,jpeg,png'
        ], [
            'confirmPassword.same' => "The confirm password and password doesn't match.",
            "roles.required" => 'Please assign a role.'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $user = new User;
            $user->name = $values['name'];
            $user->email = $values['email'];
            $user->password = Hash::make($values['password']);
            $user->avatar = 'default_avatar.jpg';
            
            
            if ($user->save()) {
                $user->assignRole($request->roles);
                return response()->json(['status' => 1, 'msg' => 'New user added successfully']);
            } else {
                return response()->json(['status' => 0, 'error' => 'Problem occured']);;
            }
        }
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $roles = Role::all();
        $permissions = DB::table('permissions')->whereNotIn('name', ['add', 'edit', 'delete', 'details'])->select('id', 'name')->get();        
        $user = User::where('id', $id)->first();
        // dd($user);
        return view('admin.user.edit', compact('user', 'roles', 'permissions'));
    }


    public function update(Request $request)
    {
        $roleName = '';
        $values = $request->only('name', 'email');
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100|regex:/[a-zA-Z0-9\s]+/',
            'email' => 'required|email:rfc,dns',
            'avatar'=> 'mimes:jpg,jpeg,png|max:5000'
        ]);

        // if($request->hasfile('avatar')){
        //     $avatar = $request->file('avatar');
        //     $filename = time() . '.' . $avatar->getClientOriginalExtension();
        //     $filepath = public_path('assets/backend/dist/img/upload/' . $filename);
        //     $avatar->move($filepath,$filename);
        // }
        
        if($validator->fails()){
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }else{

            $user = User::where('id', $request->id)->first();
           
            foreach ($user->roles as $user_role) {
                $roleName = $user_role->name;
                
            }
            
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
                    return response()->json(['status' => 0, 'msg' => 'Role cannot be null']);
                }
                
            }

        }
    }

    public function userRoleDelete($userId, $roleId)
    {
        // dd($userId, $roleId);
    }

    public function delete($id)
    {  
        $user = User::find($id)->delete();
        if ($user){
            return response()->json(['status'=>1, 'type' => "success", 'title' => "Delete", 'msg'=>'User delete successsfully']);
        }else{
            return response()->json(['status'=>0, 'msg'=>'User not deleted']);
        }
    }

    public function userProfile(Request $request)
    {
        // dd(User::find($request->id)->avatar);
       
        $values = $request->only('name', 'email');
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100|regex:/[a-zA-Z0-9\s]+/',
            'email' => 'required|email:rfc,dns',
            'avatar'=> 'mimes:jpg,jpeg,png|max:5000'
        ]);
    

        if($request->hasfile('avatar')){
            if(User::find($request->id)->avatar == "default_avatar.jpg"){
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                $filepath = public_path('assets/backend/dist/img/upload/' . $filename);
                $avatar->move($filepath,$filename);
                User::where('id', $request->id)->update($avatar);
            }else{
                $avatar = $request->file('avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                $filepath = public_path('assets/backend/dist/img/upload/' . $filename);
                $avatar->move($filepath,$filename);
                $existfilename = User::find($request->id)->avatar;
                unlink($filepath,$existfilename);
                User::where('id', $request->id)->update($avatar);
            }
            
        }
        
        if($validator->fails()){
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
        else{
            User::where('id', $request->id)->update($values);
            return response()->json(['status' => 1, 'msg' => 'User Profile updated successfully']);
            // return redirect()->back();
        }
    }

    public function deleteUserSelected(Request $request){
        $checked_users_id=$request->checked_user;
        $checkedDeleted = User::whereIn('id', $checked_users_id)->delete();
        if($checkedDeleted){
            return response()->json(['status'=>1, 'msg'=>'Users delete successfully']);
        }
        else{
            return response()->json(['status'=>0, 'msg'=>'Users not deleted']);
            
        }

    }
}

 