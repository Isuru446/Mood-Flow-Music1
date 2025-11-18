-- Create database and songs table for mood-based music app
CREATE DATABASE IF NOT EXISTS `mood_music` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `mood_music`;

CREATE TABLE IF NOT EXISTS `songs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `artist` VARCHAR(255) DEFAULT '',
  `mood` VARCHAR(100) DEFAULT '',
  `playlist` VARCHAR(255) DEFAULT '',
  `url` TEXT DEFAULT '',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO `songs` (`title`, `artist`, `mood`, `playlist`, `url`) VALUES
('Sunny Day', 'Example Artist', 'Happy', 'Morning Vibes', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3'),
('Soft Rain', 'Relax Band', 'Calm', 'Chill', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3'),
('Energy Boost', 'DJ Example', 'Energetic', 'Workout', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3'),
('Blue Evening', 'Singer Sample', 'Sad', 'Evening', 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-4.mp3');

-- Users table for site users
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(80) NOT NULL UNIQUE,
  `email` VARCHAR(255) DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Note: No sample users are inserted. Register via the site or add a user manually.
