INSERT INTO `cyclox2`.`category_groups` (`id`, `name`, `description`, `lank_up_hint`) VALUES (1, 'Elite', 'C1, C2,,,', '');
INSERT INTO `cyclox2`.`category_groups` (`id`, `name`, `description`, `lank_up_hint`) VALUES (2, 'Woman', 'CL1, CL2,,,', '');
INSERT INTO `cyclox2`.`category_groups` (`id`, `name`, `description`, `lank_up_hint`) VALUES (3, 'Masters', 'CM1, CM2,,,', '');

INSERT INTO `cyclox2`.`categories` 
(`age_min`, `age_max`, `code`, `name`, `short_name`, `category_group_id`, `lank`, `race_min`, `gender`, `description`, `needs_jcf`, `needs_uci`, `uci_age_limit`) 
VALUES (20, NULL, 'C1', 'Category-1', 'C1', 1, 1, 60, 0, '', '1', '0', '');

INSERT INTO `cyclox2`.`categories` 
(`age_min`, `age_max`, `code`, `name`, `short_name`, `category_group_id`, `lank`, `race_min`, `gender`, `description`, `needs_jcf`, `needs_uci`, `uci_age_limit`) 
VALUES (18, NULL, 'C2', 'Category-2', 'C2', 1, 2, 40, 0, '', '1', '0', '');

INSERT INTO `cyclox2`.`categories` 
(`age_min`, `age_max`, `code`, `name`, `short_name`, `category_group_id`, `lank`, `race_min`, `gender`, `description`, `needs_jcf`, `needs_uci`, `uci_age_limit`) 
VALUES (18, NULL, 'C3', 'Category-3', 'C3', 1, 3, 30, 0, '', '0', '0', '');

INSERT INTO `cyclox2`.`categories` 
(`age_min`, `age_max`, `code`, `name`, `short_name`, `category_group_id`, `lank`, `race_min`, `gender`, `description`, `needs_jcf`, `needs_uci`, `uci_age_limit`) 
VALUES (18, NULL, 'C4', 'Category-4', 'C4', 1, 4, 30, 0, '', '0', '0', '');

INSERT INTO `cyclox2`.`categories` 
(`age_min`, `age_max`, `code`, `name`, `short_name`, `category_group_id`, `lank`, `race_min`, `gender`, `description`, `needs_jcf`, `needs_uci`, `uci_age_limit`) 
VALUES (NULL, NULL, 'CL1', 'Category Leadies-1', 'CL1', 2, 1, 40, 1, '', '1', '0', '');

INSERT INTO `cyclox2`.`categories` 
(`age_min`, `age_max`, `code`, `name`, `short_name`, `category_group_id`, `lank`, `race_min`, `gender`, `description`, `needs_jcf`, `needs_uci`, `uci_age_limit`) 
VALUES (NULL, NULL, 'CL2', 'Category Leadies-2', 'CL2', 2, 2, 30, 1, '', '0', '0', '');

INSERT INTO `cyclox2`.`categories` 
(`age_min`, `age_max`, `code`, `name`, `short_name`, `category_group_id`, `lank`, `race_min`, `gender`, `description`, `needs_jcf`, `needs_uci`, `uci_age_limit`) 
VALUES (NULL, NULL, 'CL3', 'Category Leadies-3', 'CL3', 3, 3, 30, 1, '', '0', '0', '');

INSERT INTO `cyclox2`.`categories` 
(`age_min`, `age_max`, `code`, `name`, `short_name`, `category_group_id`, `lank`, `race_min`, `gender`, `description`, `needs_jcf`, `needs_uci`, `uci_age_limit`) 
VALUES (NULL, NULL, 'CM1', 'Category Masters-1', 'CM1', 3, 1, 40, 0, '', '1', '0', '');

INSERT INTO `cyclox2`.`categories` 
(`age_min`, `age_max`, `code`, `name`, `short_name`, `category_group_id`, `lank`, `race_min`, `gender`, `description`, `needs_jcf`, `needs_uci`, `uci_age_limit`) 
VALUES (NULL, NULL, 'CM2', 'Category Masters-2', 'CM2', 3, 2, 30, 0, '', '1', '0', '');

INSERT INTO `cyclox2`.`categories` 
(`age_min`, `age_max`, `code`, `name`, `short_name`, `category_group_id`, `lank`, `race_min`, `gender`, `description`, `needs_jcf`, `needs_uci`, `uci_age_limit`) 
VALUES (NULL, NULL, 'CM3', 'Category Masters-3', 'CM3', 3, 3, 20, 0, '', '1', '0', '');

INSERT INTO `cyclox2`.`categories` 
(`age_min`, `age_max`, `code`, `name`, `short_name`, `category_group_id`, `lank`, `race_min`, `gender`, `description`, `needs_jcf`, `needs_uci`, `uci_age_limit`) 
VALUES (NULL, NULL, 'CM4', 'Category Masters-4', 'CM4', 3, 4, 20, 0, '', '1', '0', '');




INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'C1', 'C1', 'C1 のみ', -1, 0, 0, 60, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'C2', 'C2', 'C2 のみ', -1, 0, 0, 40, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'C3', 'C3', 'C3 のみ', -1, 0, 0, 30, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'C4', 'C4', 'C4 のみ', -1, 0, 0, 30, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'C3+4', 'C3+4', 'C3 と C4 の合同レース', -1, 0, 0, 30, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CL1', 'CL1', 'CL1 のみ', -1, 0, 0, 40, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CL2', 'CL2', 'CL2 のみ', -1, 0, 0, 30, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CL3', 'CL3', 'CL3 のみ', -1, 0, 0, 30, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CL2+3', 'CL2+3', 'CL2 と CL3 の合同レース', -1, 0, 0, 30, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CM1', 'CM1', 'CM1 のみ', -1, 0, 0, 40, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CM2', 'CM2', 'CM2 のみ', -1, 0, 0, 30, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CM3', 'CM3', 'CM3 のみ', -1, 0, 0, 30, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CM4', 'CM4', 'CM4 のみ', -1, 0, 0, 20, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CM1+2+3', 'CM1+2+3', 'CM1, CM2, CM3 の合同レース', -1, 0, 0, 40, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CM1+2+3+4', 'CM1+2+3+4', 'CM1,2,3,4 の合同レース', -1, 0, 0, 40, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CM2+3', 'CM2+3', 'CM2 と CM3 の合同レース', -1, 0, 0, 40, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CM3+4', 'CM3+4', 'CM3 と CM4 の合同レース', -1, 0, 0, 30, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');

