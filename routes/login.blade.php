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
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border: 2px solid var(--primary-color);
    margin-bottom: 20px; 
    opacity: 1;
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
.forgotpass{
    margin: 20px;
}
.img-fluid{
    justify-content: center;
    text-align: center;
}


.input-field {
  position: relative;
}

.input-field label {
  position: absolute;
  color: var(--primary-color);
  pointer-events: none;
  background-color: transparent;
  left: 15px;
  transform: translateY(0.6rem);
  transition: all 0.3s ease;
}

.input-field input {
  padding: 10px 15px;
  font-size: 1rem;
  border-radius: 8px;
  border: solid 1px var(--primary-color);
  letter-spacing: 1px;
  width: 100%;
}

.input-field input:focus,
.input-field input:valid {
  outline: none;
  border: solid 1px var(--primary-color);
}

.input-field input:focus ~ label,
.input-field input:valid ~ label {
  transform: translateY(-51%) translateX(-10px) scale(0.8);
  background-color: #fff;
  padding: 0px 5px;
  color: var(--primary-color);
  font-weight: bold;
  letter-spacing: 1px;
  border: none;
  border-radius: 100px;
}

</style>

<body>
    <div class="form-container">
         <div class="d-flex justify-content-center mb-4">
            <img src="{{ asset('images/kendy.png') }}" alt="Logo" width="100" class="img-fluid">
        </div>
        <h2 class="title text-center mb-4">WELCOME BACK!</h2>
        <p class="text-center">Please enter login details below.</p>
        <form method="POST">
            @csrf
            <div class="input-field mb-3">
                <input type="text" name="username" id="username" required="" class="" value="{{ old('username') }}">
                <label for="username">Username</label>
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="input-field mb-3">
                <input type="password" name="password" id="password" required="" class="" value="{{ old('username') }}">     
                <label for="password">Password</label>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn w-50">SIGN IN</button>

            <div class="register">
                <p>Don't have an account? <a href="/register">Sign Up</a></p>
            </div>
        </form>
        
    </div>
</body>
