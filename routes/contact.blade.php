@extends('app')

@section('content')
<div class="header-section">
    <h2>Contact Us</h2>
    <p class="lead">We’d love to hear from you!</p>
</div>
<form class="mx-auto" style="max-width: 600px;">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Your Name">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" placeholder="name@example.com">
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" rows="4" placeholder="Your Message"></textarea>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary">Send Message</button>
    </div>
</form>
@endsection