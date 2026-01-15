<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('admin_theme/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin_theme/assets/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('admin_theme/assets/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('admin_theme/assets/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <ul class="navbar-nav" id="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                        <i class="ri-dashboard-line"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <!-- Jobs Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('jobs.index')}}">
                        <i class="ri-briefcase-line"></i>
                        <span data-key="t-jobs">Jobs</span>
                    </a>
                </li>

                <!-- Category Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('categories.index') }}">
                        <i class="ri-folder-2-line"></i>
                        <span data-key="t-category">Category</span>
                    </a>
                </li>

                <!-- Job Type Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('job-types.index')}}">
                        <i class="ri-file-list-3-line"></i>
                        <span data-key="t-jobtype">Job Type</span>
                    </a>
                </li>

                <!-- Skills Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{route('skills.index')}}">
                        <i class="ri-star-line"></i>
                        <span data-key="t-skills">Skills</span>
                    </a>
                </li>

                <!-- User Menu -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('users.index') }}">
                        <i class="ri-user-line"></i>
                        <span data-key="t-user">User</span>
                    </a>
                </li>





            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
