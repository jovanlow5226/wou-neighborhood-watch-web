<!DOCTYPE html>
<html lang="en">
@include('management_components/header')
<body>

<div class="container-fluid mt-5">
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <!-- Add more indicators as needed for additional images -->
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('images/building/building_01.png') }}" alt="First slide" style="width:300px; height:400px;">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/building/building_02.png') }}" alt="Second slide" style="width:300px; height:400px;">
            </div>
            <!-- Add more carousel items as needed for additional images -->
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header theme-bg-color-dark">
                    <h4 class="mb-0"><i class="fas fa-lock"></i> Welcome to WOU Condominium Resident Portal</h4>
                </div>
                <div class="card-body">
                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <!-- Login As -->
                        <div class="form-group">
                            <label class="mb-0">Login As</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="owner_tenant" name="user_type" value="owner_tenant" checked>
                                <label class="form-check-label" for="owner_tenant">Owner/Tenant</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="management" name="user_type" value="management">
                                <label class="form-check-label" for="management">Management</label>
                            </div>
                        </div>
                        <!-- Login ID / Unit No -->
                        <div class="form-group">
                            <label for="login_id">Login ID / Unit No</label>
                            <input type="text" id="login_id" class="form-control" name="login_id" placeholder="Enter Login ID / Unit No" required>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="Enter Password" required>
                        </div>
                        <!-- Forgot Password Link -->
                        <div class="form-group mb-3">
                            <a href="{{ route('password.request') }}">Forgot Password?</a>
                        </div>
                        <!-- Login Button -->
                        <button type="submit" class="btn btn-theme btn-block"><i class="fas fa-sign-in-alt"></i> Login</button>
                    </form>
                    <!-- End of Login Form -->
                </div>
            </div>
        </div>
    </div>
</div>

@include('management_components/script')

</body>
</html>
