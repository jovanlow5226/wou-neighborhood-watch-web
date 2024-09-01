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

        function getFacilityDataByRow(facilityId, status) {
            // Send AJAX request to retrieve data for the specified facility ID
            $.ajax({
                url: '/get-facility-data', // Endpoint to fetch facility data
                method: 'GET',
                data: { facility_id: facilityId }, // Pass facility ID as parameter
                success: function(response) {

                    // Populate modal with fetched data
                    $('#facilityOverviewModal .modal-body').html(response);
                    // Open the modal
                    $('#facilityOverviewModal').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }
    });
</script>