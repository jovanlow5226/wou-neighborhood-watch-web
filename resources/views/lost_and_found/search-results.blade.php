<!DOCTYPE html>
<html lang="en">
@include('resident_components/header')
<body>
    <div class="container-fluid">
        <div class="row">
            @include('resident_components/sidebar')
            @include('resident_components/topbar')
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Search Results</h1>
                    <form action="{{ route('lost_and_found.index') }}" method="GET">
                        <button class="btn btn-theme">Go Back</button>
                    </form>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @if($lostItems->isEmpty())
                            <p>No results found.</p>
                        @else
                            <div class="list-group">
                                @foreach($lostItems as $lostItem)
                                    <a href="{{ route('lost_and_found.show', $lostItem->id) }}" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{ $lostItem->title }}</h5>
                                            <small>{{ $lostItem->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1">{{ $lostItem->description }}</p>
                                        <small>Location: {{ $lostItem->location }}</small>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include('resident_components/script')
</body>
</html>
