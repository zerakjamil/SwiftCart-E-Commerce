<?php

namespace App\Http\Services;

use App\Models\Admin\V1\Admin;
use Illuminate\Support\Facades\{Auth,DB,Hash};
use Illuminate\Validation\ValidationException;
use \Illuminate\Contracts\Auth\Authenticatable;
class AdminService extends Service
{
    public function __construct(Admin $admin)
    {
        parent::__construct($admin);
    }
    public function attemptLogin($request): ? Authenticatable
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

    public function logout($request): void
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function getPaginatedAdmins($count = 5)
    {
        return Admin::whereHas('roles', fn($query) => $query->where('name', 'admin'))
            ->with('roles')
            ->paginate($count);
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

    public function updateAdmin(Admin $admin, $data): void
    {
        DB::transaction(function () use ($admin, $data) {
            if (!empty($data['old_password']) && !empty($data['password'])) {
                if (!Hash::check($data['old_password'], $admin->password)) {
                    throw new \Exception(__('admin.incorrect_old_password'));
                }
                $admin->password = Hash::make($data['password']);
            }

            unset($data['old_password']);
            unset($data['password']);
            unset($data['password_confirmation']);

            $admin->fillAttributes($data);
            $admin->save();
        });
    }

    public function deleteAdmin(Admin $admin): void
    {
        DB::transaction(fn() => $admin->delete());
    }
}
