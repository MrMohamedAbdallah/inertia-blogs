<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SettingsController extends Controller
{
    /**
     * Show settings page.
     * 
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {
        return Inertia('Settings/Index');
    }


    /**
     * Update user general info
     * 
     * @return \Illuminate\Http\Response
     */
    public function general(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(auth()->id())
            ],
            'profilePicture' => 'nullable|image|max:2048',
        ]);

        $user = auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->profilePicture)
            $user->profile_picture = $request->profilePicture->store('profiles', 'public');

        $user->save();

        return redirect()->back();
    }


    /**
     * Update authenticated user password.
     * 
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back();
    }
}
