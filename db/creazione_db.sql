-- Database Section
-- ________________ 

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
-- SET time_zone = "+00:00";

create database `music_in`;
use `music_in`;
-- CREATE SCHEMA IF NOT EXISTS `music_in` DEFAULT CHARACTER SET utf8 ;
-- USE `music_in` ;

-- Tables Section
-- _____________ 

create table comments (
     `id` int not null AUTO_INCREMENT,
     `content` varchar(255) not null,
     `created_at` timestamp not null DEFAULT current_timestamp(),
     `user_id` int not null,
     `post_id` int not null,
     constraint `IDCommento` primary key (`id`));

create table follows (
     `followed_id` int not null,
     `follower_id` int not null,
     constraint `IDfollows` primary key (`follower_id`, `followed_id`));

create table likes (
     `post_id` int not null,
     `user_id` int not null,
     constraint `IDUserLikes` primary key (`post_id`, `user_id`));

create table notifications (
     `id` int not null AUTO_INCREMENT,
     `type` int not null,
     `created_at` timestamp not null DEFAULT current_timestamp(),
     `was_read` boolean not null DEFAULT false,
     `receiver_id` int not null,
     `creator_id` int not null,
     `post_id` int,
     `comment_id` int,
     constraint `IDNotifica` primary key (`id`));

create table posts (
     `id` int not null AUTO_INCREMENT,
     `title` varchar(255) not null,
     `content` varchar(255) not null,
     `image` varchar(255),
     `song` varchar(255),
     `created_at` timestamp not null DEFAULT current_timestamp(),
     `user_id` int not null,
     constraint `IDPost` primary key (`id`));

create table genres (
     `id` int not null AUTO_INCREMENT,
     `name` varchar(255) not null,
     constraint `IDgenres` primary key (`id`));

-- create table usergenres (
--      `genre_id` int not null,
--      `user_id` int not null,
--      constraint `IDusergenres` primary key (`genre_id`, `user_id`));

create table users (
     `id` int not null AUTO_INCREMENT,
     `username` varchar(255) not null,
     `password` varchar(255) not null,
     `email` varchar(255) not null,
     `name` varchar(255),
     `surname` varchar(255),
     `image` varchar(255),
     `genre_id` int,
     constraint `IDUser` primary key (`id`),
     unique key `username` (`username`),
     unique key `email` (`email`));


-- Constraints Section
-- ___________________ 

alter table `comments`
     add constraint `FKscrive` foreign key (`user_id`) references `users` (`id`),
     add constraint `FKassociato` foreign key (`post_id`) references `posts` (`id`);

alter table `follows`
     add constraint `FKfollower` foreign key (`follower_id`) references `users` (`id`),
     add constraint `FKfollowed` foreign key (`followed_id`) references `users` (`id`);

alter table `likes`
     add constraint `FKlikes_User` foreign key (`user_id`) references `users` (`id`),
     add constraint `FKlikes_Post` foreign key (`post_id`) references `posts` (`id`);

alter table `notifications`
     add constraint `FKreceiver` foreign key (`receiver_id`) references `users` (`id`),
     add constraint `FKcreator` foreign key (`creator_id`) references `users` (`id`),
     add constraint `FKreferences` foreign key (`post_id`) references `posts` (`id`),
     add constraint `FKR` foreign key (`comment_id`) references `comments` (`id`);

alter table `posts`
     add constraint `FKpubblica` foreign key (`user_id`) references `users` (`id`);

-- alter table `usergenres`
--      add constraint `FKlis_use` foreign key (`user_id`) references `users` (`id`),
--      add constraint `FKlis_gen` foreign key (`genre_id`) references `genres` (`id`);

alter table `users`
     add constraint `FKfavgenre` foreign key (`genre_id`) references `genres` (`id`);


-- Index Section
-- _____________ 

-- Data

use `music_in`;

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Rock'),
(2, 'Pop'),
(3, 'Jazz'),
(4, 'Blues'),
(5, 'Metal'),
(6, 'Rap'),
(7, 'Classical'),
(8, 'Electronic'),
(9, 'Techno'),
(10, 'House');

INSERT INTO `users` (`id`, `username`, `email`, `password`, `image`) VALUES
(1, 'admin', 'admin@admin.com', '', NULL),
(2, 'user2', 'user2@user2.com', '', NULL),
(3, 'user3', 'user3@user3.com', '', NULL),
(4, 'user4', 'user4@user4.com', '', NULL),
(5, 'user5', 'user5@user5.com', '', NULL);

INSERT INTO `posts` (`id`, `title`, `content`, `image`, `song`, `created_at`, `user_id`) VALUES
(1, 'Title1', 'Content1', '', '', '2024-06-16 13:13:08', 1),
(2, 'Title2', 'Content2', '', '', '2024-06-16 13:13:23', 1),
(3, 'Title3', 'Content3', '', '', '2024-06-16 13:51:43', 1),
(4, 'Title4', 'Content4', '', '', '2024-06-16 13:57:08', 1);

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
(1, 0, '2024-06-16 13:13:08', 0, 1, 2, 1, NULL),
(2, 0, '2024-06-16 13:13:23', 0, 1, 3, 1, NULL),
(3, 0, '2024-06-16 13:51:43', 0, 1, 4, 1, NULL);

INSERT INTO `notifications` (`id`, `type`, `created_at`, `receiver_id`, `creator_id`, `post_id`, `comment_id`) VALUES
(4, 0, '2024-06-16 13:57:08', 1, 5, 1, NULL);

-- INSERT into `usergenres` (`genre_id`, `user_id`) VALUES
-- (1, 1),
-- (2, 1),
-- (1, 2),
-- (2, 2),
-- (3, 2);

COMMIT;
