
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- tag
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tag`;


CREATE TABLE `tag`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100),
	`approved` TINYINT default 0 NOT NULL,
	`approved_by` INTEGER,
	`approved_at` DATETIME,
	`width` INTEGER,
	PRIMARY KEY (`id`),
	KEY `name`(`name`),
	INDEX `tag_FI_1` (`approved_by`),
	CONSTRAINT `tag_FK_1`
		FOREIGN KEY (`approved_by`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- tagging
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `tagging`;


CREATE TABLE `tagging`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`tag_id` INTEGER  NOT NULL,
	`taggable_model` VARCHAR(30),
	`taggable_id` INTEGER,
	`parent_approved` TINYINT default 0 NOT NULL,
	`parent_user_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	KEY `tag`(`tag_id`),
	KEY `taggable`(`taggable_model`, `taggable_id`),
	CONSTRAINT `tagging_FK_1`
		FOREIGN KEY (`tag_id`)
		REFERENCES `tag` (`id`),
	INDEX `tagging_FI_2` (`parent_user_id`),
	CONSTRAINT `tagging_FK_2`
		FOREIGN KEY (`parent_user_id`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
