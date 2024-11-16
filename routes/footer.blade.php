<!-- resources/views/footer.blade.php -->
<footer class="text-black text-center py-4" style="background-color: #e6e6e6;">
    <div class="container">
        <!-- Logo Section -->
        <div class="mb-3">
            <img src="{{ asset('images/kendy.png') }}" alt="Kendy Corner Logo" style="height: 50px;">
        </div>
        <!-- Text Section -->
        <p>&copy; {{ date('Y') }} Kendy Corner. All rights reserved.</p>
        <p>
            <a href="/terms" class="text-black mx-2">Terms of Use</a> | 
            <a href="/privacy" class="text-black mx-2">Privacy Policy</a>
        </p>
        <!-- Social Media Section -->
        <p>Follow us on:
            <a href="https://facebook.com" class="text-black mx-2"><i class="bi bi-facebook" style="color: black;"></i> Facebook</a>
            <a href="https://instagram.com" class="text-black mx-2"><i class="bi bi-instagram" style="color: black;"></i> Instagram</a>
        </p>
    </div>
</footer>
