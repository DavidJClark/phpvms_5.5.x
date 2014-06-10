-- It's sometimes missing;
INSERT INTO `phpvms_settings` VALUES(NULL , 'Total VA Hours', 'TOTAL_HOURS', '0', 'Your total hours', 0);
INSERT INTO `phpvms_settings` VALUES(NULL , 'phpVMS Version', 'PHPVMS_VERSION', '0', 'phpVMS Version', 1);


INSERT INTO `phpvms_groups` (`name`, `permissions`, `core`) VALUES ('Active Pilots', '0', 1);
INSERT INTO `phpvms_groups` (`name`, `permissions`, `core`) VALUES ('Inactive Pilots', '0', 1);

UPDATE `phpvms_groups` SET `core`=0;
UPDATE `phpvms_groups` SET `core`=1 WHERE `name` = 'Administrators';
UPDATE `phpvms_groups` SET `core`=1 WHERE `name` = 'Active Pilots';
UPDATE `phpvms_groups` SET `core`=1 WHERE `name` = 'Inactive Pilots';

-- Remove deprecated settings;
DELETE FROM `phpvms_settings` WHERE `name`='NOTIFY_UPDATE';
DELETE FROM `phpvms_settings` WHERE `name`='GOOGLE_KEY';