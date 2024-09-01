<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script>
    $(document).ready(function(){
        $('.profile-dropdown').click(function(e){
            e.stopPropagation(); // Prevent the event from bubbling up to the document
            $('#profileInfo').toggleClass('active');
        });
        
        // Close the profile info card when clicking outside of it
        $(document).click(function(){
            $('#profileInfo').removeClass('active');
        });
    });
</script>