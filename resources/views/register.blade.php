<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
            /* Color Variables */
            :root {
        --primary-color: #fc89ac;
        --secondary-color: #ff493e;
        --white-color: #f7f7f7;
         }

body {
    background-image: url('images/bg.png');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
    opacity: 0.9;
    background-repeat: no-repeat;
    background-color:  var(--white-color);
}

.form-container {
    max-width: 400px;
    width: 100%;
    padding: 20px;
    background-color: var(--white-color);
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border: 2px solid var(--primary-color);
    margin-bottom: 20px; 

}

.btn {
    background-color: var(--primary-color);
    color: var(--white-color);
    text-align: center;
    display: block;
    margin: 0 auto;
    border: 1px solid var(--primary-color);
    border-radius: 5px;
    margin-top: 20px;
}

.btn:hover {
    color: var(--primary-color);
    background-color: var(--white-color);
    border: 1px solid var(--primary-color);
}

.title {
    background-color: var(--white-color);
    color: var(--primary-color);
}

h5 {
    text-align: center;
    margin-top: 10px;
    margin-bottom: 5px;
}
a {
    text-align: center;
    color: var(--primary-color);
    margin-bottom: 30px; 
}
.register{
    text-align: center;
    margin: 20px;
}
.img-fluid{
    justify-content: center;
    text-align: center;
}


</style>

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
                <label for="username" class="form-label">Enter First Name</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}">
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col">
                <label for="username" class="form-label">Enter Last Name</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}">
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            </div>


            <div class="mb-3">
                <label for="username" class="form-label">Enter Email</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}">
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Enter Password</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Confirm Password</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn w-50">SIGN IN</button>

            <div class="register">
                <p>Already have an account? <a href="/login">Sign Up</a></p>
            </div>
        </form>
        
    </div>
</body>
