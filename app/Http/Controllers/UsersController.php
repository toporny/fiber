<?php

namespace App\Http\Controllers;

use Illuminate\Database\Seeder; 
use App\Models\User; 
use App\Models\Client;
use App\Models\Blowing;
use App\Models\Blowdata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Hash;
use Image;

class UsersController extends Controller
{
	public function index() 
	{
		$logged_user_id = auth()->user()->id;
		$user = User::whereId($logged_user_id)->first();
		return view('auth.show_user', compact('user'));
	}

    public function profiles() 
    {
        $users = DB::table('blowings as b')
            ->select('u.username','u.is_admin','u.email','u.id','u.created_at', DB::raw('count(username) as c'))
            ->join('users as u', 'u.id', '=', 'b.user_id')
            ->groupBy('b.user_id')
            ->get();

        return view('auth.show_users', compact('users'));
    }


    public function show_one_user_by_user() 
    {
        $logged_user_id = auth()->user()->id;
        $user = User::whereId($logged_user_id)->first();
        return view('auth.show_one_user', compact('user'));
    }


    public function show_one_user_by_admin($id_user_to_show) 
    {
        $user = User::whereId($id_user_to_show)->first();
        return view('auth.show_one_user', compact('user'));
    }


    public function editProfileByUser() {
        $id_user_to_edit = auth()->user()->id;
        $user_to_edit = User::whereId($id_user_to_edit)->first();
        return view('auth.edit_user_by_user', compact('user_to_edit'));
    }


    public function editProfileByUserPost(Request $request)
    {
        $request->validate([
          'company_name' => 'required|min:3|max:60',
          'email' => 'required|min:5|max:60',
          'company_address' => 'max:160',
          'company_tax_number' => 'max:250',
          'company_phone' => 'max:25',
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = auth()->user()->id . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 100)->save( public_path('/uploads/' . $filename ) );
            $user->image = $filename;
        }

        $user->company_name = $request->company_name;
        $user->company_address = $request->company_address;
        $user->company_tax_number = $request->company_tax_number;
        $user->company_phone = $request->company_phone;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Data successfully changed!');
    }



    public function editProfileByAdmin($id_user_to_edit) 
    {
        $user_to_edit = User::whereId($id_user_to_edit)->first();
        return view('auth.edit_user_by_admin', compact('user_to_edit'));
    }

    public function editProfileByAdminPost(Request $request)
    {

        $request->validate([
          'company_name' => 'required|min:3',
          'email' => 'required|min:5',
          'username' => 'required|min:4',
        ]);

        $user = User::where('id', $request->user_id)->first();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = $request->user_id . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 100)->save( public_path('/uploads/' . $filename ) );
            $user->image = $filename;
        }
        $user->company_name = $request->company_name;
        $user->company_address = $request->company_address;
        $user->company_tax_number = $request->company_tax_number;
        $user->company_phone = $request->company_phone;
        $user->is_admin = $request->is_admin;
        $user->email = $request->email;
        $user->username = $request->username;

        $user->save();
        return back()->with('success', 'Data successfully changed!');
    }



    public function deleteuser($id_user_to_delete) 
    {
        $is_admin = auth()->user()->is_admin;
        $logged_user_id = auth()->user()->id;
        if ($is_admin || ($logged_user_id == $id_user_to_delete)) {
            $user_to_delete = User::whereId($id_user_to_delete)->first();
            return view('auth.delete_user', compact('user_to_delete'));
        } else {
            return view('auth.only_for_logged_users');
        }
    }


    public function changePasswordByUser()
    {
            return view('auth.change_password');
    }


    public function changePasswordByUserPost(Request $request)
    {
        $request->validate([
          'current_password' => 'required',
          'password' => 'required|string|min:6|confirmed',
          'password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        $user->password = $request->password;
        $user->save();

        return back()->with('success', 'Password successfully changed!');
    }


    public function changePasswordByAdmin($id)
    {
        $user = User::where('id', $id)->first();
        return view('auth.change_password_by_admin', $user);
    }


    public function changePasswordByAdminPost(Request $request)
    {
            #$data = array('user_id' => $request->user_id, 'user_email' => $request->user_email);
            #return view('auth.change_password_by_admin',$data);

        $request->validate([
          'password' => 'required|min:6',
        ]);

        $user = Auth::user();
        $user->password = $request->password;
        $user->save();

        return back()->with('success', 'Password successfully changed!');

    }


    public function deletePermanentlyMyOwnAccount()
    {
        $user_id = auth()->user()->id;
        
        DB::table('clients')
            ->where('clients.user_id', $user_id)
            ->join('users', 'users.id', '=', 'clients.user_id')
            ->delete();

        DB::table('blowdatas')
            ->join('blowings', 'blowdatas.blowing_id', '=', 'blowings.id')
            ->join('users', 'users.id', '=', 'blowings.user_id')
            ->where('blowings.user_id', $user_id)
            ->delete();

        DB::table('blowings')
            ->where('blowings.user_id', $user_id)
            ->join('users', 'users.id', '=', 'blowings.user_id')
            ->delete();

        DB::table('users')
            ->where('users.id', $user_id)
            ->delete();

        Session::flush();
        Auth::logout();

        return redirect()->route('auth.show')->withError('Account has been deleted.');

    }


    public function deleteMyOwnAccountConfirmation()
    {
        $user_id = auth()->user()->id;

        $clients_count = Client::where('user_id', '=', $user_id)->count();
        $blowings_count = Blowing::where('user_id', '=', $user_id)->count();

        $data = Array('clients_count' => $clients_count, 'blowings_count'=>$blowings_count);
        return view('auth.delete_account_confirmation', $data);
    }

     // Method App\Http\Controllers\UsersController::show_one_user_by_admin does not exist.

}
