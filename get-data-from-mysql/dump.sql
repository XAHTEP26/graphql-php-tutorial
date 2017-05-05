CREATE TABLE IF NOT EXISTS `friendships` (
  `user_id` int(11) DEFAULT NULL,
  `friend_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `friendships` (`user_id`, `friend_id`) VALUES
(1, 2),
(2, 1),
(3, 4),
(4, 3),
(1, 5),
(5, 1),
(1, 6),
(6, 1),
(2, 5),
(5, 2),
(2, 6),
(6, 2),
(5, 6),
(6, 5);

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `name`, `email`) VALUES
(1, 'Иван', '81ivan18@mail.ru'),
(2, 'Игорь', '007igor@yandex.ru'),
(3, 'Алиса', 'alisa1991@gmail.com'),
(4, 'Николай', 'nmack777@mail.ru'),
(5, 'Виктория', 'viktory.best.18@mail.ru'),
(6, 'Сергей', 'gray2017gray@yandex.ru');


ALTER TABLE `friendships`
  ADD KEY `FK_friendships_user_id` (`user_id`),
  ADD KEY `FK_friendships_friend_id` (`friend_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;

ALTER TABLE `friendships`
  ADD CONSTRAINT `FK_friendships_friend_id` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_friendships_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
