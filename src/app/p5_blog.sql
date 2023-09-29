-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 18 sep. 2023 à 08:19
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `p5_blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `author` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `author`, `created_at`, `updated_at`, `user_id`) VALUES
(54, 'Bienvenue sur mon blog', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.\r\n\r\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.\r\n\r\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.', 'tony', '2023-09-05 12:38:00', '2023-09-07 16:52:17', 280),
(55, 'Article 1', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.', 'tony', '2023-09-05 12:41:58', '2023-09-07 16:52:17', 280),
(56, 'Article 2', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.\r\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.\r\n\r\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.\r\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.', 'tony', '2023-09-05 12:42:29', '2023-09-07 16:52:17', 280),
(57, 'Article 3', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.\r\n\r\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.', 'tony', '2023-09-05 12:43:10', '2023-09-07 16:52:17', 280),
(58, 'Article 4', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.', 'tony', '2023-09-05 12:44:06', '2023-09-07 16:52:17', 280),
(59, 'Article 5', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.\r\n\r\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.\r\n\r\nLorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.', 'tony', '2023-09-05 12:44:20', '2023-09-07 16:52:17', 280),
(60, 'Article 6', '1Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod corporis excepturi est neque quaerat adipisci incidunt assumenda dolor necessitatibus dolores dolorum, officiis quo quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.quibusdam recusandae accusantium molestiae esse cum veniam. Vero mollitia reprehenderit quo hic rem, maiores sit accusantium adipisci totam molestiae. Dignissimos, temporibus culpa excepturi odio suscipit nemo saepe.', 'tony', '2023-09-05 12:44:37', '2023-09-15 13:47:50', 280);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `content` text NOT NULL,
  `article_id` int NOT NULL,
  `user_id` int NOT NULL,
  `published` tinyint NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `content`, `article_id`, `user_id`, `published`, `created_at`, `updated_at`) VALUES
(101, 'J&#039;adore, à suivre ..', 54, 286, 1, '2023-09-05 12:49:39', '2023-09-05 12:49:39'),
(103, 'test commentaire 22', 60, 280, 1, '2023-09-08 13:12:36', '2023-09-08 13:12:36'),
(105, 'test', 60, 280, 1, '2023-09-15 13:48:19', '2023-09-15 13:48:19'),
(106, 'commentaire', 60, 290, 0, '2023-09-18 10:17:34', '2023-09-18 10:17:34');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `age` int DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `age`, `avatar`, `role`, `email`, `password`, `created_at`, `updated_at`) VALUES
(76, 'John', 'Doee', 55, 'a3daf4d2c60df2811d8936af4b5c13eb.jpg', '[\"ROLE_USER\"]', 'marques.toony@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$bG52cExSSGwzY1pJRXozZg$I777KHY0oklL9nAsBxshfg03EamAywJheZ1QqirQE9k', '2023-08-25 18:50:35', '2023-08-25 18:50:35'),
(181, 'firstname 1', 'lastname 1', 19, '09611dd44cb6580bf8bd0b5f5c5f829d.jpg', '[\"ROLE_USER\"]', 'test1@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$Y1cwQVM2Z2pTUnlDSncwcg$KBC2trgBwJ1mMsSWuIP+WAzEStkKLpzvUIJeWVgf9o4', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(182, 'firstname 2', 'lastname 2', 71, NULL, '[\"ROLE_USER\"]', 'test2@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(183, 'firstname 3', 'lastname 3', 50, NULL, '[\"ROLE_USER\"]', 'test3@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(184, 'firstname 4', 'lastname 4', 87, NULL, '[\"ROLE_USER\"]', 'test4@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(185, 'firstname 5', 'lastname 5', 72, NULL, '[\"ROLE_USER\"]', 'test5@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(186, 'firstname 6', 'lastname 6', 19, NULL, '[\"ROLE_USER\"]', 'test6@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(188, 'firstname 8', 'lastname 8', 25, NULL, '[\"ROLE_USER\"]', 'test8@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(190, 'firstname 10', 'lastname 10', 91, NULL, '[\"ROLE_USER\"]', 'test10@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(191, 'firstname 11', 'lastname 11', 92, NULL, '[\"ROLE_USER\"]', 'test11@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(192, 'firstname 12', 'lastname 12', 82, NULL, '[\"ROLE_USER\"]', 'test12@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(193, 'firstname 13', 'lastname 13', 50, NULL, '[\"ROLE_USER\"]', 'test13@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(194, 'firstname 14', 'lastname 14', 29, NULL, '[\"ROLE_USER\"]', 'test14@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(195, 'firstname 15', 'lastname 15', 31, NULL, '[\"ROLE_USER\"]', 'test15@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(196, 'firstname 16', 'lastname 16', 36, NULL, '[\"ROLE_USER\"]', 'test16@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(197, 'firstname 17', 'lastname 17', 93, NULL, '[\"ROLE_USER\"]', 'test17@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(198, 'firstname 18', 'lastname 18', 46, NULL, '[\"ROLE_USER\"]', 'test18@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(199, 'firstname 19', 'lastname 19', 46, NULL, '[\"ROLE_USER\"]', 'test19@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(200, 'firstname 20', 'lastname 20', 40, NULL, '[\"ROLE_USER\"]', 'test20@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(201, 'firstname 21', 'lastname 21', 66, NULL, '[\"ROLE_USER\"]', 'test21@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(202, 'firstname 22', 'lastname 22', 87, NULL, '[\"ROLE_USER\"]', 'test22@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(203, 'firstname 23', 'lastname 23', 92, NULL, '[\"ROLE_USER\"]', 'test23@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(204, 'firstname 24', 'lastname 24', 39, NULL, '[\"ROLE_USER\"]', 'test24@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(205, 'firstname 25', 'lastname 25', 29, NULL, '[\"ROLE_USER\"]', 'test25@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(206, 'firstname 26', 'lastname 26', 18, NULL, '[\"ROLE_USER\"]', 'test26@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(207, 'firstname 27', 'lastname 27', 41, NULL, '[\"ROLE_USER\"]', 'test27@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(208, 'firstname 28', 'lastname 28', 60, NULL, '[\"ROLE_USER\"]', 'test28@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(209, 'firstname 29', 'lastname 29', 31, NULL, '[\"ROLE_USER\"]', 'test29@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(210, 'firstname 30', 'lastname 30', 62, NULL, '[\"ROLE_USER\"]', 'test30@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(211, 'firstname 31', 'lastname 31', 92, NULL, '[\"ROLE_USER\"]', 'test31@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(212, 'firstname 32', 'lastname 32', 58, NULL, '[\"ROLE_USER\"]', 'test32@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(213, 'firstname 33', 'lastname 33', 64, NULL, '[\"ROLE_USER\"]', 'test33@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(214, 'firstname 34', 'lastname 34', 44, NULL, '[\"ROLE_USER\"]', 'test34@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(215, 'firstname 35', 'lastname 35', 56, NULL, '[\"ROLE_USER\"]', 'test35@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(216, 'firstname 36', 'lastname 36', 77, NULL, '[\"ROLE_USER\"]', 'test36@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(217, 'firstname 37', 'lastname 37', 91, NULL, '[\"ROLE_USER\"]', 'test37@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(218, 'firstname 38', 'lastname 38', 31, NULL, '[\"ROLE_USER\"]', 'test38@gmail.com', 'a', '2023-08-27 18:53:40', '2023-08-27 18:53:40'),
(240, 'firstname 60', 'lastname 60', 91, NULL, '[\"ROLE_USER\"]', 'test60@gmail.com', 'a', '2023-08-27 18:53:41', '2023-08-27 18:53:41'),
(241, 'firstname 61', 'lastname 61', 40, NULL, '[\"ROLE_USER\"]', 'test61@gmail.com', 'a', '2023-08-27 18:53:41', '2023-08-27 18:53:41'),
(280, 'tony', 'Marques', 31, '0547106aff3f6cf9eb46f9c276c5132e.jpg', '[\"ROLE_ADMIN\"]', 'admin@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$YW9KdXp6S3cxZWd2QnlyZg$tPbgKIDfeANRu7aCk2EeN5o3zUacGPM8ovV16kVCaa8', '2023-09-02 17:59:39', '2023-09-02 17:59:39'),
(286, 'Bernard', 'Petit', NULL, NULL, '[\"ROLE_USER\"]', 'bernard.petit@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$RUdncFFmeS95cmFzSHlWMA$NRtebd8r7WclcKd3EU+ltDkxg6yhAD1A0X5rArLe8OE', '2023-09-05 12:48:09', '2023-09-05 12:48:09'),
(289, 'tony', 'tony Marques', NULL, NULL, '[\"ROLE_USER\"]', 'marques.todddony@gmail.com', '$argon2i$v=19$m=65536,t=4,p=1$ZTVqNllsdUtEUVpZMHNvTQ$5WKTyvoimkmukPOIWf+68neTrcK4/srcgdm2M+hM15s', '2023-09-11 22:24:14', '2023-09-11 22:24:14'),
(290, 'tony', 'tony Marques', 31, '386616af04811c7884ea4994f61c61ce.png', '[\"ROLE_USER\"]', 'tony.marques@live.fr', '$argon2i$v=19$m=65536,t=4,p=1$Tks3eXV5TmIvU25sN1dYUw$hqj7OrJb8mwLRTFMQBy6zVrO/qMcJD+4JTnwPHhqcHg', '2023-09-18 10:16:40', '2023-09-18 10:16:40');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk.user_idx` (`user_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk.article_idx` (`article_id`),
  ADD KEY `fk.user_idx` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `fk.user.article` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk.article.comment` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk.user.comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
