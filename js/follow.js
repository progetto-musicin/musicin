$(document).on("change", function() {
    $('#followButton').on('click', function(e) {
        e.preventDefault();

        var followed_id = $('#followForm input[name="followed_id"]').val();

        $.ajax({
            type: 'POST',
            url: 'php/processa-follow.php',
            data: { followed_id: followed_id },
            success: function(response) {
                console.log('Azione di follow eseguita con successo');

                $('#followButton').text('Smetti di seguire');
                $('#followForm').attr('action', 'php/processa-unfollow.php');
                $('#followButton').attr('id', 'unfollowButton');
                $('#unfollowButton').removeClass('btn-outline-primary').addClass('btn-outline-danger');
            },
            error: function(xhr, status, error) {
                console.error('Si è verificato un errore durante l\'azione di follow:', error);
            }
        });
    });


    $('#unfollowButton').on('click', function(e) {
        e.preventDefault();

        var followed_id = $('#unfollowForm input[name="followed_id"]').val();

        $.ajax({
            type: 'POST',
            url: 'php/processa-unfollow.php',
            data: { followed_id: followed_id },
            success: function(response) {
                console.log('Azione di unfollow eseguita con successo');
   
                $('#unfollowButton').text('Segui');
                $('#unfollowForm').attr('action', 'php/processa-follow.php');
                $('#unfollowButton').attr('id', 'followButton');
                $('#followButton').removeClass('btn-outline-danger').addClass('btn-outline-primary');
            },
            error: function(xhr, status, error) {
                console.error('Si è verificato un errore durante l\'azione di unfollow:', error);
            }
        });
    });
});
