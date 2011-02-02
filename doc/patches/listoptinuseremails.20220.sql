# Add permision listoptinuseremails - Ticket 20220
INSERT INTO `reaktor`.`sf_guard_permission` (`id`, `name`) VALUES ('58', 'listoptinuseremails');
insert into sf_guard_group_permission(`group_id`,`permission_id`) values('3','58');
insert into `reaktor`.`sf_guard_permission_i18n` values('Can list opt-in user e-mails','58', 'en' );