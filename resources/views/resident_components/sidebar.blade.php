<div class="row">
    <!-- Sidebar -->
    
    <nav class="col-md-2 d-none d-md-block sidebar">
        <h5 style="color: white; text-align: center;">WOU Condominium</h5>
        <hr>
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                <a class="nav-link {{ Request::is('ownertenant-dashboard') ? 'active' : '' }}" href="/ownertenant-dashboard">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('community') ? 'active' : '' }}" href="/community">
                        <i class="fas fa-comments mr-1"></i> Community
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link {{ Request::is('facilities') ? 'active' : '' }}" href="/facilities">
                        <i class="fas fa-calendar mr-1"></i> Facilities
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('lost-and-found') ? 'active' : '' }}" href="/lost-and-found">
                        <i class="fas fa-search mr-1"></i> Lost and Found
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Feedback
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-money-check mr-1"></i> Payment
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>