INSERT INTO `cyclox2`.`races_categories` 
(`age_min`, `age_max`, `code`, `name`, `description`, `gender`, `needs_jcf`, `needs_uci`, `race_min`, `uci_age_limit`, `modified`, `created`) 
VALUES (NULL, NULL, 'CM2+3+4', 'CM2+3+4', 'CM2,3,4 の合同レース', -1, 0, 0, 40, '', '2015-06-18 22:46:35', '2015-06-18 22:46:35');




INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('C1', 'C1', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('C2', 'C2', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('C3', 'C3', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('C4', 'C4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('C3', 'C3+4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('C4', 'C3+4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');

INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CL1', 'CL1', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CL2', 'CL2', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CL3', 'CL3', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CL2', 'CL2+3', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CL3', 'CL2+3', '2015-06-18 23:21:37', '2015-06-18 23:21:37');

INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM1', 'CM1', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM2', 'CM2', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM3', 'CM3', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM4', 'CM4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM1', 'CM1+2+3', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM2', 'CM1+2+3', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM3', 'CM1+2+3', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM1', 'CM1+2+3+4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM2', 'CM1+2+3+4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM3', 'CM1+2+3+4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM4', 'CM1+2+3+4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM2', 'CM2+3', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM3', 'CM2+3', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM3', 'CM3+4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM4', 'CM3+4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM2', 'CM2+3+4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM3', 'CM2+3+4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');
INSERT INTO `cyclox2`.`category_races_categories` (`category_code`, `races_category_code`, `modified`, `created`) VALUES ('CM4', 'CM2+3+4', '2015-06-18 23:21:37', '2015-06-18 23:21:37');





INSERT INTO `cyclox2`.`seasons` 
(`id`, `name`, `short_name`, `start_date`, `end_date`, `is_regular`, `modified`, `created`) 
VALUES (1, '2010-11 レギュラーシーズン', '2010-11', '2010-09-01', '2011-03-31', '1', '2015-06-16 15:42:37', '2015-06-16 15:42:37');

INSERT INTO `cyclox2`.`seasons` 
(`id`, `name`, `short_name`, `start_date`, `end_date`, `is_regular`, `modified`, `created`) 
VALUES (2, '2011-12 レギュラーシーズン', '2011-12', '2011-09-01', '2012-03-31', '1', '2015-06-16 15:42:37', '2015-06-16 15:42:37');

INSERT INTO `cyclox2`.`seasons` 
(`id`, `name`, `short_name`, `start_date`, `end_date`, `is_regular`, `modified`, `created`) 
VALUES (3, '2012-13 レギュラーシーズン', '2012-13', '2012-09-01', '2013-03-31', '1', '2015-06-16 15:42:37', '2015-06-16 15:42:37');

INSERT INTO `cyclox2`.`seasons` 
(`id`, `name`, `short_name`, `start_date`, `end_date`, `is_regular`, `modified`, `created`) 
VALUES (4, '2013-14 レギュラーシーズン', '2013-14', '2013-09-01', '2014-03-31', '1', '2015-06-16 15:42:37', '2015-06-16 15:42:37');



INSERT INTO `cyclox2`.`meet_groups` (`code`, `name`, `short_name`, `description`, `homepage`, `modified`, `created`) 
VALUES ('YAM', '山の会', '山会', '', 'yama.co.org', '2015-06-16 16:07:07', '2015-06-16 16:07:07');

INSERT INTO `cyclox2`.`meet_groups` (`code`, `name`, `short_name`, `description`, `homepage`, `modified`, `created`) 
VALUES ('KAW', '川とトモニ', '川トモ', '淡水最高だよね。', 'kawa.co.org', '2015-06-16 16:07:07', '2015-06-16 16:07:07');

INSERT INTO `cyclox2`.`meet_groups` (`code`, `name`, `short_name`, `description`, `homepage`, `modified`, `created`) 
VALUES ('UMI', '海シクロ協会', '海X', '塩水に浸ろう', 'umi.co.org', '2015-06-16 16:07:07', '2015-06-16 16:07:07');

INSERT INTO `cyclox2`.`meet_groups` (`code`, `name`, `short_name`, `description`, `homepage`, `modified`, `created`) 
VALUES ('MCX', '町おこしシクロ隊', 'アーバン', '工場とか。公園とか。', 'toshi.co.org', '2015-06-16 16:07:07', '2015-06-16 16:07:07');


INSERT INTO `cyclox2`.`meets` 
(`meet_group_code`, `start_frac_distance`, `lap_distance`, `season_id`, `at_date`, `name`, `short_name`, `location`, `organized_by`, `homepage`, `code`, `modified`, `created`) 
VALUES ('YAM', NULL, NULL, 2, '2015-11-16', '山の会第1回大会', '山CX#1', '', '', '', 'YAM-123-002', '2015-06-16 16:51:00', '2015-06-16 16:51:00');




INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('JPN', 'JPN', 'XYZ-156-0001','白木','しらき','Shiraki','菜摘','なつみ','NATSUMI',1,'1999-07-25', '', '', '', '090-4182-3935', '', '', '新潟県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0002','菊地','きくち','Kikuchi','恵梨香','えりか','ERIKA',1,'1993-05-20', '', '', '', '090-8273-6879', '', '', '千葉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0003','風間','かざま','Kazama','一哉','かずや','KAZUYA',0,'2000-08-10', '', '', '', '080-9695-6339', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0004','菅井','すがい','Sugai','小雁','こがん','KOGAN',0,'1961-06-10', '', '', '', '080-1660-4898', '', '', '三重県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0005','松山','まつやま','Matsuyama','杏','あん','AN',0,'2000-08-10', '', '', '', '090-7175-1343', '', '', '兵庫県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0006','川原','かわはら','Kawahara','千佳子','ちかこ','CHIKAKO',1,'1965-02-15', '', '', '', '090-3108-7308', '', '', '富山県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0007','豊田','とよた','Toyota','美月','みづき','MIZUKI',0,'1995-04-30', '', '', '', '080-9178-9789', '', '', '静岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0008','風間','かざま','Kazama','サダヲ','さだお','SADAO',0,'1954-12-25', '', '', '', '090-2259-3189', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0009','清野','きよの','Kiyono','芽以','めい','MEI',0,'1999-11-30', '', '', '', '090-7783-5404', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0010','大津','おおつ','Otsu','満','みつる','MITSURU',0,'1997-01-25', '', '', '', '090-7231-5395', '', '', '静岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0011','宮城','みやぎ','Miyagi','真希','まき','MAKI',0,'1994-02-25', '', '', '', '080-7568-2886', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0012','井出','いで','Ide','栄一','えいいち','EIICHI',0,'1963-03-05', '', '', '', '080-8850-8091', '', '', '福岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0013','前川','まえかわ','Maekawa','米蔵','よねぞう','YONEZO',0,'2002-10-31', '', '', '', '080-7931-2389', '', '', '静岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0014','津田','つだ','Tsuda','禄郎','ろくろう','ROKURO',0,'1998-08-31', '', '', '', '080-2760-9514', '', '', '栃木県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0015','福地','ふくち','Fukuchi','充則','みつのり','MITSUNORI',0,'1957-12-20', '', '', '', '090-1252-8197', '', '', '群馬県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0016','若林','わかばやし','Wakabayashi','あい','あい','AI',1,'1993-08-31', '', '', '', '080-9311-6580', '', '', '佐賀県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0017','中村','なかむら','Nakamura','涼子','りょうこ','RYOKO',1,'1966-07-05', '', '', '', '090-8530-6749', '', '', '福岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0018','玉城','たまき','Tamaki','由宇','ゆう','YU',1,'1960-04-05', '', '', '', '090-2904-4635', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0019','相馬','あいば','Aiba','扶樹','もとき','MOTOKI',0,'1956-04-20', '', '', '', '090-4295-5321', '', '', '大阪府', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0020','赤木','あかぎ','Akagi','美佐子','みさこ','MISAKO',1,'1998-06-15', '', '', '', '080-7897-7049', '', '', '長野県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0021','田沢','たざわ','Tazawa','雅彦','まさひこ','MASAHIKO',0,'1996-09-20', '', '', '', '080-8718-8496', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0022','深沢','ふかざわ','Fukazawa','隼士','しゅんじ','SHUNJI',0,'2001-01-10', '', '', '', '080-8287-1002', '', '', '熊本県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0023','西川','にしかわ','Nishikawa','薫','かおる','KAORU',0,'1992-05-05', '', '', '', '090-5757- 720', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0024','矢沢','やざわ','Yazawa','翔','しょう','SHO',0,'1962-04-10', '', '', '', '090-2712-3940', '', '', '鳥取県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0025','原','はら','Hara','咲','さき','SAKI',0,'1960-03-10', '', '', '', '090- 684-2278', '', '', '青森県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0026','桜田','さくらだ','Sakurada','晋也','しんや','SHINYA',0,'1993-01-15', '', '', '', '080-6192-9355', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0027','伊丹','いたみ','Itami','はじめ','はじめ','HAJIME',0,'1992-02-20', '', '', '', '080-9984-5024', '', '', '大阪府', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0028','望月','もちづき','Mochizuki','徹平','てっぺい','TEPPEI',0,'1995-09-30', '', '', '', '080- 354-6073', '', '', '大阪府', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0029','山城','やましろ','Yamashiro','芳正','よしまさ','YOSHIMASA',0,'1992-03-15', '', '', '', '080-8161-7453', '', '', '静岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0030','須賀','すが','Suga','幸平','こうへい','KOHEI',0,'2002-02-20', '', '', '', '090-6193-5699', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0031','佐久間','さくま','Sakuma','幸子','さちこ','SACHIKO',1,'1995-12-15', '', '', '', '090-3640-4649', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0032','植松','うえまつ','Uematsu','六郎','ろくろう','ROKURO',0,'1993-02-10', '', '', '', '080-8058-2716', '', '', '群馬県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0033','奥山','おくやま','Okuyama','勇一','ゆういち','YUICHI',0,'1955-06-20', '', '', '', '080-4358-3291', '', '', '秋田県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0034','西尾','にしお','Nishio','みゆき','みゆき','MIYUKI',1,'1999-07-25', '', '', '', '090-6285-8575', '', '', '群馬県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0035','秋葉','あきば','Akiba','一樹','かずき','KAZUKI',0,'2001-10-15', '', '', '', '080-9864- 198', '', '', '大阪府', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0036','丹野','たんの','Tanno','俊二','しゅんじ','SHUNJI',0,'2001-05-15', '', '', '', '090-4378-8374', '', '', '北海道', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0037','関','せき','Seki','恵子','けいこ','KEIKO',1,'1960-10-25', '', '', '', '090-3132-2373', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0038','秋山','あきやま','Akiyama','友香','ともか','TOMOKA',1,'1956-05-15', '', '', '', '090-6978-8264', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0039','瀬川','せがわ','Segawa','夏希','なつき','NATSUKI',0,'1994-10-10', '', '', '', '090-1826-8795', '', '', '福島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0040','長澤','ながさわ','Nagasawa','美和子','みわこ','MIWAKO',1,'1958-08-31', '', '', '', '080-8047-5829', '', '', '静岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0041','日高','ひだか','Hidaka','祐一','ゆういち','YUICHI',0,'2001-04-20', '', '', '', '080-5525-8209', '', '', '沖縄県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0042','原口','はらぐち','Haraguchi','鉄二','てつじ','TETSUJI',0,'1999-12-25', '', '', '', '090-7071- 412', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0043','河野','こうの','Kono','光博','みつひろ','MITSUHIRO',0,'1999-04-15', '', '', '', '090-5249-1299', '', '', '静岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0044','谷本','たにもと','Tanimoto','勤','つとむ','TSUTOMU',0,'1965-10-25', '', '', '', '080-1006-7035', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0045','須田','すだ','Suda','景子','けいこ','KEIKO',1,'2002-02-20', '', '', '', '090-2443- 174', '', '', '長野県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0046','山瀬','やませ','Yamase','昌代','まさよ','MASAYO',1,'1992-01-25', '', '', '', '080-3866-6208', '', '', '広島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0047','曽根','そね','Sone','六郎','ろくろう','ROKURO',0,'1959-01-05', '', '', '', '080-1944-8120', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0048','吉本','よしもと','Yoshimoto','咲','さき','SAKI',0,'1957-03-15', '', '', '', '090-5800-3133', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0049','森脇','もりわき','Moriwaki','麻由子','まゆこ','MAYUKO',1,'1992-04-10', '', '', '', '090-3183-9919', '', '', '広島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0050','高松','たかまつ','Takamatsu','和香','わか','WAKA',1,'1999-08-20', '', '', '', '090-2394-7388', '', '', '広島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0051','竹田','たけだ','Takeda','遥','はるか','HARUKA',0,'1960-04-30', '', '', '', '090-4329-9289', '', '', '宮崎県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0052','中山','なかやま','Nakayama','妃里','ゆり','YURI',1,'1956-12-05', '', '', '', '080-9530-8050', '', '', '大阪府', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0053','大原','おおはら','Ohara','あさみ','あさみ','ASAMI',0,'1996-11-10', '', '', '', '080-8822-8629', '', '', '奈良県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0054','芦屋','あしや','Ashiya','一輝','かずき','KAZUKI',0,'1956-02-29', '', '', '', '090-2904-7117', '', '', '千葉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0055','水上','みずかみ','Mizukami','ノブヒコ','のぶひこ','NOBUHIKO',0,'2001-01-10', '', '', '', '090-4043-5350', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0056','吉永','よしなが','Yoshinaga','美幸','みゆき','MIYUKI',1,'1998-12-10', '', '', '', '080-6366-4928', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0057','宮坂','みやさか','Miyasaka','愛梨','あいり','AIRI',1,'1965-08-10', '', '', '', '090-9027-3682', '', '', '静岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0058','荒川','あらかわ','Arakawa','良介','りょうす','RYOSU',0,'1995-05-25', '', '', '', '080-3350-7098', '', '', '富山県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0059','岡本','おかもと','Okamoto','メイサ','めいさ','MEISA',1,'1998-01-15', '', '', '', '090-6249-5663', '', '', '奈良県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0060','小沢','おざわ','Ozawa','なつみ','なつみ','NATSUMI',1,'1954-06-30', '', '', '', '080-8265- 980', '', '', '長崎県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0061','小畑','おばた','Obata','幸子','さちこ','SACHIKO',1,'1960-05-25', '', '', '', '080- 749-6585', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0062','野際','のぎわ','Nogiwa','雅彦','まさひこ','MASAHIKO',0,'1962-01-25', '', '', '', '090-3853-7111', '', '', '青森県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0063','秋本','あきもと','Akimoto','一輝','かずき','KAZUKI',0,'2000-08-10', '', '', '', '090-5043-9780', '', '', '千葉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0064','日高','ひだか','Hidaka','菜々美','ななみ','NANAMI',1,'2002-11-25', '', '', '', '080-8953-4244', '', '', '兵庫県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0065','梅津','うめづ','Umezu','扶樹','もとき','MOTOKI',0,'1962-05-05', '', '', '', '080-7483-1413', '', '', '奈良県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0066','神田','かんだ','Kanda','春樹','はるき','HARUKI',0,'1963-03-31', '', '', '', '090-3260-5633', '', '', '千葉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0067','野崎','のざき','Nozaki','文世','ふみよ','FUMIYO',0,'1996-04-20', '', '', '', '080-4476-5694', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0068','真田','さなだ','Sanada','七世','ななせ','NANASE',0,'1995-04-05', '', '', '', '080-9506-5195', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0069','牧瀬','まきせ','Makise','大五郎','だいごろう','DAIGORO',0,'1957-07-20', '', '', '', '090-8268-4380', '', '', '広島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0070','高畑','たかはた','Takahata','ノブヒコ','のぶひこ','NOBUHIKO',0,'1997-10-05', '', '', '', '080-3792-9189', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0071','大塚','おおつか','Otsuka','一樹','かずき','KAZUKI',0,'1964-04-15', '', '', '', '080-4126-5946', '', '', '兵庫県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0072','三輪','みわ','Miwa','真奈美','まなみ','MANAMI',1,'1962-07-20', '', '', '', '090-4925-7182', '', '', '福井県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0073','有馬','ありま','Arima','理紗','りさ','RISA',1,'1992-05-05', '', '', '', '090-6452- 651', '', '', '北海道', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0074','三好','みよし','Miyoshi','奈央','なお','NAO',1,'1960-05-25', '', '', '', '080-8506-3616', '', '', '千葉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0075','飯田','いいだ','Iida','芽以','めい','MEI',1,'1996-11-10', '', '', '', '090-7907-8844', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0076','藤田','ふじた','Fujita','研二','けんじ','KENJI',0,'1960-04-05', '', '', '', '090-9950-2249', '', '', '茨城県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0077','藤原','ふじわら','Fujiwara','雅彦','まさひこ','MASAHIKO',0,'2002-11-25', '', '', '', '090-9380-4071', '', '', '兵庫県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0078','片岡','かたおか','Kataoka','かおり','かおり','KAORI',1,'1997-11-25', '', '', '', '080-7845-2571', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0079','窪塚','くぼづか','Kubozuka','千佳子','ちかこ','CHIKAKO',1,'1964-02-25', '', '', '', '090-9813-7380', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0080','高尾','たかお','Takao','茜','あかね','AKANE',0,'1958-02-10', '', '', '', '090-9103-3062', '', '', '群馬県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0081','仲村','なかむら','Nakamura','早織','さおり','SAORI',1,'1993-07-10', '', '', '', '080-1617-9043', '', '', '愛知県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0082','堀内','ほりうち','Horiuchi','三省','さんせい','SANSEI',0,'1993-08-31', '', '', '', '080-5870-7263', '', '', '山口県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0083','小柳','こやなぎ','Koyanagi','美紀','みき','MIKI',1,'1958-06-15', '', '', '', '080- 715-2782', '', '', '宮城県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0084','阪口','さかぐち','Sakaguchi','友以乃','ゆいの','YUINO',1,'1959-01-05', '', '', '', '090- 382-7358', '', '', '長野県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0085','北村','きたむら','Kitamura','満','みつる','MITSURU',0,'1960-12-15', '', '', '', '090-6098-1509', '', '', '三重県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0086','村田','むらた','Murata','法子','のりこ','NORIKO',1,'1998-10-20', '', '', '', '090-3938-6680', '', '', '岩手県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0087','稲葉','いなば','Inaba','徹平','てっぺい','TEPPEI',0,'2003-08-31', '', '', '', '090-5939-3131', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0088','岡本','おかもと','Okamoto','涼','りょう','RYO',0,'1999-12-25', '', '', '', '080-4408-8624', '', '', '大阪府', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0089','野崎','のざき','Nozaki','桃子','ももこ','MOMOKO',1,'2002-05-05', '', '', '', '090-9658-7661', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0090','伊東','いとう','Ito','優','ゆう','YU',0,'1966-08-25', '', '', '', '090-9569-9324', '', '', '新潟県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0091','寺井','てらい','Terai','あや子','あやこ','AYAKO',1,'1959-11-30', '', '', '', '080-4394-9951', '', '', '大分県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0092','川原','かわはら','Kawahara','ひとみ','ひとみ','HITOMI',1,'1991-12-31', '', '', '', '090- 910-5527', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0093','小松','こまつ','Komatsu','秀隆','ひでたか','HIDETAKA',0,'1995-09-30', '', '', '', '090-1797-4851', '', '', '大分県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0094','関','せき','Seki','恵梨香','えりか','ERIKA',1,'2001-02-05', '', '', '', '080-1012-5903', '', '', '福岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0095','深沢','ふかざわ','Fukazawa','洋介','ようすけ','YOSUKE',0,'1994-01-05', '', '', '', '090-6270-7250', '', '', '群馬県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0096','小田島','おだじま','Odajima','さやか','さやか','SAYAKA',1,'1954-09-15', '', '', '', '090-2386-3062', '', '', '兵庫県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0097','大田','おおた','Ota','あい','あい','AI',1,'2001-03-25', '', '', '', '080-8248-8977', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0098','福士','ふくし','Fukushi','鉄二','てつじ','TETSUJI',0,'1966-07-05', '', '', '', '080-3626-7310', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0099','高島','たかしま','Takashima','翔子','しょうこ','SHOKO',1,'1961-09-20', '', '', '', '080-7988-8151', '', '', '広島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0100','宮内','みやうち','Miyauchi','なつみ','なつみ','NATSUMI',1,'1993-01-15', '', '', '', '090- 541- 294', '', '', '福岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0101','芦屋','あしや','Ashiya','豊','ゆたか','YUTAKA',0,'1966-03-25', '', '', '', '090-3925-6574', '', '', '北海道', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0102','柳','やなぎ','Yanagi','裕次郎','ゆうじろう','YUJIRO',0,'1955-12-15', '', '', '', '080-2600-3746', '', '', '沖縄県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0103','藤木','ふじき','Fujiki','弘也','ひろなり','HIRONARI',0,'1962-03-15', '', '', '', '090-9960-3933', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0104','中谷','なかたに','Nakatani','蒼甫','そうすけ','SOSUKE',0,'1999-06-30', '', '', '', '090-4652-3130', '', '', '鹿児島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0105','島袋','しまぶくろ','Shimabukuro','涼子','りょうこ','RYOKO',1,'1998-07-10', '', '', '', '080-3148-7804', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0106','布施','ふせ','Fuse','綾女','あやめ','AYAME',1,'1996-09-20', '', '', '', '080-7751-8874', '', '', '茨城県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0107','牧','まき','Maki','くるみ','くるみ','KURUMI',1,'1993-09-25', '', '', '', '090-4978-9045', '', '', '岡山県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0108','向井','むらい','Murai','ちえみ','ちえみ','CHIEMI',1,'1965-06-20', '', '', '', '080-2384-5639', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0109','星','ほし','Hoshi','麻由子','まゆこ','MAYUKO',1,'1956-10-15', '', '', '', '080-8709-8558', '', '', '石川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0110','柴咲','しばさき','Shibasaki','雅彦','まさひこ','MASAHIKO',0,'1998-06-15', '', '', '', '080- 178-7538', '', '', '愛知県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0111','伊藤','いとう','Ito','美幸','みゆき','MIYUKI',0,'2000-03-10', '', '', '', '090-2610-3524', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0112','妻夫木','つまぶき','Tsumabuki','ひとみ','ひとみ','HITOMI',1,'1966-10-15', '', '', '', '080-2800-  83', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0113','有馬','ありま','Arima','人志','ひとし','HITOSHI',0,'1955-10-25', '', '', '', '080-5282-6043', '', '', '千葉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0114','野中','のなか','Nonaka','涼子','りょうこ','RYOKO',1,'2002-06-25', '', '', '', '090-7394-6734', '', '', '兵庫県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0115','河原','かわはら','Kawahara','光','ひかる','HIKARU',0,'1960-11-20', '', '', '', '080-7805-1075', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0116','堀田','ほった','Hotta','涼','りょう','RYO',0,'1994-11-05', '', '', '', '080-8267-4030', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0117','篠崎','しのざき','Shinozaki','和之','かずゆき','KAZUYUKI',0,'2003-08-31', '', '', '', '080-6937-2315', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0118','沢田','さわだ','Sawada','誠一','せいいち','SEIICHI',0,'1954-01-31', '', '', '', '090-3212-7295', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0119','村木','むらき','Muraki','莉沙','りさ','RISA',1,'2002-10-05', '', '', '', '090- 129-7068', '', '', '静岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0120','本村','ほんむら','Hommura','法嗣','ほうし','HOSHI',0,'1956-05-15', '', '', '', '090-6807-2717', '', '', '兵庫県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0121','上条','かみじょう','Kamijo','璃奈子','りなこ','RINAKO',1,'1959-05-10', '', '', '', '090-3134-4534', '', '', '徳島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0122','木原','きはら','Kihara','かおり','かおり','KAORI',1,'1995-04-05', '', '', '', '090-1140-8022', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0123','大川','おおかわ','Okawa','慶太','けいた','KEITA',0,'1999-05-10', '', '', '', '090-3501-5697', '', '', '愛知県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0124','深田','ふかだ','Fukada','恵','けい','KEIKO',0,'1954-11-30', '', '', '', '080-9064-6137', '', '', '兵庫県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0125','薬師丸','やくしまる','Yakushimaru','勝久','かつひさ','KATSUHISA',0,'2002-05-05', '', '', '', '090-2421-8925', '', '', '愛知県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0126','中','なか','Naka','菜々美','ななみ','NANAMI',1,'1992-06-25', '', '', '', '090-5315-4899', '', '', '福島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0127','入江','いりえ','Irie','敦','あつし','ATSUSHI',0,'1965-02-15', '', '', '', '090-5127-9600', '', '', '千葉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0128','山田','やまだ','Yamada','美幸','みゆき','MIYUKI',1,'1964-04-15', '', '', '', '080-4475-3260', '', '', '茨城県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0129','香川','かがわ','Kagawa','文世','ふみよ','FUMIYO',0,'1965-04-05', '', '', '', '090-8305-7849', '', '', '千葉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0130','高橋','たかはし','Takahashi','涼','りょう','RYO',0,'1996-10-15', '', '', '', '090-1102-5439', '', '', '福岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0131','井原','いはら','Ihara','莉緒','りお','RIO',1,'2002-05-05', '', '', '', '090-6412-8413', '', '', '長野県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0132','喜多','きた','Kita','千佳子','ちかこ','CHIKAKO',1,'1993-04-25', '', '', '', '090-9519- 219', '', '', '福島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0133','大竹','おおたけ','Otake','法嗣','ほうし','HOSHI',0,'1994-09-15', '', '', '', '080-7251-5761', '', '', '栃木県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0134','今野','いまの','Imano','直人','なおと','NAOTO',0,'1959-06-30', '', '', '', '090-8413-2201', '', '', '茨城県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0135','首藤','すどう','Sudo','宏','ひろし','HIROSHI',0,'1963-02-10', '', '', '', '080-8086-4890', '', '', '山形県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0136','細田','ほそだ','Hosoda','美智子','みちこ','MICHIKO',1,'2000-06-20', '', '', '', '090-6953-5371', '', '', '大阪府', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0137','川辺','かわべ','Kawabe','由美子','ゆみこ','YUMIKO',1,'1958-04-25', '', '', '', '090-4610- 337', '', '', '富山県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0138','柴崎','しばざき','Shibazaki','宏','ひろし','HIROSHI',0,'1963-01-15', '', '', '', '090-4475-  98', '', '', '鹿児島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0139','浅利','あさり','Asari','花緑','かろく','KAROKU',0,'1994-03-20', '', '', '', '080-6485-8515', '', '', '岐阜県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0140','久野','ひさの','Hisano','涼子','りょうこ','RYOKO',1,'1963-03-05', '', '', '', '080-8845-1674', '', '', '福島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0141','大石','おおいし','Oishi','陽子','ようこ','YOKO',1,'1956-07-05', '', '', '', '080- 432-9566', '', '', '兵庫県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0142','松居','まつい','Matsui','隼士','しゅんじ','SHUNJI',0,'2002-07-20', '', '', '', '080-9363-9200', '', '', '福島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0143','寺島','てらしま','Terashima','剛基','よしき','YOSHIKI',0,'1998-12-10', '', '', '', '090-8008-6814', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0144','福田','ふくだ','Fukuda','禄郎','ろくろう','ROKURO',0,'1999-06-05', '', '', '', '090-7875-6010', '', '', '岐阜県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0145','浅野','あさの','Asano','さやか','さやか','SAYAKA',1,'1955-06-20', '', '', '', '090-3535-4246', '', '', '福島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0146','加納','かのう','Kano','きみまろ','きみまろ','KIMIMARO',0,'1960-12-15', '', '', '', '090-6927-8448', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0147','日下','ひのした','Hinoshita','徹','とおる','TORU',0,'1999-03-20', '', '', '', '080-4094-4010', '', '', '福岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0148','西口','にしぐち','Nishiguchi','長利','ながとし','NAGATOSHI',0,'1993-11-15', '', '', '', '090- 911-5788', '', '', '滋賀県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0149','志村','しむら','Shimura','米蔵','よねぞう','YONEZO',0,'1960-11-20', '', '', '', '080-9014-7946', '', '', '徳島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0150','有田','ありた','Arita','徹','とおる','TORU',0,'1955-06-20', '', '', '', '080-5902-5925', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0151','伊集院','いじゅういん','Ijuin','獅童','しど','SHIDO',0,'2003-06-15', '', '', '', '090-9786-5058', '', '', '福島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0152','尾上','おがみ','Ogami','徹','とおる','TORU',0,'1999-04-15', '', '', '', '080-6151-5427', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0153','前島','まえじま','Maejima','誠一','せいいち','SEIICHI',0,'1993-06-15', '', '', '', '090-1430-3245', '', '', '香川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0154','風間','かざま','Kazama','昴','すばる','SUBARU',0,'1996-03-25', '', '', '', '080- 978-8141', '', '', '福岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0155','結城','ゆうき','Yuki','サンタマリア','さんたまり','SANTAMARI',1,'1960-12-15', '', '', '', '080-4882- 655', '', '', '岡山県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0156','小寺','こでら','Kodera','まさみ','まさみ','MASAMI',1,'1959-08-20', '', '', '', '080- 275-9166', '', '', '石川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0157','米倉','よねくら','Yonekura','奈月','なつき','NATSUKI',0,'2000-10-25', '', '', '', '080-3304-3868', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0158','小椋','おぐら','Ogura','杏','あん','AN',0,'1966-08-25', '', '', '', '090-1370-4148', '', '', '青森県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0159','佐久間','さくま','Sakuma','精児','せいじ','SEIJI',0,'1997-05-05', '', '', '', '090-8019-5353', '', '', '滋賀県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0160','蒼井','あおい','Aoi','たまき','たまき','TAMAKI',0,'2000-02-15', '', '', '', '080-4957-2045', '', '', '福岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0161','平田','ひらた','Hirata','真奈美','まなみ','MANAMI',1,'1998-11-15', '', '', '', '090-6278-7151', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0162','山西','やまにし','Yamanishi','愛梨','あいり','AIRI',1,'1998-06-15', '', '', '', '090-5037- 251', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0163','志村','しむら','Shimura','啓介','けいすけ','KEISUKE',0,'1998-12-10', '', '', '', '090- 607-6562', '', '', '静岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0164','沢井','さわい','Sawai','莉央','りお','RIO',0,'1997-09-10', '', '', '', '080-2883-7867', '', '', '愛知県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0165','平山','ひらやま','Hirayama','一徳','いっとく','ITTOKU',0,'2003-06-15', '', '', '', '090- 277- 215', '', '', '秋田県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0166','津川','つがわ','Tsugawa','はるか','はるか','HARUKA',1,'1994-11-05', '', '', '', '090- 107-7562', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0167','金丸','かなまる','Kanamaru','和久','かずひさ','KAZUHISA',0,'2001-07-31', '', '', '', '080-9495-6928', '', '', '広島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0168','金井','かない','Kanai','隆博','たかひろ','TAKAHIRO',0,'1998-09-25', '', '', '', '080-1950-1473', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0169','奥山','おくやま','Okuyama','恵梨香','えりか','ERIKA',1,'1991-12-05', '', '', '', '080-4391-6207', '', '', '山形県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0170','山口','やまぐち','Yamaguchi','真帆','まほ','MAHO',1,'1996-07-05', '', '', '', '090-1265-7701', '', '', '茨城県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0171','梅本','うめもと','Umemoto','京子','きょうこ','KYOKO',1,'1964-02-25', '', '', '', '080-4446-6302', '', '', '愛知県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0172','白石','しらいし','Shiraishi','達士','たつひと','TATSUHITO',0,'1956-07-05', '', '', '', '080-2700-2747', '', '', '岐阜県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0173','井川','いがわ','Igawa','璃奈子','りなこ','RINAKO',1,'1962-03-15', '', '', '', '080-1776-3977', '', '', '愛知県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0174','川原','かわはら','Kawahara','なぎさ','なぎさ','NAGISA',1,'1957-06-25', '', '', '', '080-7941-1568', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0175','沢','さわ','Sawa','信吾','しんご','SHINGO',0,'1993-03-05', '', '', '', '080-9073-2384', '', '', '岩手県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0176','真鍋','まなべ','Manabe','瞳','ひとみ','HITOMI',1,'1999-07-25', '', '', '', '080-8267-1428', '', '', '福岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0177','岩田','いわた','Iwata','裕司','ゆうじ','YUJI',0,'1961-05-15', '', '', '', '080-9893-5709', '', '', '京都府', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0178','遠山','とおやま','Toyama','愛梨','あいり','AIRI',1,'1964-06-30', '', '', '', '090-2916-2306', '', '', '広島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0179','北原','きたはら','Kitahara','三郎','さぶろう','SABURO',0,'1956-12-05', '', '', '', '080-1752- 967', '', '', '福岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0180','村岡','むらおか','Muraoka','隆之介','りゅうのす','RYUNOSU',0,'1996-12-05', '', '', '', '080-8070-5013', '', '', '兵庫県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0181','竹本','たけもと','Takemoto','花','はな','HANA',0,'1962-05-05', '', '', '', '080-6610-2146', '', '', '兵庫県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0182','藤','ふじ','Fuji','輝信','あきのぶ','AKINOBU',0,'1999-03-20', '', '', '', '090-4681-6287', '', '', '山梨県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0183','山崎','やまざき','Yamazaki','法子','のりこ','NORIKO',1,'1958-02-10', '', '', '', '090-6180-7679', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0184','八木','やぎ','Yagi','あや子','あやこ','AYAKO',1,'1995-11-20', '', '', '', '080-6328-6805', '', '', '神奈川県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0185','佐藤','さとう','Sato','綾女','あやめ','AYAME',1,'1958-12-10', '', '', '', '080-2330-4309', '', '', '和歌山県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0186','根岸','ねぎし','Negishi','さとみ','さとみ','SATOMI',1,'1957-09-10', '', '', '', '090-4330-5297', '', '', '愛知県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0187','山形','やまがた','Yamagata','奈月','なつき','NATSUKI',0,'1993-01-15', '', '', '', '090-9742-3130', '', '', '愛知県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0188','庄司','しょうじ','Shoji','優','ゆう','YU',0,'2000-11-20', '', '', '', '090-4102-7509', '', '', '東京都', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0189','三好','みよし','Miyoshi','杏','あん','AN',1,'1957-12-20', '', '', '', '080-8144-3887', '', '', '広島県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0190','松田','まつだ','Matsuda','広之','ひろゆき','HIROYUKI',0,'2000-11-20', '', '', '', '090-8028-8939', '', '', '沖縄県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0191','長谷部','はせべ','Hasebe','玲那','れな','RENA',1,'2000-12-15', '', '', '', '080-1673-2421', '', '', '新潟県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0192','岡部','おかべ','Okabe','新太','あらた','ARATA',0,'1961-07-05', '', '', '', '080-8989-1670', '', '', '滋賀県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0193','角田','かどた','Kadota','慶太','けいた','KEITA',0,'1999-02-25', '', '', '', '090- 268-1823', '', '', '群馬県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0194','深田','ふかだ','Fukada','奈央','なお','NAO',0,'1996-08-25', '', '', '', '090-9247-8713', '', '', '静岡県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0195','白川','しらかわ','Shirakawa','光','ひかる','HIKARU',0,'1956-04-20', '', '', '', '090-2070-8144', '', '', '秋田県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0196','藤村','ふじむら','Fujimura','勤','つとむ','TSUTOMU',0,'1963-05-20', '', '', '', '080-9858-9722', '', '', '埼玉県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0197','岩本','いわもと','Iwamoto','ちえみ','ちえみ','CHIEMI',1,'1961-12-31', '', '', '', '080-1489-6057', '', '', '山梨県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0198','堀川','ほりかわ','Horikawa','奈月','なつき','NATSUKI',0,'1991-12-05', '', '', '', '080- 817-4226', '', '', '栃木県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0199','山根','やまね','Yamane','蒼甫','そうすけ','SOSUKE',0,'1998-01-15', '', '', '', '090-7264-3162', '', '', '福井県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');
INSERT INTO `cyclox2`.`racers` 
(`nationality_code`, `country_code`, `code`, `family_name`, `family_name_kana`, `family_name_en`, `first_name`, `first_name_kana`, `first_name_en`, `gender`, `birth_date`, `jcf_number`, `uci_number`, `uci_code`, `phone`, `mail`, `zip_code`, `prefecture`, `address`, `note`, `modified`, `created`) 
VALUES ('', '', 'XYZ-156-0200','平岡','ひらおか','Hiraoka','だん吉','だんきち','DANKICHI',0,'2001-01-10', '', '', '', '080-5091-7418', '', '', '滋賀県', '', '', '2015-06-18 18:13:33', '2015-06-18 18:13:33');



INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0001','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0002','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0003','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0004','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0005','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0006','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0007','C4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0008','C4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0009','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0010','C3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0011','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0012','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0013','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0014','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0015','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0016','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0017','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0018','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0019','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0020','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0021','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0022','C4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0023','C3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0024','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0025','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0026','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0027','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0028','C3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0029','C3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0030','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0031','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0032','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0033','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0034','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0035','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0036','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0037','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0038','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0039','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0040','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0041','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0042','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0043','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0044','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0045','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0046','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0047','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0048','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0049','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0050','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0051','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0052','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0053','C4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0054','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0055','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0056','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0057','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0058','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0059','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0060','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0061','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0062','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0063','C4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0064','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0065','C4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0066','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0067','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0068','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0069','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0070','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0071','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0072','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0073','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0074','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0075','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0076','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0077','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0078','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0079','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0080','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0081','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0082','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0083','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0084','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0085','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0086','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0087','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0088','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0089','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0090','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0091','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0092','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0093','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0094','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0095','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0096','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0097','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0098','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0099','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0100','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0101','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0102','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0103','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0104','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0105','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0106','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0107','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0108','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0109','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0110','C3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0111','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0112','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0113','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0114','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0115','C3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0116','C4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0117','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0118','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0119','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0120','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0121','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0122','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0123','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0124','C3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0125','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0126','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0127','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0128','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0129','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0130','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0131','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0132','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0133','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0134','C3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0135','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0136','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0137','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0138','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0139','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0140','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0141','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0142','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0143','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0144','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0145','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0146','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0147','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0148','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0149','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0150','C3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0151','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0152','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0153','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0154','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0155','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0156','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0157','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0158','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0159','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0160','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0161','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0162','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0163','C4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0164','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0165','C4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0166','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0167','CM2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0168','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0169','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0170','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0171','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0172','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0173','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0174','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0175','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0176','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0177','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0178','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0179','C4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0180','C1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0181','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0182','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0183','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0184','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0185','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0186','CL3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0187','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0188','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0189','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0190','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0191','CL1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0192','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0193','C2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0194','C3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0195','CM3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0196','C3', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0197','CL2', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0198','C4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0199','CM1', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');
INSERT INTO `cyclox2`.`category_racers` 
(`racer_code`, `category_code`, `apply_date`, `reason_id`, `reason_note`, `meet_code`, `cancel_date`, `modified`, `created`) 
VALUES ('XYZ-156-0200','CM4', '2012-06-19', 1, '', '', NULL, '2015-06-19 00:25:19', '2015-06-19 00:25:19');




