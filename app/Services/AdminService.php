<?php

namespace App\Services;

use App\Models\Admin\V1\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminService
{
    public function attemptLogin($request)
    {
        $credentials = $request->validated();
        if (!Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        $request->session()->regenerate();
        return Auth::guard('admin')->user();
    }

    public function logout($request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function getPaginatedAdmins()
    {
        return Admin::whereHas('roles', fn($query) => $query->where('name', 'admin'))
            ->with('roles')
            ->paginate(5);
    }

    public function createAdmin($data)
    {
        return DB::transaction(function () use ($data) {
            $data['password'] = Hash::make($data['password']);
            $admin = Admin::create($data);
            $admin->assignRole('admin');
            return $admin;
        });
    }

    public function updateAdmin(Admin $admin, $data)
    {
        DB::transaction(function () use ($admin, $data) {
            if (isset($data['old_password']) && isset($data['password'])) {
                if (!Hash::check($data['old_password'], $admin->password)) {
                    throw new \Exception(__('admin.incorrect_old_password'));
                }
                $admin->password = Hash::make($data['password']);
                unset($data['password']);
            }
            unset($data['old_password']);
            unset($data['password_confirmation']);
            $admin->fill($data);
            $admin->save();
        });
    }

    public function deleteAdmin(Admin $admin)
    {
        DB::transaction(fn() => $admin->delete());
    }
}
