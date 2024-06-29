$(document).ready(function() {
    $('.like-button').off('click').on('click', function() { // https://stackoverflow.com/questions/14969960/jquery-click-events-firing-multiple-times
        let postId = $(this).data('post-id');
        let likeCountElement = $(this).siblings('.like-count');
        
        $.ajax({
            type: 'POST',
            url: 'php/processa-like.php',
            data: { post_id: postId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    likeCountElement.text(response.newLikeCount);
                    if (response.action === 'like') {
                        $('.like-button').addClass('liked'); 
                        $(`#likeBtn${postId}`).addClass('btn-primary').removeClass('btn-outline-primary');
                    } else {
                        $('.like-button').removeClass('liked');
                        $(`#likeBtn${postId}`).addClass('btn-outline-primary').removeClass('btn-primary');
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
