-- Database Section
-- ________________ 

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- START TRANSACTION;
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
     `was_read` boolean not null,
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

create table usergenres (
     `genre_id` int not null,
     `user_id` int not null,
     constraint `IDusergenres` primary key (`genre_id`, `user_id`));

create table users (
     `id` int not null AUTO_INCREMENT,
     `username` varchar(255) not null,
     `password` varchar(255) not null,
     `email` varchar(255) not null,
     `name` varchar(255),
     `surname` varchar(255),
     `image` varchar(255),
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

alter table `usergenres`
     add constraint `FKlis_use` foreign key (`user_id`) references `users` (`id`),
     add constraint `FKlis_gen` foreign key (`genre_id`) references `genres` (`id`);


-- Index Section
-- _____________ 

-- COMMIT;
