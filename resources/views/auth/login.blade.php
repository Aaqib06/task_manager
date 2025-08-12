<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login - Task Manager</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
<div class="auth-card" role="main" aria-label="Login Form">
    <h2>Welcome Back!</h2>

    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('login') }}" method="POST" novalidate>
        @csrf
        <label for="email" class="form-label">Email Address</label>
        <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror

        <label for="password" class="form-label mt-3">Password</label>
        <input id="password" type="password" name="password" class="form-control" required>
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror

        @if(session('errors'))
            <span class="text-danger mb-3 d-block">
                {{ session('errors')->first() }}
            </span>
        @endif

        <button type="submit" class="btn-primary" aria-label="Login to your account">Login</button>

        <p class="auth-link">
            Don't have an account? <a href="{{ route('register.form') }}" aria-label="Go to registration page">Register here</a>
        </p>
    </form>
</div>
</body>
</html>
