  <!-- Footer -->
  <footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <h4 class="mb-4 text-white">{{ config('app.name', 'InstaJobPortal') }}</h4>
                <p class="text-secondary-light" style="color: #94a3b8;">
                    Connecting talent with opportunity.<br>Your future starts here.
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="#" class="text-white"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-twitter fs-5"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-linkedin fs-5"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-instagram fs-5"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6 mb-4">
                <h5>Jobs</h5>
                <a href="{{ route('alljobView') }}" class="footer-link">Browse Jobs</a>
                <a href="{{ route('alljobView', ['category' => 'it']) }}" class="footer-link">IT Jobs</a>
                <a href="{{ route('alljobView', ['category' => 'design']) }}" class="footer-link">Design Jobs</a>
                <a href="{{ route('alljobView', ['category' => 'marketing']) }}" class="footer-link">Marketing Jobs</a>
                <a href="{{ route('alljobView', ['category' => 'finance']) }}" class="footer-link">Finance Jobs</a>
            </div>
            <div class="col-lg-3 col-6 mb-4">
                <h5>Categories</h5>
                <a href="{{ route('alljobView', ['category' => 'engineering']) }}" class="footer-link">Engineering</a>
                <a href="{{ route('alljobView', ['category' => 'healthcare']) }}" class="footer-link">Healthcare</a>
                <a href="{{ route('alljobView', ['category' => 'sales']) }}" class="footer-link">Sales</a>
                <a href="{{ route('alljobView', ['category' => 'human-resources']) }}" class="footer-link">Human Resources</a>
                <a href="{{ route('alljobView', ['category' => 'customer-service']) }}" class="footer-link">Customer Service</a>
            </div>
            <div class="col-lg-3 mb-4">
                <h5>Contact Us</h5>
                <p class="text-secondary-light mb-2" style="color: #94a3b8;">
                    <i class="bi bi-geo-alt me-2"></i> {{ config('services.contact.address') }}
                </p>
                <p class="text-secondary-light mb-2" style="color: #94a3b8;">
                    <i class="bi bi-envelope me-2"></i> {{ config('services.contact.email') }}
                </p>
            </div>
        </div>
        <div class="border-top border-secondary mt-5 pt-4 text-center">
            <p class="text-secondary-light mb-0" style="color: #64748b;">&copy; 2026 {{ config('app.name', 'InstaJobPortal') }}. All Rights Reserved.</p>
        </div>
    </div>
</footer>
