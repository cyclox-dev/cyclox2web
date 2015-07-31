SET SESSION FOREIGN_KEY_CHECKS=0;

/* Drop Tables */

DROP TABLE IF EXISTS category_races_categories;
DROP TABLE IF EXISTS category_racers;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS category_groups;
DROP TABLE IF EXISTS time_records;
DROP TABLE IF EXISTS racer_results;
DROP TABLE IF EXISTS entry_racers;
DROP TABLE IF EXISTS entry_categories;
DROP TABLE IF EXISTS time_record_info;
DROP TABLE IF EXISTS entry_groups;
DROP TABLE IF EXISTS meets;
DROP TABLE IF EXISTS meet_groups;
DROP TABLE IF EXISTS parm_vars;
DROP TABLE IF EXISTS racers;
DROP TABLE IF EXISTS races_categories;
DROP TABLE IF EXISTS seasons;
DROP TABLE IF EXISTS users;




/* Create Tables */

CREATE TABLE categories
(
	-- C1, CL3 など
	code varchar(16) BINARY NOT NULL,
	-- Category-1 など
	name text BINARY NOT NULL,
	short_name text BINARY NOT NULL,
	category_group_id int unsigned NOT NULL,
	lank tinyint unsigned NOT NULL,
	race_min smallint unsigned,
	gender tinyint NOT NULL,
	age_min smallint unsigned DEFAULT 0,
	age_max smallint unsigned DEFAULT 999,
	description text NOT NULL,
	needs_jcf tinyint NOT NULL,
	needs_uci tinyint NOT NULL,
	uci_age_limit varchar(5) DEFAULT '',
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (code),
	UNIQUE (code)
);


CREATE TABLE category_groups
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	name text BINARY,
	description text NOT NULL,
	-- 昇格・降格の処理オブジェクトや js コードを指定する。
	lank_up_hint text,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE category_racers
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- 例）THK-134-0002
	-- 標準では12文字になるが、最後が4桁を超える可能性ありとして長さ16文字としている。
	racer_code varchar(16) BINARY NOT NULL,
	-- C1, CL3 など
	category_code varchar(16) BINARY NOT NULL,
	apply_date date NOT NULL,
	reason_id int unsigned NOT NULL,
	reason_note text,
	-- 例）CX 東北による2013-14シーズンの1発目のレースならば THK-134-001
	meet_code varchar(11) BINARY,
	cancel_date date,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE category_races_categories
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- C1, CL3 など
	category_code varchar(16) BINARY NOT NULL,
	races_category_code varchar(16) BINARY NOT NULL,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE entry_categories
