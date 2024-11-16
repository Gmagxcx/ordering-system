<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" type="text/css">

<body>
    <div class="form-container">
        <div class="d-flex justify-content-center">
            <img src="{{ asset('images/kendy.png') }}" alt="Logo" width="100" height="80" class="img-fluid">
        </div>
        <h2 class="title text-center mb-4">Create an Account!</h2>
            <form method="POST">
            @csrf
            <div class="mb-3 row">
                <div class="col">
                    <label for="first_name" class="form-label">Enter First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}">
                    @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col">
                    <label for="last_name" class="form-label">Enter Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}">
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Enter Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Enter Password</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn w-50">SIGN UP</button>

            <div class="register">
                <p>Already have an account? <a href="/login">Login</a></p>
            </div>
        </form>
    </div>
</body>
