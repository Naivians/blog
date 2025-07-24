@extends('layout.app')

@section('main')
    <div class="auth-card" id="login-form">
        <h3 class="text-center mb-4">Login</h3>
        <form id="loginForm">
            <div class="mb-3">
                <label for="loginEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="loginEmail" name = "email" placeholder="name@example.com" />
            </div>
            <div class="mb-3">
                <label for="loginPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="loginPassword" placeholder="••••••••" />
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <div class="form-toggle">
                <p>Don't have an account?
                    <a href="{{ route('register') }}">Register here</a>
                </p>
            </div>
        </form>
    </div>
@endsection
