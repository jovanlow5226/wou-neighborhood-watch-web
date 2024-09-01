<script>
    $(document).ready(function () {
        // Initialize DataTable
        $('.table').DataTable({
            paging: true, // Enable pagination
            searching: true, // Enable search functionality
            ordering: true, // Enable sorting
            order: [], // Initial sorting order (optional)
            info: false, // Hide "Showing x of y entries" info
        });
    });

    function getBookingDataByBookingId(bookingId, status) {
        // Send AJAX request to retrieve data for the specified booking ID
        $.ajax({
            url: '/get-booking-data', // Endpoint to fetch booking data
            method: 'GET',
            data: { booking_id: bookingId }, // Pass booking ID as parameter
            success: function(response) {
                console.log('Booking response:', response);
                // Check if booking data exists
                if (response.hasOwnProperty('current_booking')) {
                    var booking = response.current_booking;
                    var collidingBookings = response.colliding_bookings;

                    // Populate modal with fetched data
                    // Modal Title
                    $('#bookingOverviewModalLabel').html(status + ' Request Details');
                    // Modal Body
                    var modalContent = '<p><strong>Booking ID:</strong> ' + booking.id + '</p>';
                    modalContent += '<p><strong>Facility:</strong> ' + booking.facilities.name + '</p>';
                    modalContent += '<p><strong>Start Date:</strong> ' + booking.start_datetime + '</p>';
                    modalContent += '<p><strong>End Date:</strong> ' + booking.end_datetime + '</p>';
                    modalContent += '<p><strong>Status:</strong> ' + status + '</p>';

                    // Check if there are colliding bookings
                    if (collidingBookings.length > 0) {
                        modalContent += '<hr><p><strong>Colliding Bookings:</strong></p>';
                        collidingBookings.forEach(function(collidingBooking) {
                            modalContent += '<p><strong>Booking ID:</strong> ' + collidingBooking.id + '</p>';
                            modalContent += '<p><strong>Created At:</strong> ' + collidingBooking.created_at + '</p>';
                        });
                    } else {
                        modalContent += '<hr><p>No colliding bookings found.</p>';
                    }

                    $('#bookingOverviewModal .modal-body').html(modalContent);
                    // Open the modal
                    $('#bookingOverviewModal').modal('show');
                } else {
                    // Handle case where booking data is not found
                    console.error('Booking data not found');
                }
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error(error);
            }
        });
    }

    // Attach event listeners to input fields
    document.getElementById("searchInputNew").addEventListener("keyup", function () {
        filterTable("newTable", "searchInputNew");
    });

    document.getElementById("searchInputApproved").addEventListener("keyup", function () {
        filterTable("approvedTable", "searchInputApproved");
    });

    document.getElementById("searchInputRejected").addEventListener("keyup", function () {
        filterTable("rejectedTable", "searchInputRejected");
    });

    function filterTable(tableId, inputId) {
        var input, filter, table, tr, td, i, j, txtValue;
        input = document.getElementById(inputId);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            // Loop through all columns in each row
            for (j = 0; j < tr[i].cells.length; j++) {
                td = tr[i].cells[j];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break; // Break the inner loop if a match is found in any column
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    }




</script>