$(document).ready(function() {
    $('.like-button').off('click').on('click', function() { // https://stackoverflow.com/questions/14969960/jquery-click-events-firing-multiple-times
        var postId = $(this).data('post-id');
        var likeCountElement = $(this).siblings('.like-count');
        
        $.ajax({
            type: 'POST',
            url: 'php/processa-like.php',
            data: { post_id: postId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    likeCountElement.text(response.newLikeCount);
                    if (response.isLiked) {
                        $('.like-button').addClass('liked'); 
                    } else {
                        $('.like-button').removeClass('liked');
                    }
                } else {
                    console.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
