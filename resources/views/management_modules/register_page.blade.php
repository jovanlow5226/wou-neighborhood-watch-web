<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">
@include('management_components/header')
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('management_components/sidebar')
            @include('management_components/topbar')
            <!-- Page Content -->
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 main-content">
                <div class="container mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header theme-bg-color-dark">
                                    <h4 class="mb-0">User Registration</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Success Message -->
                                    @if (session('success'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <!-- Registration Form -->
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <!-- User Type Dropdown -->
                                        <div class="form-group">
                                            <label for="user_type">User Type</label>
                                            <select id="user_type" class="form-control" name="user_type" required>
                                                <option value="">Select User Type</option>
                                                <option value="owner_tenant">Owner/Tenant</option>
                                                <option value="management">Management</option>
                                            </select>
                                        </div>
                                        <!-- Login ID / Unit ID -->
                                        <div class="form-group">
                                            <label for="login_id">Login ID / Unit ID</label>
                                            <input type="text" id="login_id" class="form-control" name="login_id" required>
                                        </div>
                                        <!-- Name -->
                                        <div class="form-group">
                                            <label for="username">Name</label>
                                            <input type="text" id="username" class="form-control" name="username" required>
                                        </div>
                                        <!-- Password -->
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" id="password" class="form-control" name="password" required>
                                        </div>
                                        <!-- Email -->
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" class="form-control" name="email" required>
                                        </div>
                                        <!-- Error Messages -->
                                        @if ($errors->any())
                                            <div class="alert alert-danger" role="alert">
                                                @foreach ($errors->all() as $error)
                                                    {{ $error }}<br>
                                                @endforeach
                                            </div>
                                        @endif
                                        <!-- Register Button -->
                                        <button type="submit" class="btn btn-theme btn-block">Register</button>
                                    </form>
                                    <!-- End of Registration Form -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include('management_components/script')
</body>
</html>