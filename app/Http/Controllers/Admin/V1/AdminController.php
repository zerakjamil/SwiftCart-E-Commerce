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
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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

    public function index(){
        $admins = Admin::whereHas('roles', function($query) {
            $query->where('name', 'admin');
        })->with('roles')->paginate(5);

        return view('admin.admins.index', compact('admins'));
    }
    public function create()
    {
        return view('admin.admins.create');
    }
    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(UpdateAdminRequest $request, Admin $admin): RedirectResponse
    {
        try {
            DB::beginTransaction();

            if ($request->filled('password')) {
                $admin->password = Hash::make($request->password);
            }

            $admin->fillAttributes($request->validated());
            $admin->save();

            DB::commit();
            return redirect()->route('admin.index')->withSuccess('Admin updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin update failed: ' . $e->getMessage());
            return back()->withError('Failed to update admin. Please try again.');
        }
    }
    public function store(StoreAdminRequest $request)
{
    try {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasRole('superadmin')) {
            DB::beginTransaction();

            $validatedData = $request->validated();
            $validatedData['password'] = Hash::make($validatedData['password']);

            $admin = Admin::create($validatedData);

            $admin->assignRole('admin');

            DB::commit();
            Log::info('New admin created', ['admin_id' => $admin->id, 'email' => $admin->email]);

            return redirect()->route('admin.index')
                ->with('success', __('admin.created_successfully'));
        } else {
            return back()
                ->withError(__('admin.creation_not_allowed'))
                ->withInput($request->except('password'));
        }
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Admin creation failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return back()
            ->withError(__('admin.creation_failed'))
            ->withInput($request->except('password'));
    }
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
            Log::info('AdminRequests logged in', ['admin_id' => $admin->id]);

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

        Log::info('AdminRequests logged out', ['admin_id' => $admin_id]);

        return redirect('/admin/login')->with('status', __('auth.logout_success'));
    }


    public function destroy(Admin $admin): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $admin->delete();

            DB::commit();
            return redirect()->route('admin.index')->withSuccess('Admin deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Admin deletion failed: ' . $e->getMessage());
            return back()->withError('Failed to delete admin. Please try again.');
        }
    }
}
