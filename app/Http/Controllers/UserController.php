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
use Illuminate\Support\Facades\Storage;

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
            'roles' => 'required',
            'avatar'=> 'mimes:jpg,jpeg,png|max:5000'
        ]);
        
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
                        return response()->json(['status' => 1, 'msg' => 'User updated successfully']);
                    
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
                    return response()->json(['status' => 1, 'msg' => 'Role updated']);
                }else{
                    return response()->json(['status' => 0, 'error' => 'Role cannot be null']);
                }
                
            }

        }
    }


    public function delete($id)
    { 
        $id = decrypt($id); 
        $user = User::find($id)->delete();
        if ($user){
            return response()->json(['status'=>1, 'type' => "success", 'title' => "Delete", 'msg'=>'User delete successsfully']);
        }else{
            return response()->json(['status'=>0, 'msg'=>'User not deleted']);
        }
    }
    public function deleteUserSelected(Request $request)
    {
        $checked_users_id=$request->checked_user;
        $checkedDeleted = User::whereIn('id', $checked_users_id)->delete();
        if($checkedDeleted){
            return response()->json(['status'=>1, 'msg'=>'Users delete successfully']);
        }
        else{
            return response()->json(['status'=>0, 'msg'=>'Users not deleted']);
            
        }

    } 


    public function userProfile(Request $request)
    {
        
        $values = $request->only('user_name', 'user_email');
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|min:2|max:100|regex:/[a-zA-Z0-9\s]+/',
            'user_email' => 'required|email:rfc,dns',
        ]);
        if($validator->fails()){
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
        else{
            User::where('id', $request->profile_id)->update(['name' => $values['user_name'], 'email' => $values['user_email']]);
            return response()->json(['status' => 1, 'msg' => 'User Profile updated successfully']);                
        }
        
        
    }

    public function userAvatar(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|mimes:jpg,jpeg,png'
        ],[
            'avatar.required' => 'Please choose a file',
        ]);
            
        if(!$validator->fails())
        {
            $image = $request->file('avatar');
            $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/backend/dist/img/upload/'),$filename);
            if($user->avatar != "default_avatar.jpg"){
                unlink(public_path('assets/backend/dist/img/upload/' . $user->avatar));
                User::where('id', $request->id)->update(['avatar' => $filename]);
            }else{
                User::where('id', $request->id)->update(['avatar' => $filename]);
            }
            return response()->json(['status' => 1, 'msg' => 'User Profile Avatar updated successfully']);
        }else{
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
    }

    public function getuserProfile($id)
    { 
        $user = User::where('id', $id)->first();
        return response()->json(['status' =>1, 'user' => $user]);
        // $username = $user->name;
        // $useremail = $user->email;
    }
}

