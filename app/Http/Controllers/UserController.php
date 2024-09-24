<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::all();
            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn('username', function ($row) {
                    return $row->username ?? '-';
                })
                ->addColumn('role', function ($row) {
                    return $row->getRoleNames()->first() ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('user.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2"><i class="ph-duotone ph-eye"></i></a>';
                    $btn = $btn . '<a href="' . route('user.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn = $btn . '<a href="#" class="delete btn btn-danger btn-sm"  data-id="' . encrypt($row->id) . '"><i class="ph-duotone ph-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } 

        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ]);

        if ($request->password != $request->password_confirmation) {
            return redirect()->back()->with('error', 'Password and Confirm Password do not match.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $role = Role::findById($request->role_id);

        $user->assignRole($role);

        if ($user) {
            return redirect()->route('user.index')->with('success', 'User created successfully.');
        } else {
            return redirect()->route('user.index')->with('error', 'User creation failed.');
        }
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
        $roles = Role::all();

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find(decrypt($id));

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
        ]);

        $role = Role::findById($request->role_id);
        $user->syncRoles($role);

        if ($request->new_password) {
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->new_password == $request->password_confirmation) {
                    $user->update([
                        'password' => Hash::make($request->new_password),
                    ]);
                } else {
                    return redirect()->back()->with('error', 'New Password and Confirm New Password do not match.');
                }
            } else {
                return redirect()->back()->with('error', 'Old password is incorrect.');
            }
        }

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find(decrypt($id));

        if ($user->id == auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete yourself.',
            ]);
        }
        
        if ($user->unit) {
            return response()->json([
                'success' => false,
                'message' => 'User cannot be deleted as it is associated with a unit.',
            ]);
        }

        // check if user is technician
        
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.',
        ]);
        
    }
}