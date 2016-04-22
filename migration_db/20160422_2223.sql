ALTER TABLE `company_profiles` ADD `header_image` VARCHAR(100) NOT NULL AFTER `logo`, ADD `join_reason` TEXT NOT NULL AFTER `header_image`;
ALTER TABLE `opportunities` ADD `gender` VARCHAR(10) NOT NULL AFTER `experience_years`, ADD `age_min` INT NOT NULL AFTER `gender`, ADD `age_max` INT NOT NULL AFTER `age_min`;
