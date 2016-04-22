ALTER TABLE `tokens` ADD `id_key` INT NOT NULL AFTER `token`;
ALTER TABLE `tokens` ADD UNIQUE( `id_key`, `ip`);
ALTER TABLE tokens DROP INDEX ip;
