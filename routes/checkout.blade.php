<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>

         /* Color Variables */
         :root {
            --primary-color: #f694c1;
            --secondary-color: #ff493e;
            --white-color: #f7f7f7;
         }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--white-color);
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand,
        .nav-link {
            color: var(--white-color) !important;
            font-weight: bold;
            margin-left: 20px;
        }

        .navbar-toggler {
            border-color: var(--primary-color);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28185, 0, 0, 0.5%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .nav-link:hover {
            color: var(--secondary-color) !important;
        }

        h1,
        h2 {
            color: var(--primary-color);
            font-weight: bold;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            border-radius: 30px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
        }

        .card-title,
        .card-text {
            color: var(--primary-color);
        }

        .product-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .bi{
            color: var(--white-color);
            margin-right: 30px;
        }
        .badge{
            color: var(--secondary-color);
            font-style: bold;
            font-size: 10px;
        }
        
        /* home */
        .search-container {
            max-width: 300px;
            margin: auto;
            padding: 10px;
            background-color: var(--primary-color);
            border-radius: 10px;
        }
        .btn-locate {
            background: none;
            border: none;
            color: var(--primary-color);
            text-align: center;
            border-radius: 10px;
        }
        .btn-locate i {
            color: var(--white-color);
        }

        .col {
            padding: 10px;
            border: 1px solid var(--primary-color);
            border-radius: 10px;
            max-width: 300px;
            text-align: center;
            margin: 20px;
        }

        .row {
            justify-content: center;
            margin-top: 10px;
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
.note{
    font-size: 8px;
}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a href="/"><img src="{{ asset('images/kendy.png') }}" alt="Logo" width="60" height="60" class="img-fluid"></a>
            <a class="navbar-brand" href="{{ url('/') }}"> Kendy Corner</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/cart') }}"><i class="bi bi-bag"><span class="badge">0</span></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/register') }}">Sign up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="form-container">
        <div class="d-flex justify-content-center">
            <img src="{{ asset('images/kendy.png') }}" alt="Logo" width="100" class="img-fluid">
        </div>
        <form method="POST">
            <div class="checkout-container justify-content-center">
                <div class="row">
                    <div class="input-field col">
                        <h5>Delivery Address</h5>
                        <p>Location</p>
                        <input type="text" name="username" id="username" required="" class="" value="{{ old('username') }}">
                        <label for="username" class="note">Note to rider - e.g. building, landmark</label>
                    </div>
                    <div class="col">
                        <p>Your order from</p>
                    </div>
                </div>  
                
                <div class="row">
                    <div class="col">
                        <p>Delivery Options</p>
                    </div>
                    <div class="col">
                        <p>Personal Details</p>
                    </div>
                </div> 

                <div class="row">
                    <div class="col">
                        <p>Payment</p>
                    </div>
                </div> 
            </div>
        </form>
    </div>
</body>
</html>
