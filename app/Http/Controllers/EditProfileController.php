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
            // Temukan user berdasarkan ID yang sudah di-decrypt
            $user = User::find(decrypt($id));

            // Validasi pertama: pastikan semua field tidak kosong
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'username' => 'required|unique:users,username,' . $user->id,
                'password' => 'required',
            ]);

            if (!Hash::check($request->password, $user->password)) {
                return back()->withErrors(['password' => 'Password is incorrect.']);
            }
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
