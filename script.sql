ALTER TABLE `table1` ADD `vote` INT NULL DEFAULT '0' COMMENT 'ranking Links' AFTER `description`, ADD `time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Added on' AFTER `vote`;

