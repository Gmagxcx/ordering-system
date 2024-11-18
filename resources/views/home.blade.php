@extends('app')

@section('content')
<div class="header-section">
    <h1>Welcome to Kendy Corner</h1>
    
    <div class="container mt-5">
        <div class="search-container">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Enter your street and house number">
                <button class="btn-locate text-white" style="background-color: #fc89ac;">
                    <i class="bi bi-geo-alt-fill">Locate Me</i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
