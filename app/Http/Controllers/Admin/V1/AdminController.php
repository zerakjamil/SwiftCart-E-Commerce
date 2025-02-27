<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Http\Requests\V1\AdminRequests\StoreAdminRequest;
use App\Http\Requests\V1\AdminRequests\UpdateAdminRequest;
use App\Models\Admin\V1\Admin;
use App\Services\AdminService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->middleware('throttle:5,1')->only('login');
        $this->adminService = $adminService;
    }

    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    public function login(AdminLoginRequest $request)
    {
        try {
            $admin = $this->adminService->attemptLogin($request);
            return $this->successfulLogin($admin);
        } catch (ValidationException $e) {
            $this->logFailedLoginAttempt($request);
            throw $e;
        }
    }

    public function logout(Request $request)
    {
        $admin_id = Auth::guard('admin')->id();
        $this->adminService->logout($request);
        Log::info('Admin logged out', ['admin_id' => $admin_id]);

        return redirect()->route('admin.login')
            ->with('status', __('auth.logout_success'));
    }

    public function index()
    {
        $admins = $this->adminService->getPaginatedAdmins();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(StoreAdminRequest $request): RedirectResponse
    {
        try {
            $admin = $this->adminService->createAdmin($request->validated());
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
            $this->adminService->updateAdmin($admin, $request->validated());
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
            $this->adminService->deleteAdmin($admin);
            return redirect()->route('admin.index')
                ->with('success', __('admin.deleted_successfully'));
        } catch (\Exception $e) {
            Log::error('Admin deletion failed: ' . $e->getMessage());
            return back()->withError(__('admin.deletion_failed'));
        }
    }

    private function successfulLogin($admin)
    {
        Log::info('Admin logged in', ['admin_id' => $admin->id]);
        return redirect()->intended(route('admin.dashboard'))
            ->with('status', __('auth.login_success'));
    }

    private function logFailedLoginAttempt(Request $request)
    {
        Log::warning('Failed admin login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
        ]);
    }
}
