<!DOCTYPE html>
<html lang="en">
@include('resident_components/header')
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('resident_components/sidebar')
            @include('resident_components/topbar')
            <!-- Page Content -->
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Owner/Tenant Dashboard</h1>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <p>Welcome to the Owner/Tenant Dashboard! You can navigate through the different modules using the side panel.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include('resident_components/script')
</body>
</html>
