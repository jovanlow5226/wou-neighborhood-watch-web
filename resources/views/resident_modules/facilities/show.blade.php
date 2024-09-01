<!DOCTYPE html>
<html lang="en">
@include('resident_components.header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
<body>
    <div class="container-fluid">
        <div class="row">
            @include('resident_components.sidebar')
            @include('resident_components.topbar')
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">{{ $facility->name }}</h1>
                    <form action="{{ route('facilities.list') }}" method="GET">
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
                <div class="row">
                    <div class="col-lg-8">
                        <div id="calendar"></div>
                    </div>
                    <div class="col-lg-4">
                        <!-- <div id="selected-date" class="mb-3" style="font-weight: bold;"></div> -->
                        
                        <form id="booking-form" action="{{ route('facilities.book', $facility->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="date" id="date">
                            <div id="date-selector" class="form-group">
                                <label for="date">Select Date</label>
                                <input type="date" class="form-control" id="selected_date">
                            </div>
                            <div class="form-group">
                                <label for="start_time">Start Time</label>
                                <input type="time" class="form-control" name="start_time" id="start_time" min="07:00:00" max="21:00:00" required>
                            </div>
                            <div class="form-group">
                                <label for="end_time">End Time</label>
                                <input type="time" class="form-control" name="end_time" id="end_time" min="08:00:00" max="22:00:00" required>
                            </div>
                            <div class="form-group">
                                <label for="event_type">Event Type</label>
                                <input type="text" class="form-control" name="event_type" id="event_type" required>
                            </div>
                            <div class="form-group">
                                <label for="attendees">Expected Attendees</label>
                                <input type="number" class="form-control" name="attendees" id="attendees" required>
                            </div>
                            <div class="form-group">
                                <label for="requirements">Special Requirements</label>
                                <textarea class="form-control" name="requirements" id="requirements"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Book Now</button>
                        </form>
                        <div id="booking-details" style="display:none;">
                            <h5>Booking Details</h5>
                            <p><strong>Date:</strong> <span id="booking-date"></span></p>
                            <p><strong>Start Time:</strong> <span id="booking-start-time"></span></p>
                            <p><strong>End Time:</strong> <span id="booking-end-time"></span></p>
                            <p><strong>Event Type:</strong> <span id="booking-event-type"></span></p>
                            <p><strong>Attendees:</strong> <span id="booking-attendees"></span></p>
                            <p><strong>Special Requirements:</strong> <span id="booking-requirements"></span></p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include('resident_components.script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function() {
            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'agendaWeek'
                },
                defaultView: 'agendaWeek',
                selectable: false, // Disable selecting in the calendar
                selectHelper: true,
                slotDuration: '00:30:00', // Interval between slots is 30 minutes
                businessHours: {
                    // Days and hours for business hours
                    dow: [1, 2, 3, 4, 5, 6, 7], // Monday - Sunday
                    start: '07:00', // 7am
                    end: '19:00' // 7pm
                },
                events: function(start, end, timezone, callback) {
                    $.ajax({
                        url: '/api/facilities/{{ $facility->id }}/bookings',
                        success: function(data) {
                            var events = [];
                            $(data).each(function() {
                                events.push({
                                    title: 'Booked',
                                    start: this.start_datetime,
                                    end: this.end_datetime,
                                    allDay: false,
                                    backgroundColor: '#ff0000',
                                    borderColor: '#ff0000',
                                    attendees: this.attendees,
                                    special_requirements: this.special_requirements
                                });
                            });
                            callback(events);
                        }
                    });
                },
                // viewRender: function(view, element) {
                //     $('#selected-date').text('Selected Date: ' + view.title);
                // }
            });

            // Handle time selection in the booking form
            $('#start_time, #end_time').change(function() {
                var startTime = $('#start_time').val();
                var endTime = $('#end_time').val();
                $('#booking-start-time').text(startTime);
                $('#booking-end-time').text(endTime);

                // Update calendar selection
                var selectedDate = $('#date').val();
                var startDateTime = moment(selectedDate + ' ' + startTime, 'YYYY-MM-DD HH:mm');
                var endDateTime = moment(selectedDate + ' ' + endTime, 'YYYY-MM-DD HH:mm');

                calendar.fullCalendar('select', startDateTime, endDateTime);
            });

            // Handle form submission
            $('#booking-form').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#booking-form').hide();
                        $('#booking-details').show();
                        $('#booking-date').text(response.date);
                        $('#booking-start-time').text(response.start_time);
                        $('#booking-end-time').text(response.end_time);
                        $('#booking-event-type').text(response.event_type);
                        $('#booking-attendees').text(response.attendees);
                        $('#booking-requirements').text(response.requirements);

                        // Display success message
                        $('#messages').html('<div class="alert alert-success">'+ response.success +'</div>');
                    },
                    error: function(xhr) {
                        // Display error message
                        $('#messages').html('<div class="alert alert-danger">'+ xhr.responseJSON.error +'</div>');
                    }
                });
            });

            // Handle date selection in the right panel
            $('#selected_date').change(function() {
                var selectedDate = $(this).val();
                $('#date').val(selectedDate);
                $('#selected-date').text('Selected Date: ' + moment(selectedDate).format('MMMM Do YYYY'));
            });
        });
    </script>
</body>
</html>
