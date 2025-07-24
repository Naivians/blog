@extends('layout.app')

@section('main')
    <div class="auth-card" id="register-form">
        <h3 class="text-center mb-4">Register</h3>
        <form id="register">
            <div class="mb-3">
                <label for="registerName" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="registerName" name="name" placeholder="John Doe" required />
            </div>
            <div class="mb-3">
                <label for="registerEmail" class="form-label">Email address</label>
                <input type="email" class="form-control" id="registerEmail" name="email" placeholder="name@example.com"
                    required />
            </div>
            <div class="mb-3">
                <label for="registerPassword" class="form-label">Password</label>
                <input type="password" class="form-control" id="registerPassword" name="password" placeholder="••••••••"
                    required />
            </div>
            <div class="mb-3">
                <label for="registerConfirm" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="registerConfirm" name="password_confirmation"
                    placeholder="••••••••" required />
            </div>
            <button type="submit" class="btn btn-success w-100">Register</button>
            <div class="form-toggle">
                <p>Already have an account?
                    <a href="{{ route('login') }}">Login here</a>
                </p>
            </div>
        </form>
    </div>
@endsection
