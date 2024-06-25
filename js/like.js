// File: js/like.js

$(document).ready(function() {
    $('.like-button').click(function() {
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
