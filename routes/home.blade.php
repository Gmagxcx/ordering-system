@extends('app')

@section('content')
<div>

</div>

<div class="header-section img-fluid" style="background-image: url('images/home-bg1.png'); 
            background-size: cover; 
            background-position: center; 
            height: 80vh; 
            background-attachment: fixed; 
            color: white; 
            text-align: center; 
            padding: 50px;">
    
    <h1>It's the candies you love, delivered</h1>
    
    <div class="container">
    <div class="search-container">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Enter your street and house number">
            <button class="btn-locate text-white" style="background-color: #f694c1;"> <i class="bi bi-geo-alt-fill">Locate Me</i>
            </button>
        </div>
    </div>
</div>
</div>

<div>
<h1 style="text-align: center; color: black; margin-top: 20px;">You prepare the candies, we handle the rest</h1>
<div class="header-section img-fluid" style="background-image: url('images/home-bg2.png'); 
            background-size: cover; 
            background-position: center; 
            height: 80vh; 
            background-attachment: fixed; 
            color: white; 
            text-align: center; 
            padding: 50px;">
    
    
    <div class="container"><br><br><br><br>
    <div class="card" style="width: 400px;">
  <div class="card-body">
    <h3 class="card-text">List your restaurant or shop on foodpanda.</h3>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <button type="button" class="btn w-50" style="color: #fff; background-color: #f694c1; height: 50px;" onclick="window.location.href='/login'">GET STARTED</button>

  </div>
</div>  
    </div>
</div>
</div>

@endsection
