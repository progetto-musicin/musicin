
use `music_in`;

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Rock'),
(2, 'Pop'),
(3, 'Jazz'),
(4, 'Blues'),
(5, 'Metal'),
(6, 'Rap'),
(7, 'Classical'),
(11, 'Electronic'),
(17, 'Techno'),
(18, 'House');

INSERT INTO `users` (`id`, `username`, `email`, `password`, `image`) VALUES
(1, 'admin', 'admin@admin.com', '', NULL),
(2, 'user', 'user@user.com', '', NULL),
(3, 'user1', 'user1@user1.com', '', NULL),
(4, 'user2', 'user2@user2.com', '', NULL),
(5, 'user3', 'user3@user3.com', '', NULL);

INSERT INTO `posts` (`id`, `title`, `content`, `image`, `song`, `created_at`, `user_id`) VALUES
(1, 'Post1', 'Content1', '', '', '2024-06-16 13:13:08', 1),
(2, 'Post2', 'Content2', '', '', '2024-06-16 13:13:23', 1),
(3, 'Post3', 'Content3', '', '', '2024-06-16 13:51:43', 1),
(4, 'Post4', 'Content4', '', '', '2024-06-16 13:57:08', 1);

INSERT into `follows` (`followed_id`, `follower_id`) VALUES
(1, 2),
(2, 1),
(1, 3),
(1, 4);

INSERT into `likes` (`post_id`, `user_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4);

INSERT INTO `comments` (`id`, `content`, `created_at`, `user_id`, `post_id`) VALUES
(1, 'Comment1', '2024-06-16 13:13:08', 1, 1),
(2, 'Comment2', '2024-06-16 13:13:23', 2, 1),
(3, 'Comment3', '2024-06-16 13:51:43', 3, 1),
(4, 'Comment4', '2024-06-16 13:57:08', 4, 1);

INSERT INTO `notifications` (`id`, `type`, `created_at`, `was_read`, `receiver_id`, `creator_id`, `post_id`, `comment_id`) VALUES
(1, 1, '2024-06-16 13:13:08', 0, 1, 2, 1, NULL),
(2, 1, '2024-06-16 13:13:23', 0, 1, 3, 1, NULL),
(3, 1, '2024-06-16 13:51:43', 0, 1, 4, 1, NULL),
(4, 1, '2024-06-16 13:57:08', 0, 1, 5, 1, NULL);
