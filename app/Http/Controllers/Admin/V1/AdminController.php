<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Requests\V1\AdminRequests\StoreAdminRequest;
use App\Http\Requests\V1\AdminRequests\UpdateAdminRequest;
use App\Models\Admin\V1\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('throttle:5,1')->only('login');
    }

    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    public function login(AdminLoginRequest $request)
    {
        try {
            $credentials = $request->validated();

            if (!Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }

            $admin = Auth::guard('admin')->user();

            $request->session()->regenerate();
            Log::info('Admin logged in', ['admin_id' => $admin->id]);

            return redirect()->intended(route('admin.dashboard'))
                ->with('status', __('auth.login_success'));

        } catch (ValidationException $e) {
            Log::warning('Failed admin login attempt', [
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);
            throw $e;
        }
    }

    public function logout(Request $request)
    {
        $admin_id = Auth::guard('admin')->id();

        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('Admin logged out', ['admin_id' => $admin_id]);

        return redirect()->route('admin.login')
            ->with('status', __('auth.logout_success'));
    }

    public function index()
    {
        $admins = Admin::whereHas('roles', fn($query) => $query->where('name', 'admin'))
            ->with('roles')
            ->paginate(5);

        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(StoreAdminRequest $request): RedirectResponse
    {
        $admin = null;

        try {
            $admin = DB::transaction(function () use ($request) {
                $validatedData = $request->validated();
                $validatedData['password'] = Hash::make($validatedData['password']);

                $admin = Admin::create($validatedData);
                $admin->assignRole('admin');

                return $admin;
            });

            Log::info('New admin created', [
                'admin_id' => $admin->id,
                'email' => $admin->email
            ]);

            return redirect()->route('admin.index')
                ->with('success', __('admin.created_successfully'));
        } catch (\Exception $e) {
            Log::error('Admin creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withError(__('admin.creation_failed'))
                ->withInput($request->except('password'));
        }
    }

    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

public function update(UpdateAdminRequest $request, Admin $admin)
{
    try {
        DB::transaction(function () use ($request, $admin) {
            $validatedData = $request->validated();

            unset($validatedData['old_password']);
            unset($validatedData['password_confirmation']);

            if ($request->filled('old_password') && $request->filled('password')) {
                if (!Hash::check($request->old_password, $admin->password)) {
                    throw new \Exception(__('admin.incorrect_old_password'));
                }
                $admin->password = Hash::make($request->password);
                unset($validatedData['password']);
            }

            $admin->fill($validatedData);
            $admin->save();
        });

        Log::info('Admin updated successfully', ['admin_id' => $admin->id]);

        return redirect()->route('admin.index')
            ->with('success', __('admin.updated_successfully'));
    } catch (\Exception $e) {
        Log::error('Admin update failed', [
            'admin_id' => $admin->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return back()
            ->withInput()
            ->with('error', __('admin.update_failed'));
    }
}
    public function destroy(Admin $admin): RedirectResponse
    {
        try {
            DB::transaction(fn() => $admin->delete());

            Log::info('Admin deleted successfully', [
                'admin_id' => $admin->id,
            ]);

            return redirect()->route('admin.index')
                ->with('success', __('admin.deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Admin deletion failed: ' . $e->getMessage());

            return back()
                ->withError(__('admin.deletion_failed'));
        }
    }
}
