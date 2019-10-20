ALTER TABLE `{$prefix}user` CHANGE `user_role` `user_role` ENUM('admin','user','translator') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user';
