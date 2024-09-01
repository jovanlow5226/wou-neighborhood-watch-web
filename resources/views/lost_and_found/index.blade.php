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
                    <h1 class="h2">Lost and Found</h1>
                    <a href="{{ route('lost_and_found.create') }}" class="btn btn-theme mb-3">Report Lost Item</a>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{ route('lost_and_found.search') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <!-- Form elements here -->
                            </div>
                            <button type="submit" class="btn btn-theme">Search</button>
                        </form>
                        <hr>
                        <div class="list-group">
                            @foreach($lostItems as $lostItem)
                                <a href="{{ route('lost_and_found.show', $lostItem->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $lostItem->title }} 
                                            <span class="badge badge-{{ $lostItem->status == 'Open' ? 'primary' : 'success' }}">
                                                {{ $lostItem->status }}
                                            </span>
                                        </h5>
                                        <small>{{ $lostItem->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">{{ $lostItem->description }}</p>
                                    <small>Location: {{ $lostItem->location }}</small>
                                </a>
                            @endforeach
                        </div>

                        <!-- Custom Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                <!-- Previous Page Link -->
                                @if ($lostItems->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $lostItems->previousPageUrl() }}" tabindex="-1">Previous</a>
                                    </li>
                                @endif

                                <!-- Page Numbers -->
                                @for ($i = 1; $i <= $lostItems->lastPage(); $i++)
                                    <li class="page-item {{ $lostItems->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $lostItems->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Next Page Link -->
                                @if ($lostItems->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $lostItems->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include('resident_components/script')
</body>
</html>
