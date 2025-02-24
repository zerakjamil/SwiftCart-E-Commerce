@extends('layouts.admin-auth')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-header bg-white border-0 text-center py-5">
                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                        </div>
                        <h2 class="text-black fw-bold mb-2 display-6">ADMIN PORTAL</h2>
                        <div class="divider mx-auto bg-black" style="width: 60px; height: 2px;"></div>
                    </div>
                    <div class="card-body px-5 py-4">
                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf

                            <div class="form-group mb-4">
                                <input id="email" type="email"
                                       class="form-control bg-light @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autocomplete="email"
                                       autofocus
                                       placeholder="Email Address">
                                @error('email')
                                <div class="invalid-feedback mt-2" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <input id="password" type="password"
                                       class="form-control bg-light @error('password') is-invalid @enderror"
                                       name="password"
                                       required
                                       autocomplete="current-password"
                                       placeholder="Password">
                                @error('password')
                                <div class="invalid-feedback mt-2" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 mt-5">
                                <button type="submit" class="btn btn-black btn-lg py-3">
                                    CONTINUE TO DASHBOARD
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-white border-0 text-center py-4">
                        <div class="links">
                            <a href="{{ route('login') }}" class="d-block mt-3 text-dark hover-opacity">
                                ← RETURN TO PUBLIC SITE
                            </a>
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
            background: #ffffff;
        }
        .card {
            border: none;
            border-radius: 0;
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .form-control {
            border: none;
            border-radius: 0;
            background: #f8f9fa !important;
            padding: 1rem;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .form-control:focus {
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            background: #ffffff !important;
        }
        .btn-black {
            background: #000000;
            color: #ffffff;
            border-radius: 0;
            font-weight: 600;
            letter-spacing: 0.5px;
            border: 2px solid #000000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-black:hover {
            background: #ffffff;
            color: #000000;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        .hover-opacity {
            opacity: 0.75;
            transition: opacity 0.3s ease;
        }
        .hover-opacity:hover {
            opacity: 1;
            color: #000000 !important;
        }
        .invalid-feedback {
            font-weight: 500;
            letter-spacing: -0.25px;
        }
        .divider {
            background: linear-gradient(90deg, transparent 0%, #000000 50%, transparent 100%);
        }
        @keyframes floatIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card {
            animation: floatIn 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }
    </style>
@endpush
