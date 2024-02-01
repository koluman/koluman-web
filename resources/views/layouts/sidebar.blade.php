<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-2">
                <img class="rounded header-profile-user" src="{{ URL::asset('build/images/users/avatar-1.jpg') }}"
                    alt="Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">fddsfsdf</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                            class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                            class="align-middle">Online</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Hoşgeldin {{ Auth::guard('web')->user()->backuser_name }}!</h6>
            <a class="dropdown-item" href="#"><i
                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Profile</span></a>
            <a class="dropdown-item" href="#"><i
                    class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Messages</span></a>
            <a class="dropdown-item" href="#"><i
                    class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Taskboard</span></a>
            <a class="dropdown-item" href="#"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i>
                <span class="align-middle">Help</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i>
                <span class="align-middle">Balance :
                    <b>$5971.67</b></span></a>
            <a class="dropdown-item" href="#"><span
                    class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Settings</span></a>
            <a class="dropdown-item" href="#"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i>
                <span class="align-middle">Lock
                    screen</span></a>

            <a class="dropdown-item " href="javascript:void();"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                    key="t-logout">@lang('translation.logout')</span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    @php
                        $dashboardLink = Auth::guard('web')->user()->backuser_role . 'dashboard';
                    @endphp

                <li class="nav-item">
                    <a href="{{ $dashboardLink }}" class="nav-link"> <i class="ri-dashboard-2-line"></i>
                        <span>@lang('translation.dashboards')</span></a>
                </li>
                </li> <!-- end Dashboard Menu -->
                @if (Auth::guard('web')->user()->backuser_role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarUsers" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarUsers">
                            <i class="ri-account-circle-line"></i> <span>@lang('translation.user')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarUsers">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="adminusers" class="nav-link">@lang('translation.userlist')</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarTestDrive" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarTestDrive">
                            <i class="ri-apps-2-line"></i> <span>@lang('translation.testdrive')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarTestDrive">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="admintestdrive" class="nav-link">@lang('translation.testdrivelist')</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
                @if (Auth::guard('web')->user()->backuser_role == 'sigorta')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarSigorta" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarSigorta">
                            <i class="ri-apps-2-line"></i> <span>@lang('translation.sigorta')</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarSigorta">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="sigortalist" class="nav-link">@lang('translation.sigortalist')</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
