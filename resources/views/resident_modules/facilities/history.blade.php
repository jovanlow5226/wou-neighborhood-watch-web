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
                    <h1 class="h2">Booking History</h1>
                    <form action="{{ route('facilities.index') }}" method="GET">
                        <button class="btn btn-theme">Go Back</button>
                    </form>
                </div>
                <div id="messages">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="upcoming-tab" data-toggle="tab" href="#upcoming" role="tab" aria-controls="upcoming" aria-selected="true">Upcoming</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="past-tab" data-toggle="tab" href="#past" role="tab" aria-controls="past" aria-selected="false">Past</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="rejected-tab" data-toggle="tab" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">Rejected</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="cancelled-tab" data-toggle="tab" href="#cancelled" role="tab" aria-controls="rejected" aria-selected="false">Cancelled</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- Upcoming Bookings -->
                    <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                        <div class="list-group mt-3">
                            @forelse ($upcomingBookings as $booking)
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between pad-btm-20">
                                        <h5 class="mb-1">Facility Type: {{ $booking->facilities->name }}</h5>
                                        <span class="badge badge-info h-20">{{ $booking->refBookingStatuses->name }}</span>
                                    </div>
                                    <p class="mb-1">Date and Time: <b>{{ $booking->start_datetime }}</b> to <b>{{ $booking->end_datetime }}</b> </p>
                                    <p class="mb-1">Attendees: {{ $booking->attendees }}</p>
                                    <small>Special Requirements: {{ $booking->special_requirements ?: 'None' }}</small>
                                    <div class="mt-2">
                                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="float-right">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm">Cancel Booking</button>
                                        </form>
                                    </div>
                                </a>
                            @empty
                                <p class="p-3">No upcoming bookings.</p>
                            @endforelse
                        </div>
                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                <!-- Previous Page Link -->
                                @if ($upcomingBookings->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $upcomingBookings->previousPageUrl() }}" tabindex="-1">Previous</a>
                                    </li>
                                @endif

                                <!-- Page Numbers -->
                                @for ($i = 1; $i <= $upcomingBookings->lastPage(); $i++)
                                    <li class="page-item {{ $upcomingBookings->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $upcomingBookings->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Next Page Link -->
                                @if ($upcomingBookings->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $upcomingBookings->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>

                    <!-- Past Bookings -->
                    <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
                        <div class="list-group mt-3">
                            @forelse ($pastBookings as $booking)
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between pad-btm-20">
                                        <h5 class="mb-1">Facility Type: {{ $booking->facilities->name }}</h5>
                                    </div>
                                    <p class="mb-1">Date and Time: <b>{{ $booking->start_datetime }}</b> to <b>{{ $booking->end_datetime }}</b> </p>
                                    <p class="mb-1">Attendees: {{ $booking->attendees }}</p>
                                    <small>Special Requirements: {{ $booking->special_requirements ?: 'None' }}</small>
                                </a>
                            @empty
                                <p class="p-3">No past bookings.</p>
                            @endforelse
                        </div>
                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                <!-- Previous Page Link -->
                                @if ($pastBookings->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pastBookings->previousPageUrl() }}" tabindex="-1">Previous</a>
                                    </li>
                                @endif

                                <!-- Page Numbers -->
                                @for ($i = 1; $i <= $pastBookings->lastPage(); $i++)
                                    <li class="page-item {{ $pastBookings->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $pastBookings->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Next Page Link -->
                                @if ($pastBookings->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pastBookings->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>

                    <!-- Rejected Bookings -->
                    <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                        <div class="list-group mt-3">
                            @forelse ($rejectedBookings as $booking)
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between pad-btm-20">
                                        <h5 class="mb-1">Facility Type: {{ $booking->facilities->name }}</h5>
                                    </div>
                                    <p class="mb-1">Date and Time: <b>{{ $booking->start_datetime }}</b> to <b>{{ $booking->end_datetime }}</b> </p>
                                    <p class="mb-1">Attendees: {{ $booking->attendees }}</p>
                                    <small>Special Requirements: {{ $booking->special_requirements ?: 'None' }}</small>
                                </a>
                            @empty
                                <p class="p-3">No rejected bookings.</p>
                            @endforelse
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                <!-- Previous Page Link -->
                                @if ($rejectedBookings->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $rejectedBookings->previousPageUrl() }}" tabindex="-1">Previous</a>
                                    </li>
                                @endif

                                <!-- Page Numbers -->
                                @for ($i = 1; $i <= $rejectedBookings->lastPage(); $i++)
                                    <li class="page-item {{ $rejectedBookings->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $rejectedBookings->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Next Page Link -->
                                @if ($rejectedBookings->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $rejectedBookings->nextPageUrl() }}">Next</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>

                    <!-- Cancelled Bookings -->
                    <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                        <div class="list-group mt-3">
                            @forelse ($cancelledBookings as $booking)
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between pad-btm-20">
                                        <h5 class="mb-1">Facility Type: {{ $booking->facilities->name }}</h5>
                                    </div>
                                    <p class="mb-1">Date and Time: <b>{{ $booking->start_datetime }}</b> to <b>{{ $booking->end_datetime }}</b> </p>
                                    <p class="mb-1">Attendees: {{ $booking->attendees }}</p>
                                    <small>Special Requirements: {{ $booking->special_requirements ?: 'None' }}</small>
                                </a>
                            @empty
                                <p class="p-3">No rejected bookings.</p>
                            @endforelse
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-end">
                                <!-- Previous Page Link -->
                                @if ($cancelledBookings->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $cancelledBookings->previousPageUrl() }}" tabindex="-1">Previous</a>
                                    </li>
                                @endif

                                <!-- Page Numbers -->
                                @for ($i = 1; $i <= $cancelledBookings->lastPage(); $i++)
                                    <li class="page-item {{ $cancelledBookings->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $cancelledBookings->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Next Page Link -->
                                @if ($cancelledBookings->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $cancelledBookings->nextPageUrl() }}">Next</a>
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
    @include('resident_components.script')
</body>
</html>
