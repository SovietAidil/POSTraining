<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        confirmDelete('Delete User', 'Are you sure you want to delete this user?');
        return view("users.index", compact("users"));
    }
    public function store(Request $request){
        $id = $request->id;
        $request->validate([
        'name'=> 'required',
        'email'=> 'required|email|unique:users,email,'.$id,
        ],[
        'name.required'=>'Name has to be filled',
        'email.required'=> 'Email has to be filled',
        'email.email'=> 'Email is not valid',
        'email.unique'=> 'Email is registered',
        ]);

        $newRequest = $request->only(['name','email']);

        if(!$id){
            $newRequest['password'] = Hash::make('12345678');
        }

        User::updateOrCreate(['id' => $id], $newRequest);
        $request->session()->forget('errors');

        toast()->success('The user successfully created');
        return redirect()->route('users.index');

    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password'=> 'required',
            'password'=> 'required|min:8|confirmed',
            ],[
                'current_password.required' =>'Current Password needs to be filled',
                'password.required'=> 'New Password has to be filled',
                'password.min'=> 'Minimum 8 characters for new password',
                'password.confirmed'=> 'New password does not match with confirmation password',
            ]);

            $user = User::find(Auth::id());
            // check current password
            if(!Hash::check($request->current_password, $user->password)){
               toast()->error('Current password does not match');
               return redirect()->route('users.index');
            }

            // update password
            $user->update([
                'password'=> Hash::make($request->password)
           ]);

           toast()->success('Password successfully changed');
           return redirect()->route('users.index');
    }

    public function destroy(String $id)
    {
    if (Auth::id()==$id) {
            toast()->error('Unable to delete a currently login account');
            return redirect()->route('users.index');
    }
   $user = User::findOrFail($id);
   $user->delete();

   toast()->success('The user has been succesfully deleted');
   return redirect()->route('users.index');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'id'=> 'required|exists:users,id',
        ]);
        $user=User::findOrFail($request->id);
        $user->update([
            'password'=> Hash::make('12345678')
        ]);
        toast()->success('Password has been successfully reset');
        return redirect()->route('users.index');    
    }
}
