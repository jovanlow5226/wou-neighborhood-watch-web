<!DOCTYPE html>
<html lang="en">
@include('resident_components.header')
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @include('resident_components.sidebar')
            @include('resident_components.topbar')
            <!-- Page Content -->
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Facilities List</h1>
                    <form action="{{ route('facilities.index') }}" method="GET">
                        <button class="btn btn-theme">Go Back</button>
                    </form>
                </div>
                <div class="row">
                    @foreach ($facilities as $facility)
                        <div class="col-lg-4 mb-4">
                            <div class="card @if ($facility->status_id == 2 || $facility->status_id == 3) disabled @endif"
                                @if ($facility->status_id == 2 || $facility->status_id == 3) title="{{ $facility->status->name }}" @endif
                                onclick="window.location.href='{{ route('facilities.show', $facility->id) }}'">
                                @if ($facility->status_id == 2 || $facility->status_id == 3)
                                    <div class="overlay">
                                        {{ $facility->status->name }}
                                    </div>
                                @endif
                                <img src="{{ asset($facility->image_url) }}" class="card-img-top" alt="{{ $facility->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $facility->name }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
    @include('resident_components.script')
</body>
</html>