(
	-- cakephp のための primary key として。
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- cakephp のための primary key として。
	entry_group_id int unsigned NOT NULL,
	races_category_code varchar(16) BINARY NOT NULL,
	-- null ならば entry_category.name をつなげたもの
	name text BINARY,
	start_delay_sec int NOT NULL,
	lapout_rule tinyint NOT NULL,
	note text,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE entry_groups
(
	-- cakephp のための primary key として。
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- 例）CX 東北による2013-14シーズンの1発目のレースならば THK-134-001
	meet_code varchar(11) BINARY NOT NULL,
	-- null ならば entry_category.name をつなげたもの
	name text BINARY,
	start_clock time,
	start_frac_distance float(6,3),
	lap_distance float(6,3),
	skip_lap_count tinyint DEFAULT 0 NOT NULL,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE entry_racers
(
	-- cakephp での primary key として。
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- cakephp のための primary key として。
	entry_category_id int unsigned NOT NULL,
	-- 例）THK-134-0002
	-- 標準では12文字になるが、最後が4桁を超える可能性ありとして長さ16文字としている。
	racer_code varchar(16) BINARY NOT NULL,
	body_number varchar(16) BINARY,
	name_at_race text BINARY,
	name_kana_at_race text BINARY,
	name_en_at_race text BINARY,
	entry_status tinyint NOT NULL,
	team_name text BINARY,
	note text,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE meets
(
	-- 例）CX 東北による2013-14シーズンの1発目のレースならば THK-134-001
	code varchar(11) BINARY NOT NULL,
	-- KNS, THK など
	meet_group_code varchar(3) BINARY DEFAULT 'XXX' NOT NULL,
	season_id int unsigned NOT NULL,
	at_date date NOT NULL,
	name text NOT NULL,
	short_name text BINARY NOT NULL,
	location text,
	organized_by text,
	homepage text,
	start_frac_distance float(6,3) DEFAULT 0.0,
	lap_distance float(6,3) DEFAULT 2.0,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (code),
	UNIQUE (code)
);


CREATE TABLE meet_groups
(
	-- KNS, THK など
	code varchar(3) BINARY NOT NULL,
	name text BINARY NOT NULL,
	short_name text BINARY NOT NULL,
	description text,
	homepage text,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (code),
	UNIQUE (code)
);


CREATE TABLE parm_vars
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- 呼び出し時のキーとなる値
	pkey varchar(64) BINARY NOT NULL,
	value text BINARY,
	PRIMARY KEY (id),
	UNIQUE (id),
	UNIQUE (pkey)
);


CREATE TABLE racers
(
	-- 例）THK-134-0002
	-- 標準では12文字になるが、最後が4桁を超える可能性ありとして長さ16文字としている。
	code varchar(16) BINARY NOT NULL,
	family_name text BINARY NOT NULL,
	family_name_kana text BINARY NOT NULL,
	family_name_en text BINARY NOT NULL,
	first_name text BINARY NOT NULL,
	first_name_kana text BINARY NOT NULL,
	first_name_en text BINARY NOT NULL,
	gender tinyint NOT NULL,
	birth_date date,
	-- JPN など
	nationality_code char(3) DEFAULT 'JPN',
	-- 形式: 99ME0123456 で11文字であるが、変更される可能性を考えて text としている。
	jcf_number text BINARY,
	-- 形式: JPN19870123 の国 code + 生年月日の形式。
	uci_number text BINARY,
	-- UCI 登録の固有番号
	uci_code text BINARY,
	-- 国外、ハイフン付与を考慮して text で処理する。
	phone text,
	mail text BINARY,
	country_code char(3) DEFAULT 'JPN',
	-- 国外郵便番号を考慮し、text 形式で扱う。
	zip_code text BINARY,
	prefecture text BINARY,
	address text BINARY,
	note text BINARY,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (code),
	UNIQUE (code)
);


CREATE TABLE racer_results
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	order_index int unsigned NOT NULL,
	rank int unsigned,
	-- cakephp での primary key として。
	entry_racer_id int unsigned NOT NULL,
	lap int NOT NULL,
	goal_milli_sec int unsigned,
	lap_out_lap int,
	rank_at_lap_out int unsigned,
	note text,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE races_categories
(
	code varchar(16) BINARY NOT NULL,
	-- null ならば entry_category.name をつなげたもの
	name text BINARY NOT NULL,
	description text NOT NULL,
	age_min smallint unsigned DEFAULT 0,
	age_max smallint unsigned DEFAULT 999,
	gender tinyint,
	needs_jcf tinyint,
	needs_uci tinyint,
	race_min smallint unsigned,
	uci_age_limit varchar(5),
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (code),
	UNIQUE (code)
);


CREATE TABLE seasons
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- null ならば entry_category.name をつなげたもの
	name text BINARY NOT NULL,
	short_name text BINARY NOT NULL,
	start_date date NOT NULL,
	end_date date NOT NULL,
	-- is_regular == true ならば昇格を判定する、などに利用する。
	is_regular boolean NOT NULL,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE time_records
(
	id bigint unsigned NOT NULL AUTO_INCREMENT,
	-- cakephp での primary key として。
	entry_racer_id int unsigned NOT NULL,
	lap int NOT NULL,
	time_milli int unsigned NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE time_record_info
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- cakephp のための primary key として。
	entry_group_id int unsigned NOT NULL,
	time_start_datetime datetime,
	skip_lap_count tinyint DEFAULT 0 NOT NULL,
	-- ゴールラインならば 0.0。全長が 3.0km でゴールすぎて 1.0km のポイントで計測していれば 1.0 となる。中間計測対応のための値。
	distance float DEFAULT 0.0 NOT NULL,
	-- 計測精度を表す min=0, max=100 とする値。複数の計測方法への対応。目取と cyclox2 による入力であれば 50。確定データは 100 とする。
	accuracy tinyint unsigned DEFAULT 50 NOT NULL,
	-- 計測の記録としての値
	macine text BINARY,
	operator text BINARY,
	note text,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id),
	UNIQUE (entry_group_id)
);


CREATE TABLE users
(
	id int NOT NULL AUTO_INCREMENT,
	username varchar(50) BINARY NOT NULL,
	password varchar(255) BINARY NOT NULL,
	role varchar(64) BINARY NOT NULL,
	email varchar(255) BINARY,
	active tinyint(1) DEFAULT 0 NOT NULL,
	created datetime DEFAULT null,
	modified datetime DEFAULT null,
	deleted_date datetime DEFAULT null,
	deleted tinyint(1) DEFAULT 0,
	PRIMARY KEY (id),
	UNIQUE (username)
);



