<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $users = User::where('is_enabled', true)->get();
            return datatables()->of($users)
                ->addIndexColumn()
                ->addColumn('username', function ($row) {
                    return $row->username ?? '-';
                })
                ->addColumn('role', function ($row) {
                    return $row->getRoleNames()->first() ?? '-';
                })
                ->addColumn('action', function ($row) {
                    // $btn = '<a href="' . route('user.show', encrypt($row->id)) . '" class="view btn btn-info btn-sm me-2"><i class="ph-duotone ph-eye"></i></a>';
                    $btn = '<a href="' . route('user.edit', encrypt($row->id)) . '" class="edit btn btn-warning btn-sm me-2" title="Edit Data"><i class="ph-duotone ph-pencil-line"></i></a>';
                    $btn = $btn . '<a href="#" class="delete btn btn-danger btn-sm me-2"  data-id="' . encrypt($row->id) . '"  title="Edit Data"><i class="ph-duotone ph-trash"></i></a>';
                    $log = [
                        'norec' => $row->norec ?? null,
                        'module_id' => 9,
                        'status' => 'is_generic',
                    ];
                    $showLogBtn = 
                        "<a href='#'class='btn btn-sm btn-info' data-bs-toggle='modal'
                            data-bs-target='#exampleModal'
                            data-title='Detail Log' data-bs-tooltip='tooltip'
                            data-remote=" . route('log.getLog', ['norec' => $log['norec'], 'module' => $log['module_id'], 'status' => $log['status']]) . "
                            title='Log Information'>
                            <i class='ph-duotone ph-info'></i>
                        </a>
                    ";

                    $btn = $btn . $showLogBtn;

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
        $data = [
            'roles' => Role::all(),
            'units' => Units::where('user_id', null)->get(),
        ];

        return view('user.create', compact('data'));
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
            'password' => 'required|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            $role = Role::findById($request->role_id);
            $user->assignRole($role);

            if ($request->unit_id) {
                $unit = Units::find($request->unit_id);
                $unit->update([
                    'user_id' => $user->id,
                ]);
            }

            $log = [
                'norec' => $user->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 9,
                'is_generic' => true,
                'desc' => 'Create a new user: ' . $user->username . ' with role: ' . $role->name . ' by ' . auth()->user()->name,
            ];

            createLog($log);
            DB::commit();  
            return redirect()->route('user.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();  
            return redirect()->back()->with('error', 'User creation failed: ' . $e->getMessage());
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
        $data = [
            'roles' => Role::all(),
            'units' => Units::where('user_id', null)->orWhere('user_id', 0)->orWhere('user_id', $user->id)->get(),
        ];

        return view('user.edit', compact('user', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail(decrypt($id));
        $oldUser = $user->toJson();

        DB::beginTransaction();
        try {
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

            if ($request->unit_id) {
                Units::where('id', $request->unit_id)->update([
                    'user_id' => $user->id,
                ]);
            } else {
                Units::where('user_id', $user->id)->update([
                    'user_id' => null,
                ]);
            }

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

            $log = [
                'norec' => $user->norec,
                'norec_parent' => auth()->user()->norec,
                'module_id' => 9,
                'is_generic' => true,
                'desc' => 'Edit an existing user: ' . $user->username . ' with role: ' . $role->name . ' by ' . auth()->user()->name,
                'old_data' => $oldUser,
            ];

            createLog($log);
            DB::commit();
            return redirect()->route('user.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'User update failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find(decrypt($id));
        $oldUser = $user->toJson();

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
        // createLog(9, $user->id, 'delete a user', null, $user->toJson());
        $log = [
            'norec' => $user->norec,
            'module_id' => 9,
            'is_generic' => true,
            'desc' => 'Delete an exixting user by ' . auth()->user()->name,
            'old_data' => $oldUser,
        ];

        createLog($log);
        $user->is_enabled = false;
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.',
        ]);
        
    }
}