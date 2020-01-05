<?php

namespace App\Http\Controllers;

use App\Category;
use http\Url;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Mime\Encoder\Base64Encoder;
use App\User;

class AdminController extends Controller
{

    public function __construct()
    {
      //  $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.dashboard.dashboard');
    }

    public function permissionDenied() {
        return view('admin.dashboard.noPermission');
    }

    public function manage_users() {
      //  $usersWithRoles = User::with('roles')->get();
        $users = User::get();

        return view('admin.manage-users.index', ['users' => $users] );
    }

    public function remove_role(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'user_id' => 'required',
            'role_id' => 'required'
        ]);

        if($validatedData->fails()) {
            return Redirect::action('AdminController@manage_users')->withErrors($validatedData->messages());
        }

        $user = User::find($request->user_id);
        //  dd($user);
        $user->roles()->detach($request->role_id);
        return Redirect::route('manage-users');

    }

    public function give_role(Request $request) {
        $validatedData = Validator::make($request->all(), [
            'user_id' => 'required',
            'role_id' => 'required'
        ]);

        if($validatedData->fails()) {
            return Redirect::action('AdminController@manage_users')->withErrors($validatedData->messages());
        }

        $user = User::find($request->user_id);
      //  dd($user);
        $user->roles()->attach($request->role_id);
        return Redirect::route('manage-users');
    }




}
