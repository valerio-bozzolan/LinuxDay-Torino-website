ALTER TABLE `{$prefix}event` ADD `event_abstract_pms`    TEXT NULL AFTER `event_abstract_en`;
ALTER TABLE `{$prefix}event` ADD `event_description_pms` TEXT NULL AFTER `event_description_en`;
ALTER TABLE `{$prefix}event` ADD `event_note_pms`        TEXT NULL AFTER `event_note_en`;
ALTER TABLE `{$prefix}user`  ADD `user_bio_pms`          TEXT NULL AFTER `user_bio_en`;
