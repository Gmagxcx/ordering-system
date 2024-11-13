@extends('app')

@section('content')
<div class="header-section">
    <h1>Welcome to Kendy Corner</h1>
    
    <!-- <p class="lead">Your ultimate online candy store! Dive into a world of sweet delights, from classic treats to unique, hard-to-find confections. Whether you’re craving chocolates, gummies, or sour surprises, Kendy Corner has everything to satisfy your sweet tooth. Discover your new favorites and get them delivered right to your door!</p> -->

    <div class="container mt-5">
    <div class="search-container">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Enter your street and house number">
            <button class="btn-locate text-white" style="background-color: #fc89ac;"> <i class="bi bi-geo-alt-fill">Locate Me</i>
            </button>
        </div>
    </div>
</div>

</div>
@endsection