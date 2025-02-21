<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
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

        return redirect('/')->with('status', __('auth.logout_success'));
    }
}
