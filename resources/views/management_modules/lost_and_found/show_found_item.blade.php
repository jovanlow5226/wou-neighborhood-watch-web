<!DOCTYPE html>
<html lang="en">
@include('management_components.header')
<body>
    <div class="container-fluid">
        <div class="row">
            @include('management_components.sidebar')
            @include('management_components.topbar')
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">{{ $foundItem->title }}</h1>
                    <form action="{{ route('lost_and_found.index') }}" method="GET">
                        <button class="btn btn-theme">Go Back</button>
                    </form>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">{{ $foundItem->title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Category: {{ $foundItem->category->name }}</h6>
                                <p class="card-text"><strong>Description:</strong> {{ $foundItem->description }}</p>
                                <p class="card-text"><strong>Location:</strong> {{ $foundItem->location }}</p>
                                <p class="card-text"><strong>Found By:</strong> {{ $foundItem->user->name }}</p>
                                @if($foundItem->image_path)
                                    <div class="text-center my-3">
                                        <img src="{{ Storage::url($foundItem->image_path) }}" alt="{{ $foundItem->title }}" class="img-fluid rounded">
                                    </div>
                                @endif
                                <p class="card-text"><strong>Contact Information:</strong> {{ $foundItem->contact_info }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include('management_components.script')
</body>
</html>
