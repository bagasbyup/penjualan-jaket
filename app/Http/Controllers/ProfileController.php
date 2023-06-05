<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Alert;
class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

        //FUNCTION PROFILE
         
    public function index()
        {
            $user = User::where('id', Auth::user()->id)->first();

            return view('profile.profile', compact('user'));
        }

        //FUNCTION UPDATE PROFILE 

    public function update(Request $request)
        {
            $this->validate($request, ['password' => 'confirmed']);

            $user = User::where('id',Auth::user()->id)->first();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->nohp = $request->nohp;
            $user->alamat = $request->alamat;
            if(!empty($request->password))
            {
                $user->password = Hash::make($request->password);
            }
            $user->update();

            return redirect('profile')->with('success', 'User Berhasil Diupdate');
        }
}
