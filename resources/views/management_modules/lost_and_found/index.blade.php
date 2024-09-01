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
                    <h1 class="h2">Lost and Found Management</h1>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <form method="GET" action="{{ url('lost-and-found-management') }}">
                                <div class="form-group">
                                    <label for="category">Filter by Category:</label>
                                    <select id="category" name="category_id" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"{{ request('category_id') == $category->id ? ' selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Filter by Status:</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Open"{{ request('status') == 'Open' ? ' selected' : '' }}>Open</option>
                                        <option value="Found"{{ request('status') == 'Found' ? ' selected' : '' }}>Found</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>
                        <div class="mt-3">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Reported By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->category->name }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            <a href="{{ url('lost-and-found-management/' . $item->id) }}" class="btn btn-sm btn-info">View</a>
                                            @if($item->status != 'Found')
                                            <form action="{{ url('lost-and-found-management/' . $item->id . '/update') }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <input type="hidden" name="status" value="Found">
                                                <button type="submit" class="btn btn-sm btn-success">Mark as Found</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Custom Pagination -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-end">
                                    <!-- Previous Page Link -->
                                    @if ($items->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $items->previousPageUrl() }}" tabindex="-1">Previous</a>
                                        </li>
                                    @endif

                                    <!-- Page Numbers -->
                                    @for ($i = 1; $i <= $items->lastPage(); $i++)
                                        <li class="page-item {{ $items->currentPage() == $i ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $items->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    <!-- Next Page Link -->
                                    @if ($items->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $items->nextPageUrl() }}">Next</a>
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
                </div>
            </main>
        </div>
    </div>
    @include('management_components/script')
</body>
</html>
