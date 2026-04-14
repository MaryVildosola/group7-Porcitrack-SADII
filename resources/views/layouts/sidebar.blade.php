{{-- New PorciTrack Dark Sidebar --}}



<!-- Start::main-sidebar -->
<div class="main-sidebar" id="sidebar-scroll">

    <!-- Farm Admin Profile -->
    <div class="sidebar-profile">
        <div class="sidebar-avatar">
            <img src="{{ asset('assets/images/pig-logo.png') }}" alt="Farm Admin">
        </div>
        <div class="sidebar-profile-info">
            <p class="sidebar-profile-name">Farm Admin</p>
            <p class="sidebar-profile-role">Management System</p>
        </div>
    </div>

    <!-- Start::nav -->
    <nav class="main-menu-container nav nav-pills flex-column sub-open">
        <ul class="main-menu">
            <!-- Dashboard -->
            <li class="slide {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="side-menu__item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z" />
                    </svg>
                    <span class="side-menu__label">Dashboard</span>
                </a>
            </li>

            <!-- Inventory -->
            <li class="slide {{ request()->routeIs('enrollments.*') ? 'active' : '' }}">
                <a href="{{ route('enrollments.index') }}" class="side-menu__item {{ request()->routeIs('enrollments.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M20 6h-2.18c.07-.44.18-.88.18-1.34 0-2.58-2.09-4.66-4.67-4.66-1.41 0-2.67.61-3.55 1.57L8 3.96 6.22 1.57C5.34.61 4.08 0 2.67 0 .09 0-2 2.08-2 4.66c0 .46.11.9.18 1.34H-2v2h24V6zM2.67 2c1.23 0 2.19.96 2.19 2.13L8 6H2.67C1.44 6 .48 5.04.48 3.87c0-1.13.95-2.05 2.19-2.05L2.67 2zm8.66 2.13c0-1.18.96-2.13 2.19-2.13l.02-.13c1.24 0 2.2.97 2.2 2.18 0 1.17-.96 2.13-2.19 2.13H11.5L10.15 4.13zM4 8v12h2v-9h2v9h2V8H4zm10 0v3h-2v9h2v-9h2V8h-4z" />
                    </svg>
                    <span class="side-menu__label">Inventory</span>
                </a>
            </li>

            <!-- Pens & Pigs -->
            <li class="slide {{ request()->routeIs('pens.*') ? 'active' : '' }}">
                <a href="{{ route('pens.index') }}" class="side-menu__item {{ request()->routeIs('pens.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM6.5 9C7.33 9 8 8.33 8 7.5S7.33 6 6.5 6 5 6.67 5 7.5 5.67 9 6.5 9zm2.5 6.5c0 .83-.67 1.5-1.5 1.5S6 16.33 6 15.5 6.67 14 7.5 14s1.5.67 1.5 1.5zm8.5-6.5c-.83 0-1.5-.67-1.5-1.5S16.67 6 17.5 6 19 6.67 19 7.5 18.33 9 17.5 9zM15 15.5c0 .83-.67 1.5-1.5 1.5S12 16.33 12 15.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5zm-3-3.5c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" />
                    </svg>
                    <span class="side-menu__label">Pens &amp; Pigs</span>
                </a>
            </li>

            <!-- Analytics -->
            <li class="slide {{ request()->routeIs('subject.*') ? 'active' : '' }}">
                <a href="{{ route('subject.index') }}" class="side-menu__item {{ request()->routeIs('subject.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
                    </svg>
                    <span class="side-menu__label">Analytics</span>
                </a>
            </li>

            <!-- Weekly Reports -->
            <li class="slide {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                <a href="{{ route('admin.reports') }}" class="side-menu__item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                    <span class="side-menu__label">Weekly Reports</span>
                </a>
            </li>

            <!-- User Management -->
            <li class="slide {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="side-menu__item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <span class="side-menu__label">User Management</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End::nav -->

    <!-- Logout at bottom -->
    <div class="sidebar-logout">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-logout-btn">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </div>

</div>
<!-- End::main-sidebar -->

<style>
/* Sidebar Profile */
.sidebar-profile {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
    margin-bottom: 8px;
}

.sidebar-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    background: #1a3a1a;
    padding: 2px;
    border: 2px solid #4caf50;
}

.sidebar-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.sidebar-profile-info {
    flex: 1;
    min-width: 0;
}

.sidebar-profile-name {
    color: #fff;
    font-weight: 600;
    font-size: 0.85rem;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.sidebar-profile-role {
    color: rgba(255,255,255,0.45);
    font-size: 0.72rem;
    margin: 0;
}




/* Sidebar logout */
.sidebar-logout {
    margin-top: auto;
    padding: 16px 20px;
    border-top: 1px solid rgba(255,255,255,0.08);
}

.sidebar-logout-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    background: transparent;
    border: none;
    color: rgba(255,255,255,0.55);
    font-size: 0.85rem;
    cursor: pointer;
    padding: 6px 0;
    transition: color 0.2s;
    width: 100%;
    font-family: inherit;
}

.sidebar-logout-btn:hover { color: #ff6b6b; }

.sidebar-logout-btn svg {
    width: 18px;
    height: 18px;
    fill: currentColor;
}
</style>
