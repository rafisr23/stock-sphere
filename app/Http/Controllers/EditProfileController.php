<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EditProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find(decrypt($id));
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::find(decrypt($id));

            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'username' => 'required|unique:users,username,' . $user->id,
                'password' => ['required', function ($attribute, $value, $fail) use ($request, $user) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail('Password is incorrect.');
                    }
                }],
            ]);

            // if (!Hash::check($request->password, $user->password)) {
            //     return back()->withErrors(['password' => 'Password is incorrect.']);
            // }
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
            ]);
            return back()->with('success', 'User data updated successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'User data update failed: ' . $e->getMessage());
        }
    }

    public function change_password(string $id)
    {
        $user = User::find(decrypt($id));
        return view('profile.change_password', compact('user'));
    }

    public function update_password(Request $request, string $id)
    {
        try {
            $user = User::find(decrypt($id));

            $request->validate([
                'old_password' => 'required',
                'new_password' => ['required', 'confirmed', function ($attribute, $value, $fail) use ($request, $user) {
                    if (Hash::check($value, $user->password)) {
                        return $fail('New password must be different from the old password.');
                    }
                }],
            ]);

            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Old password is incorrect.']);
            }
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return back()->with('success', 'Password updated successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Password update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
