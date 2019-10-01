ALTER TABLE `{$prefix}event` CHANGE `event_description` `event_description_it` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `{$prefix}event` ADD `event_description_en` TEXT NULL AFTER `event_description_it`;
ALTER TABLE `{$prefix}event` CHANGE `event_abstract` `event_abstract_it` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `{$prefix}event` ADD `event_abstract_en` TEXT NULL AFTER `event_abstract_it`;
ALTER TABLE `{$prefix}event` CHANGE `event_note` `event_note_it` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `{$prefix}event` ADD `event_note_en` TEXT NULL AFTER `event_note_it`; 
