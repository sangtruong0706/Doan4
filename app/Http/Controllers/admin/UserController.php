<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request) {
        $users = User::latest();
        if (!empty($request->get('keyword'))) {
            $users = $users->where('name','like','%'.$request->get('keyword').'%');
            $users = $users->orWhere('email','like','%'.$request->get('keyword').'%');
        }
        $users = $users->paginate(10);
        $data['users'] = $users;
        return view('admin.user.list', $data);
    }
    public function create() {
        return view('admin.user.create');
    }
    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
            'phone' => 'required',
        ]);
        if ($validator->passes()){
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            $user->status = $request->status;
            $user->save();
            session()->flash('success', 'Create user successfully');
            return response()->json([
                'status' => true,
                'message' => 'Create user successfully',
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function edit($user_id) {
        $user = User::where('id',$user_id)->first();
        if ($user == null) {
            session()->flash('error', 'User not found');
            return redirect()->route("users.index");
        }
        $data['user'] = $user;
        return view('admin.user.edit', $data);
    }
    public function update(Request $request, $user_id) {
        $user = User::where('id',$user_id)->first();
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
            'phone' => 'required',
        ]);
        if ($validator->passes()){
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password != '') {
                $user->password = Hash::make($request->password);
            }
            $user->phone = $request->phone;
            $user->status = $request->status;
            $user->save();
            session()->flash('success', 'Update user successfully');
            return response()->json([
                'status' => true,
                'message' => 'Update user successfully',
            ]);
        }else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function destroy($user_id) {
        $user = User::where('id', $user_id)->first();
        if ($user == null) {
            session()->flash('error', 'User not found');
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ]);
        }
        $user->delete();
        session()->flash('success', 'Delete user successfully');
        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully',
        ]);
    }
}
