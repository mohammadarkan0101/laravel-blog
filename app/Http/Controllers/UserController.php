<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreDataUserRequest;
use App\Http\Requests\UpdateDataUserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:administrator']);
    }

    public function datatable(): JsonResponse
    {
        $users = User::query()
            ->with('roles:id,name')
            ->select(['id', 'name', 'email', 'phone', 'status'])
            ->latest();

        return DataTables::eloquent($users)
            ->addIndexColumn()
            ->addColumn('role', fn (User $user) => match ($user->roles->first()?->name) {
                'administrator' => '<span class="badge badge-warning">Administrator</span>',
                'editor'        => '<span class="badge badge-success">Editor</span>',
                default         => '<span class="badge badge-primary">User</span>',
            })
            ->editColumn('status', fn (User $user) => $user->isActive()
                ? '<span class="badge badge-success">Aktif</span>'
                : '<span class="badge badge-danger">Nonaktif</span>'
            )
            ->addColumn('action', fn (User $user) => view('pages.admin.users.action', compact('user'))->render())
            ->rawColumns(['role', 'status', 'action'])
            ->make(true);
    }

    public function index(): View
    {
        return view('pages.admin.users.index');
    }

    public function create(): View
    {
        $roles = Role::all();

        return view('pages.admin.users.create', compact('roles'));
    }

    public function store(StoreDataUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $user->assignRole($validated['role']);

        return to_route('users.index')->with('success', 'User berhasil disimpan.');
    }

    public function edit(User $user): View
    {
        $roles = Role::all();

        return view('pages.admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateDataUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        $user->syncRoles($validated['role']);

        return to_route('users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return to_route('users.index')->with('success', 'User berhasil didelete.');
    }
}