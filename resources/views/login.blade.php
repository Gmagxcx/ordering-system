    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" type="text/css">

<body>
    <div class="form-container">
         <div class="d-flex justify-content-center mb-4">
            <img src="{{ asset('images/kendy.png') }}" alt="Logo" width="100" class="img-fluid">
        </div>
        <h2 class="title text-center mb-4">WELCOME BACK!</h2>
        <p class="text-center">Please enter login details below.</p>
        <form method="POST" action="/login">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required> <!-- Changed to 'email' type -->
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn w-50">SIGN IN</button>

            <div class="register">
                <p>Don't have an account? <a href="/register">Sign Up</a></p>
            </div>
        </form>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        
    </div>
</body>
