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
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Management Dashboard</h1>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <p>Welcome to the Management Dashboard! You can navigate through the different modules using the side panel.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include('management_components/script')
</body>
</html>
