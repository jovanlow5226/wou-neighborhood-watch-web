<div class="container-fluid">
    <div class="row">
        <!-- Top Bar -->
        <div class="col-md-12 top-bar">
            <div class="d-flex align-items-center">
                <div class="mr-auto"></div>
                <div class="profile-dropdown">
                    <i class="fas fa-user-circle mr-2"></i>
                    Hi, <span>{{ $user_details['name'] }} </span>
                    <i class="fas fa-angle-down"></i>
                    <!-- Profile Info Dropdown -->
                    <div class="profile-info" id="profileInfo">
                        <div class="user-info">
                            <i class="fas fa-user-circle" style="font-size:80px;"></i> <!-- Font Awesome user icon -->
                            <div class="user-details">
                                <span>{{ $user_details['name'] }}</span><br>
                                <span>{{ $user_details['login_id'] }}</span>
                            </div>
                        </div>
                        <hr>
                        <a href="/logout" class="btn btn-theme btn-sm">Profile Setting</a>
                        <a href="/logout" class="btn btn-theme-outline btn-sm">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>