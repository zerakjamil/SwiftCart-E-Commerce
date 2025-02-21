@extends('layouts.admin-auth')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-4">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-transparent border-0 text-center py-4">
                    <h2 class="text-primary fw-bold mb-0">Admin Portal</h2>
                    <p class="text-muted">Enter your credentials</p>
                </div>
                <div class="card-body px-5 py-4">
                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="email" class="text-muted mb-2">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="text-muted mb-2">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Login
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-transparent border-0 text-center py-3">
                    @if (Route::has('password.request'))
                        <a class="text-muted text-decoration-none hover-effect" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                    <div class="mt-2">
                        <a href="{{ route('login') }}" class="text-primary text-decoration-none hover-effect">Back to User Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    .card {
        border-radius: 1rem;
        background-color: #ffffff;
        transition: all 0.3s ease;
    }
    .form-control {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        border-color: #86b7fe;
    }
    .btn-primary {
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(13, 110, 253, 0.3);
    }
    .hover-effect {
        transition: all 0.3s ease;
    }
    .hover-effect:hover {
        color: #0d6efd !important;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .card {
        animation: fadeIn 0.5s ease-out;
    }
</style>
@endpush
