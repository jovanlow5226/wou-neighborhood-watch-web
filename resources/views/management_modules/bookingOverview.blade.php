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
                                    <h4 class="mb-0">Booking Management</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="new-tab" data-toggle="tab" href="#new" role="tab" aria-controls="new" aria-selected="true">New Requests</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="approved-tab" data-toggle="tab" href="#approved" role="tab" aria-controls="approved" aria-selected="false">Approved Requests</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="rejected-tab" data-toggle="tab" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">Rejected Requests</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="new" role="tabpanel" aria-labelledby="new-tab">
                                            <br/>
                                            <input type="text" id="searchInputNew" class="form-control mb-3" placeholder="Search...">
                                            <!-- Table -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" id="newTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Booking ID</th>
                                                            <th>Facility</th>
                                                            <th>Unit ID / Name</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($newRequests as $index => $booking)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $booking->id }}</td>
                                                            <td>{{ $booking->facilities->name }}</td>
                                                            <td>{{ $booking->user->login_id }} ({{ $booking->user->name }})</td>
                                                            <td>{{ $booking->created_at }}</td>
                                                            <td><i class="fas fa-eye table-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#bookingOverviewModal" onClick="getBookingDataByBookingId({{$booking->id}}, 'New');"></i></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Pagination -->
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination justify-content-end">
                                                    <!-- Previous Page Link -->
                                                    @if ($newRequests->onFirstPage())
                                                        <li class="page-item disabled">
                                                            <span class="page-link">Previous</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $newRequests->previousPageUrl() }}" tabindex="-1">Previous</a>
                                                        </li>
                                                    @endif

                                                    <!-- Page Numbers -->
                                                    @for ($i = 1; $i <= $newRequests->lastPage(); $i++)
                                                        <li class="page-item {{ $newRequests->currentPage() == $i ? 'active' : '' }}">
                                                            <a class="page-link" href="{{ $newRequests->url($i) }}">{{ $i }}</a>
                                                        </li>
                                                    @endfor

                                                    <!-- Next Page Link -->
                                                    @if ($newRequests->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $newRequests->nextPageUrl() }}">Next</a>
                                                        </li>
                                                    @else
                                                        <li class="page-item disabled">
                                                            <span class="page-link">Next</span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </nav>
                                        </div>
                                        <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                                            <br/>
                                            <input type="text" id="searchInputApproved" class="form-control mb-3" placeholder="Search...">
                                            <!-- Table -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" id="approvedTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Booking ID</th>
                                                            <th>Facility</th>
                                                            <th>Unit ID</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($approvedRequests as $index => $booking)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $booking->id }}</td>
                                                            <td>{{ $booking->facilities->name }}</td>
                                                            <td>{{ $booking->user->login_id }} ({{ $booking->user->name }})</td>
                                                            <td>{{ $booking->created_at }}</td>
                                                            <td><i class="fas fa-eye table-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#bookingOverviewModal" onClick="getBookingDataByBookingId({{$booking->id}}, 'Approved');"></i></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Pagination -->
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination justify-content-end">
                                                    <!-- Previous Page Link -->
                                                    @if ($approvedRequests->onFirstPage())
                                                        <li class="page-item disabled">
                                                            <span class="page-link">Previous</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $approvedRequests->previousPageUrl() }}" tabindex="-1">Previous</a>
                                                        </li>
                                                    @endif

                                                    <!-- Page Numbers -->
                                                    @for ($i = 1; $i <= $approvedRequests->lastPage(); $i++)
                                                        <li class="page-item {{ $approvedRequests->currentPage() == $i ? 'active' : '' }}">
                                                            <a class="page-link" href="{{ $approvedRequests->url($i) }}">{{ $i }}</a>
                                                        </li>
                                                    @endfor

                                                    <!-- Next Page Link -->
                                                    @if ($approvedRequests->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $approvedRequests->nextPageUrl() }}">Next</a>
                                                        </li>
                                                    @else
                                                        <li class="page-item disabled">
                                                            <span class="page-link">Next</span>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </nav>
                                        </div>
                                        <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                                            <br/>
                                            <input type="text" id="searchInputRejected" class="form-control mb-3" placeholder="Search...">
                                            <!-- Table -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped" id="rejectedTable">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Booking ID</th>
                                                            <th>Facility</th>
                                                            <th>Unit ID</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($rejectedRequests as $index => $booking)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $booking->id }}</td>
                                                            <td>{{ $booking->facilities->name }}</td>
                                                            <td>{{ $booking->user->login_id }} ({{ $booking->user->name }})</td>
                                                            <td>{{ $booking->created_at }}</td>
                                                            <td><i class="fas fa-eye table-btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#bookingOverviewModal" onClick="getBookingDataByBookingId({{$booking->id}}, 'Rejected');"></i></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Pagination -->
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination justify-content-end">
                                                    <!-- Previous Page Link -->
                                                    @if ($rejectedRequests->onFirstPage())
                                                        <li class="page-item disabled">
                                                            <span class="page-link">Previous</span>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $rejectedRequests->previousPageUrl() }}" tabindex="-1">Previous</a>
                                                        </li>
                                                    @endif

                                                    <!-- Page Numbers -->
                                                    @for ($i = 1; $i <= $rejectedRequests->lastPage(); $i++)
                                                        <li class="page-item {{ $rejectedRequests->currentPage() == $i ? 'active' : '' }}">
                                                            <a class="page-link" href="{{ $rejectedRequests->url($i) }}">{{ $i }}</a>
                                                        </li>
                                                    @endfor

                                                    <!-- Next Page Link -->
                                                    @if ($rejectedRequests->hasMorePages())
                                                        <li class="page-item">
                                                            <a class="page-link" href="{{ $rejectedRequests->nextPageUrl() }}">Next</a>
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
                                <!-- Modal -->
                                <div class="modal fade" id="bookingOverviewModal" tabindex="-1" role="dialog" aria-labelledby="bookingOverviewModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="bookingOverviewModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn  btn-theme-outline" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-theme">Save changes</button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include('management_components/script')
    @include('management_components/booking_script')
</body>
</html>
