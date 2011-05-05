
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- rejection_type
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `rejection_type`;


CREATE TABLE `rejection_type`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`basename` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- rejection_type_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `rejection_type_i18n`;


CREATE TABLE `rejection_type_i18n`
(
	`id` INTEGER  NOT NULL,
	`name` VARCHAR(255)  NOT NULL,
	`description` TEXT  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `rejection_type_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `rejection_type` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- residence_level
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `residence_level`;


CREATE TABLE `residence_level`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`levelname` VARCHAR(255)  NOT NULL,
	`listorder` INTEGER(2),
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- residence_level_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `residence_level_i18n`;


CREATE TABLE `residence_level_i18n`
(
	`name` VARCHAR(255)  NOT NULL,
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `residence_level_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `residence_level` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- residence
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `residence`;


CREATE TABLE `residence`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255)  NOT NULL,
	`level` INTEGER  NOT NULL,
	`parent` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `residence_FI_1` (`level`),
	CONSTRAINT `residence_FK_1`
		FOREIGN KEY (`level`)
		REFERENCES `residence_level` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- user_interest
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `user_interest`;


CREATE TABLE `user_interest`
(
	`user_id` INTEGER  NOT NULL,
	`subreaktor_id` INTEGER  NOT NULL,
	PRIMARY KEY (`user_id`,`subreaktor_id`),
	CONSTRAINT `user_interest_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE,
	INDEX `user_interest_FI_2` (`subreaktor_id`),
	CONSTRAINT `user_interest_FK_2`
		FOREIGN KEY (`subreaktor_id`)
		REFERENCES `subreaktor` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- article
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `article`;


CREATE TABLE `article`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`author_id` INTEGER  NOT NULL,
	`base_title` VARCHAR(255)  NOT NULL,
	`permalink` VARCHAR(255)  NOT NULL,
	`ingress` TEXT,
	`content` TEXT  NOT NULL,
	`updated_at` DATETIME,
	`updated_by` INTEGER default 0 NOT NULL,
	`article_type` INTEGER  NOT NULL,
	`article_order` INTEGER  NOT NULL,
	`expires_at` DATETIME,
	`status` INTEGER  NOT NULL,
	`published_at` DATETIME,
	`banner_file_id` INTEGER default 0,
	`is_sticky` INTEGER default 0,
	`frontpage` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `article_FI_1` (`author_id`),
	CONSTRAINT `article_FK_1`
		FOREIGN KEY (`author_id`)
		REFERENCES `sf_guard_user` (`id`),
	INDEX `article_FI_2` (`banner_file_id`),
	CONSTRAINT `article_FK_2`
		FOREIGN KEY (`banner_file_id`)
		REFERENCES `article_file` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- article_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `article_i18n`;


CREATE TABLE `article_i18n`
(
	`title` VARCHAR(255)  NOT NULL,
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `article_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `article` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- article_article_relation
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `article_article_relation`;


CREATE TABLE `article_article_relation`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`first_article` INTEGER  NOT NULL,
	`second_article` INTEGER  NOT NULL,
	`created_by` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `article_article_relation_FI_1` (`first_article`),
	CONSTRAINT `article_article_relation_FK_1`
		FOREIGN KEY (`first_article`)
		REFERENCES `article` (`id`),
	INDEX `article_article_relation_FI_2` (`second_article`),
	CONSTRAINT `article_article_relation_FK_2`
		FOREIGN KEY (`second_article`)
		REFERENCES `article` (`id`),
	INDEX `article_article_relation_FI_3` (`created_by`),
	CONSTRAINT `article_article_relation_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- article_artwork_relation
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `article_artwork_relation`;


CREATE TABLE `article_artwork_relation`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`article_id` INTEGER  NOT NULL,
	`artwork_id` INTEGER  NOT NULL,
	`created_by` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `article_artwork_relation_FI_1` (`article_id`),
	CONSTRAINT `article_artwork_relation_FK_1`
		FOREIGN KEY (`article_id`)
		REFERENCES `article` (`id`),
	INDEX `article_artwork_relation_FI_2` (`artwork_id`),
	CONSTRAINT `article_artwork_relation_FK_2`
		FOREIGN KEY (`artwork_id`)
		REFERENCES `reaktor_artwork` (`id`),
	INDEX `article_artwork_relation_FI_3` (`created_by`),
	CONSTRAINT `article_artwork_relation_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- article_file
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `article_file`;


CREATE TABLE `article_file`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`filename` VARCHAR(255)  NOT NULL,
	`path` VARCHAR(255)  NOT NULL,
	`uploaded_by` INTEGER  NOT NULL,
	`uploaded_at` DATETIME  NOT NULL,
	`description` VARCHAR(255),
	`file_mimetype_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `article_file_FI_1` (`uploaded_by`),
	CONSTRAINT `article_file_FK_1`
		FOREIGN KEY (`uploaded_by`)
		REFERENCES `sf_guard_user` (`id`),
	INDEX `article_file_FI_2` (`file_mimetype_id`),
	CONSTRAINT `article_file_FK_2`
		FOREIGN KEY (`file_mimetype_id`)
		REFERENCES `file_mimetype` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- article_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `article_category`;


CREATE TABLE `article_category`
(
	`article_id` INTEGER  NOT NULL,
	`category_id` INTEGER  NOT NULL,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	INDEX `article_category_FI_1` (`article_id`),
	CONSTRAINT `article_category_FK_1`
		FOREIGN KEY (`article_id`)
		REFERENCES `article` (`id`),
	INDEX `article_category_FI_2` (`category_id`),
	CONSTRAINT `article_category_FK_2`
		FOREIGN KEY (`category_id`)
		REFERENCES `category` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- article_subreaktor
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `article_subreaktor`;


CREATE TABLE `article_subreaktor`
(
	`article_id` INTEGER  NOT NULL,
	`subreaktor_id` INTEGER  NOT NULL,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	INDEX `article_subreaktor_FI_1` (`article_id`),
	CONSTRAINT `article_subreaktor_FK_1`
		FOREIGN KEY (`article_id`)
		REFERENCES `article` (`id`),
	INDEX `article_subreaktor_FI_2` (`subreaktor_id`),
	CONSTRAINT `article_subreaktor_FK_2`
		FOREIGN KEY (`subreaktor_id`)
		REFERENCES `subreaktor` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- article_attachment
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `article_attachment`;


CREATE TABLE `article_attachment`
(
	`article_id` INTEGER  NOT NULL,
	`file_id` INTEGER  NOT NULL,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	INDEX `article_attachment_FI_1` (`article_id`),
	CONSTRAINT `article_attachment_FK_1`
		FOREIGN KEY (`article_id`)
		REFERENCES `article` (`id`),
	INDEX `article_attachment_FI_2` (`file_id`),
	CONSTRAINT `article_attachment_FK_2`
		FOREIGN KEY (`file_id`)
		REFERENCES `article_file` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- file_metadata
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `file_metadata`;


CREATE TABLE `file_metadata`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`file` INTEGER  NOT NULL,
	`meta_element` VARCHAR(100)  NOT NULL,
	`meta_qualifier` VARCHAR(100)  NOT NULL,
	`meta_value` TEXT  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `file_metadata_FI_1` (`file`),
	CONSTRAINT `file_metadata_FK_1`
		FOREIGN KEY (`file`)
		REFERENCES `reaktor_file` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- reaktor_file
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `reaktor_file`;


CREATE TABLE `reaktor_file`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`filename` VARCHAR(200)  NOT NULL,
	`user_id` INTEGER  NOT NULL,
	`realpath` VARCHAR(300)  NOT NULL,
	`thumbpath` VARCHAR(300)  NOT NULL,
	`originalpath` VARCHAR(300)  NOT NULL,
	`original_mimetype_id` INTEGER  NOT NULL,
	`converted_mimetype_id` INTEGER  NOT NULL,
	`thumbnail_mimetype_id` INTEGER  NOT NULL,
	`uploaded_at` DATETIME  NOT NULL,
	`modified_at` DATETIME  NOT NULL,
	`reported_at` DATETIME,
	`reported` INTEGER(8) default 0 NOT NULL,
	`total_reported_ever` INTEGER(8) default 0 NOT NULL,
	`marked_unsuitable` INTEGER(1) default 0 NOT NULL,
	`under_discussion` INTEGER(1) default 0 NOT NULL,
	`identifier` VARCHAR(20)  NOT NULL,
	`hidden` INTEGER(1) default 0 NOT NULL,
	`deleted` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `reaktor_file_FI_1` (`user_id`),
	CONSTRAINT `reaktor_file_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- user_resource
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `user_resource`;


CREATE TABLE `user_resource`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`url` VARCHAR(255)  NOT NULL,
	PRIMARY KEY (`id`,`user_id`),
	INDEX `user_resource_FI_1` (`user_id`),
	CONSTRAINT `user_resource_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- artwork_status
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `artwork_status`;


CREATE TABLE `artwork_status`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(30)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- artwork_status_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `artwork_status_i18n`;


CREATE TABLE `artwork_status_i18n`
(
	`id` INTEGER  NOT NULL,
	`description` VARCHAR(30)  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `artwork_status_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `artwork_status` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- reaktor_artwork_file
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `reaktor_artwork_file`;


CREATE TABLE `reaktor_artwork_file`
(
	`artwork_id` INTEGER  NOT NULL,
	`file_id` INTEGER  NOT NULL,
	`file_order` INTEGER default 1,
	PRIMARY KEY (`artwork_id`,`file_id`),
	CONSTRAINT `reaktor_artwork_file_FK_1`
		FOREIGN KEY (`artwork_id`)
		REFERENCES `reaktor_artwork` (`id`),
	INDEX `reaktor_artwork_file_FI_2` (`file_id`),
	CONSTRAINT `reaktor_artwork_file_FK_2`
		FOREIGN KEY (`file_id`)
		REFERENCES `reaktor_file` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- recommended_artwork
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `recommended_artwork`;


CREATE TABLE `recommended_artwork`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`artwork` INTEGER  NOT NULL,
	`subreaktor` INTEGER  NOT NULL,
	`localsubreaktor` INTEGER,
	`updated_by` INTEGER  NOT NULL,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `recommended_artwork_FI_1` (`artwork`),
	CONSTRAINT `recommended_artwork_FK_1`
		FOREIGN KEY (`artwork`)
		REFERENCES `reaktor_artwork` (`id`),
	INDEX `recommended_artwork_FI_2` (`subreaktor`),
	CONSTRAINT `recommended_artwork_FK_2`
		FOREIGN KEY (`subreaktor`)
		REFERENCES `subreaktor` (`id`),
	INDEX `recommended_artwork_FI_3` (`localsubreaktor`),
	CONSTRAINT `recommended_artwork_FK_3`
		FOREIGN KEY (`localsubreaktor`)
		REFERENCES `subreaktor` (`id`),
	INDEX `recommended_artwork_FI_4` (`updated_by`),
	CONSTRAINT `recommended_artwork_FK_4`
		FOREIGN KEY (`updated_by`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- messages
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `messages`;


CREATE TABLE `messages`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`to_user_id` INTEGER  NOT NULL,
	`from_user_id` INTEGER  NOT NULL,
	`subject` VARCHAR(255),
	`message` TEXT,
	`timestamp` DATETIME  NOT NULL,
	`deleted_by_from` INTEGER default 0 NOT NULL,
	`deleted_by_to` INTEGER default 0 NOT NULL,
	`is_read` INTEGER default 0 NOT NULL,
	`is_ignored` INTEGER default 0 NOT NULL,
	`is_archived` INTEGER default 0 NOT NULL,
	`reply_to` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `messages_FI_1` (`to_user_id`),
	CONSTRAINT `messages_FK_1`
		FOREIGN KEY (`to_user_id`)
		REFERENCES `sf_guard_user` (`id`),
	INDEX `messages_FI_2` (`from_user_id`),
	CONSTRAINT `messages_FK_2`
		FOREIGN KEY (`from_user_id`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- messages_ignored_user
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `messages_ignored_user`;


CREATE TABLE `messages_ignored_user`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`ignores_user_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `messages_ignored_user_FI_1` (`user_id`),
	CONSTRAINT `messages_ignored_user_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`),
	INDEX `messages_ignored_user_FI_2` (`ignores_user_id`),
	CONSTRAINT `messages_ignored_user_FK_2`
		FOREIGN KEY (`ignores_user_id`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- admin_message
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `admin_message`;


CREATE TABLE `admin_message`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`subject` VARCHAR(255),
	`message` TEXT  NOT NULL,
	`author` INTEGER  NOT NULL,
	`updated_at` DATETIME,
	`expires_at` DATETIME  NOT NULL,
	`is_deleted` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `admin_message_FI_1` (`author`),
	CONSTRAINT `admin_message_FK_1`
		FOREIGN KEY (`author`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- reaktor_artwork_history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `reaktor_artwork_history`;


CREATE TABLE `reaktor_artwork_history`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`artwork_id` INTEGER,
	`file_id` INTEGER,
	`created_at` DATETIME,
	`modified_flag` DATETIME,
	`user_id` INTEGER  NOT NULL,
	`status` INTEGER  NOT NULL,
	`comment` TEXT,
	PRIMARY KEY (`id`),
	INDEX `reaktor_artwork_history_FI_1` (`artwork_id`),
	CONSTRAINT `reaktor_artwork_history_FK_1`
		FOREIGN KEY (`artwork_id`)
		REFERENCES `reaktor_artwork` (`id`),
	INDEX `reaktor_artwork_history_FI_2` (`file_id`),
	CONSTRAINT `reaktor_artwork_history_FK_2`
		FOREIGN KEY (`file_id`)
		REFERENCES `reaktor_artwork` (`id`),
	INDEX `reaktor_artwork_history_FI_3` (`user_id`),
	CONSTRAINT `reaktor_artwork_history_FK_3`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`),
	INDEX `reaktor_artwork_history_FI_4` (`status`),
	CONSTRAINT `reaktor_artwork_history_FK_4`
		FOREIGN KEY (`status`)
		REFERENCES `artwork_status` (`id`)
		ON DELETE RESTRICT
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- related_artwork
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `related_artwork`;


CREATE TABLE `related_artwork`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`first_artwork` INTEGER  NOT NULL,
	`second_artwork` INTEGER  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	`created_by` INTEGER  NOT NULL,
	`order_by` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `related_artwork_FI_1` (`first_artwork`),
	CONSTRAINT `related_artwork_FK_1`
		FOREIGN KEY (`first_artwork`)
		REFERENCES `reaktor_artwork` (`id`),
	INDEX `related_artwork_FI_2` (`second_artwork`),
	CONSTRAINT `related_artwork_FK_2`
		FOREIGN KEY (`second_artwork`)
		REFERENCES `reaktor_artwork` (`id`),
	INDEX `related_artwork_FI_3` (`created_by`),
	CONSTRAINT `related_artwork_FK_3`
		FOREIGN KEY (`created_by`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- subreaktor
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subreaktor`;


CREATE TABLE `subreaktor`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`reference` VARCHAR(15)  NOT NULL,
	`lokalreaktor` INTEGER default 0 NOT NULL,
	`live` INTEGER default 0 NOT NULL,
	`subreaktor_order` INTEGER default 0,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- subreaktor_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subreaktor_i18n`;


CREATE TABLE `subreaktor_i18n`
(
	`name` VARCHAR(255)  NOT NULL,
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `subreaktor_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `subreaktor` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- lokalreaktor_artwork
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `lokalreaktor_artwork`;


CREATE TABLE `lokalreaktor_artwork`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`subreaktor_id` INTEGER  NOT NULL,
	`artwork_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `lokalreaktor_artwork_FI_1` (`subreaktor_id`),
	CONSTRAINT `lokalreaktor_artwork_FK_1`
		FOREIGN KEY (`subreaktor_id`)
		REFERENCES `subreaktor` (`id`),
	INDEX `lokalreaktor_artwork_FI_2` (`artwork_id`),
	CONSTRAINT `lokalreaktor_artwork_FK_2`
		FOREIGN KEY (`artwork_id`)
		REFERENCES `reaktor_artwork` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- lokalreaktor_residence
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `lokalreaktor_residence`;


CREATE TABLE `lokalreaktor_residence`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`subreaktor_id` INTEGER  NOT NULL,
	`residence_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `lokalreaktor_residence_FI_1` (`subreaktor_id`),
	CONSTRAINT `lokalreaktor_residence_FK_1`
		FOREIGN KEY (`subreaktor_id`)
		REFERENCES `subreaktor` (`id`),
	INDEX `lokalreaktor_residence_FI_2` (`residence_id`),
	CONSTRAINT `lokalreaktor_residence_FK_2`
		FOREIGN KEY (`residence_id`)
		REFERENCES `residence` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- subreaktor_identifier
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subreaktor_identifier`;


CREATE TABLE `subreaktor_identifier`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`subreaktor_id` INTEGER  NOT NULL,
	`identifier` VARCHAR(20)  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `subreaktor_identifier_FI_1` (`subreaktor_id`),
	CONSTRAINT `subreaktor_identifier_FK_1`
		FOREIGN KEY (`subreaktor_id`)
		REFERENCES `subreaktor` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- file_mimetype
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `file_mimetype`;


CREATE TABLE `file_mimetype`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`mimetype` VARCHAR(100)  NOT NULL,
	`identifier` VARCHAR(20)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- favourite
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `favourite`;


CREATE TABLE `favourite`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`artwork_id` INTEGER  NOT NULL,
	`article_id` INTEGER  NOT NULL,
	`friend_id` INTEGER  NOT NULL,
	`fav_type` VARCHAR(8)  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `favourite_FI_1` (`user_id`),
	CONSTRAINT `favourite_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`),
	INDEX `favourite_FI_2` (`artwork_id`),
	CONSTRAINT `favourite_FK_2`
		FOREIGN KEY (`artwork_id`)
		REFERENCES `reaktor_artwork` (`id`),
	INDEX `favourite_FI_3` (`article_id`),
	CONSTRAINT `favourite_FK_3`
		FOREIGN KEY (`article_id`)
		REFERENCES `article` (`id`),
	INDEX `favourite_FI_4` (`friend_id`),
	CONSTRAINT `favourite_FK_4`
		FOREIGN KEY (`friend_id`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- history
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `history`;


CREATE TABLE `history`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`action_id` INTEGER  NOT NULL,
	`user_id` INTEGER  NOT NULL,
	`object_id` INTEGER,
	`extra_details` TEXT,
	PRIMARY KEY (`id`),
	INDEX `history_FI_1` (`action_id`),
	CONSTRAINT `history_FK_1`
		FOREIGN KEY (`action_id`)
		REFERENCES `history_action` (`id`),
	INDEX `history_FI_2` (`user_id`),
	CONSTRAINT `history_FK_2`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- history_action
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `history_action`;


CREATE TABLE `history_action`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50),
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- history_action_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `history_action_i18n`;


CREATE TABLE `history_action_i18n`
(
	`description` TEXT  NOT NULL,
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `history_action_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `history_action` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- catalogue
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `catalogue`;


CREATE TABLE `catalogue`
(
	`cat_id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) default '' NOT NULL,
	`source_lang` VARCHAR(100) default '' NOT NULL,
	`target_lang` VARCHAR(100) default '' NOT NULL,
	`date_created` INTEGER(11) default 0 NOT NULL,
	`date_modified` INTEGER(11) default 0 NOT NULL,
	`author` VARCHAR(255) default '' NOT NULL,
	`description` VARCHAR(255) default '' NOT NULL,
	PRIMARY KEY (`cat_id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- trans_unit
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `trans_unit`;


CREATE TABLE `trans_unit`
(
	`msg_id` INTEGER(11)  NOT NULL AUTO_INCREMENT,
	`cat_id` INTEGER(11) default 1 NOT NULL,
	`id` VARCHAR(255) default '',
	`source` TEXT  NOT NULL,
	`target` TEXT  NOT NULL,
	`module` VARCHAR(255) default '',
	`filename` VARCHAR(255) default '',
	`comments` TEXT,
	`date_added` INTEGER(11) default 0 NOT NULL,
	`date_modified` INTEGER(11) default 0 NOT NULL,
	`author` VARCHAR(255) default '' NOT NULL,
	`translated` INTEGER(1) default 0 NOT NULL,
	PRIMARY KEY (`msg_id`),
	INDEX `trans_unit_FI_1` (`cat_id`),
	CONSTRAINT `trans_unit_FK_1`
		FOREIGN KEY (`cat_id`)
		REFERENCES `catalogue` (`cat_id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `category`;


CREATE TABLE `category`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`basename` VARCHAR(75)  NOT NULL,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- category_i18n
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `category_i18n`;


CREATE TABLE `category_i18n`
(
	`name` VARCHAR(75)  NOT NULL,
	`id` INTEGER  NOT NULL,
	`culture` VARCHAR(7)  NOT NULL,
	PRIMARY KEY (`id`,`culture`),
	CONSTRAINT `category_i18n_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `category` (`id`)
		ON DELETE CASCADE
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- category_artwork
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `category_artwork`;


CREATE TABLE `category_artwork`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`category_id` INTEGER,
	`artwork_id` INTEGER,
	`added_by` INTEGER,
	`created_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `category_artwork_FI_1` (`category_id`),
	CONSTRAINT `category_artwork_FK_1`
		FOREIGN KEY (`category_id`)
		REFERENCES `category` (`id`),
	INDEX `category_artwork_FI_2` (`artwork_id`),
	CONSTRAINT `category_artwork_FK_2`
		FOREIGN KEY (`artwork_id`)
		REFERENCES `reaktor_artwork` (`id`),
	INDEX `category_artwork_FI_3` (`added_by`),
	CONSTRAINT `category_artwork_FK_3`
		FOREIGN KEY (`added_by`)
		REFERENCES `sf_guard_user` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- category_subreaktor
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `category_subreaktor`;


CREATE TABLE `category_subreaktor`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`category_id` INTEGER,
	`subreaktor_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `category_subreaktor_FI_1` (`category_id`),
	CONSTRAINT `category_subreaktor_FK_1`
		FOREIGN KEY (`category_id`)
		REFERENCES `category` (`id`),
	INDEX `category_subreaktor_FI_2` (`subreaktor_id`),
	CONSTRAINT `category_subreaktor_FK_2`
		FOREIGN KEY (`subreaktor_id`)
		REFERENCES `subreaktor` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- report_bookmark
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `report_bookmark`;


CREATE TABLE `report_bookmark`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255)  NOT NULL,
	`description` TEXT  NOT NULL,
	`args` TEXT  NOT NULL,
	`type` VARCHAR(10) default 'artwork' NOT NULL,
	`list_order` INTEGER default 0,
	PRIMARY KEY (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- reaktor_artwork
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `reaktor_artwork`;


CREATE TABLE `reaktor_artwork`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER  NOT NULL,
	`artwork_identifier` VARCHAR(20)  NOT NULL,
	`created_at` DATETIME  NOT NULL,
	`submitted_at` DATETIME,
	`actioned_at` DATETIME,
	`modified_flag` DATETIME,
	`title` VARCHAR(255)  NOT NULL,
	`actioned_by` INTEGER  NOT NULL,
	`status` INTEGER  NOT NULL,
	`description` TEXT,
	`modified_note` TEXT,
	`artwork_order` INTEGER default 0,
	`average_rating` FLOAT default 0,
	`team_id` INTEGER  NOT NULL,
	`under_discussion` INTEGER(1) default 0 NOT NULL,
	`multi_user` INTEGER(1) default 0 NOT NULL,
	`first_file_id` INTEGER,
	`deleted` INTEGER default 0,
	PRIMARY KEY (`id`),
	INDEX `reaktor_artwork_FI_1` (`user_id`),
	CONSTRAINT `reaktor_artwork_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `sf_guard_user` (`id`),
	INDEX `reaktor_artwork_FI_2` (`status`),
	CONSTRAINT `reaktor_artwork_FK_2`
		FOREIGN KEY (`status`)
		REFERENCES `artwork_status` (`id`)
		ON DELETE RESTRICT,
	INDEX `reaktor_artwork_FI_3` (`team_id`),
	CONSTRAINT `reaktor_artwork_FK_3`
		FOREIGN KEY (`team_id`)
		REFERENCES `sf_guard_group` (`id`),
	INDEX `reaktor_artwork_FI_4` (`first_file_id`),
	CONSTRAINT `reaktor_artwork_FK_4`
		FOREIGN KEY (`first_file_id`)
		REFERENCES `reaktor_file` (`id`)
)Type=MyISAM;

#-----------------------------------------------------------------------------
#-- subreaktor_artwork
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `subreaktor_artwork`;


CREATE TABLE `subreaktor_artwork`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`subreaktor_id` INTEGER  NOT NULL,
	`artwork_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `subreaktor_artwork_FI_1` (`subreaktor_id`),
	CONSTRAINT `subreaktor_artwork_FK_1`
		FOREIGN KEY (`subreaktor_id`)
		REFERENCES `subreaktor` (`id`),
	INDEX `subreaktor_artwork_FI_2` (`artwork_id`),
	CONSTRAINT `subreaktor_artwork_FK_2`
		FOREIGN KEY (`artwork_id`)
		REFERENCES `reaktor_artwork` (`id`)
)Type=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
