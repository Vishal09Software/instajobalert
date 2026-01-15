    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 text-primary-custom" href="{{ route('home') }}">
                <i class="bi bi-briefcase-fill me-2"></i>{{ config('app.name', 'InstaJobPortal') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('home') ? ' active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('alljobView') ? ' active' : '' }}" href="{{ route('alljobView') }}">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('contact') ? ' active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                    @guest
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('login') }}" class="btn btn-outline-custom btn-sm px-4">Login</a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            <a class="nav-link{{ request()->routeIs('profile.show') ? ' active' : '' }}" href="{{ route('profile.show') }}">Profile</a>
                        </li>
                        <li class="nav-item ms-lg-3">
                            <a href="#" class="btn btn-primary-custom btn-sm px-4"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
