SET SESSION FOREIGN_KEY_CHECKS=0;

/* Drop Tables */

DROP TABLE IF EXISTS tmp_ajoccpt_racer_sets;
DROP TABLE IF EXISTS ajoccpt_local_settings;
DROP TABLE IF EXISTS category_races_categories;
DROP TABLE IF EXISTS category_racers;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS category_groups;
DROP TABLE IF EXISTS tmp_result_update_flags;
DROP TABLE IF EXISTS point_series_racers;
DROP TABLE IF EXISTS time_records;
DROP TABLE IF EXISTS hold_points;
DROP TABLE IF EXISTS racer_results;
DROP TABLE IF EXISTS entry_racers;
DROP TABLE IF EXISTS entry_categories;
DROP TABLE IF EXISTS time_record_info;
DROP TABLE IF EXISTS entry_groups;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS groups;
DROP TABLE IF EXISTS meet_point_series;
DROP TABLE IF EXISTS meets;
DROP TABLE IF EXISTS meet_groups;
DROP TABLE IF EXISTS name_change_logs;
DROP TABLE IF EXISTS parm_vars;
DROP TABLE IF EXISTS tmp_point_series_racer_sets;
DROP TABLE IF EXISTS point_series;
DROP TABLE IF EXISTS point_series_groups;
DROP TABLE IF EXISTS unite_racer_log;
DROP TABLE IF EXISTS racers;
DROP TABLE IF EXISTS races_categories;
DROP TABLE IF EXISTS seasons;




/* Create Tables */

CREATE TABLE ajoccpt_local_settings
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	name varchar(255) BINARY NOT NULL,
	short_name varchar(255) BINARY NOT NULL,
	season_id int unsigned NOT NULL,
	setting varchar(255) BINARY NOT NULL,
	created datetime,
	modified datetime,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE categories
(
	-- C1, CL3 など
	code varchar(16) BINARY NOT NULL,
	-- Category-1 など
	name varchar(255) BINARY NOT NULL,
	short_name varchar(255) BINARY NOT NULL,
	category_group_id int unsigned NOT NULL,
	rank tinyint unsigned,
	race_min smallint unsigned,
	gender tinyint NOT NULL,
	-- 年齢により決定されるカテゴリーであるか
	is_aged_category tinyint(1) DEFAULT 0 NOT NULL,
	age_min smallint unsigned DEFAULT 0,
	age_max smallint unsigned DEFAULT 999,
	-- 学年開始時の年齢で指定する最小年齢。小1ならば6、中1ならば12となる。
	school_year_max smallint(5),
	-- 学年開始時の年齢で指定する最大学年。小1ならば6、中1ならば12となる。
	school_year_min smallint(5),
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
	name varchar(255) BINARY,
	description text NOT NULL,
	-- 昇格・降格の処理オブジェクトや js コードを指定する。
	lank_up_hint varchar(255),
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
	reason_note varchar(255),
	racer_result_id int unsigned,
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
	name varchar(255) BINARY,
	start_delay_sec int NOT NULL,
	lapout_rule tinyint NOT NULL,
	note text,
	applies_hold_pt tinyint(1) DEFAULT 1 NOT NULL,
	applies_rank_up tinyint(1) DEFAULT 1 NOT NULL,
	applies_ajocc_pt tinyint(1) NOT NULL,
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
	name varchar(255) BINARY,
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
	name_at_race varchar(255) BINARY,
	name_kana_at_race varchar(255) BINARY,
	name_en_at_race varchar(255) BINARY,
	entry_status tinyint NOT NULL,
	checks_in tinyint(1) DEFAULT 1 NOT NULL,
	team_name varchar(255) BINARY,
	note text,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE groups
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	name varchar(255) BINARY NOT NULL,
	created datetime DEFAULT NULL,
	modified datetime DEFAULT NULL,
	deleted_date datetime DEFAULT NULL,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE hold_points
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	racer_result_id int unsigned NOT NULL,
	point int DEFAULT 0 NOT NULL,
	category_code varchar(16) BINARY NOT NULL,
	created datetime,
	modified datetime,
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
	name varchar(255) NOT NULL,
	short_name varchar(255) BINARY NOT NULL,
	location varchar(255),
	organized_by varchar(255),
	homepage varchar(255),
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
	name varchar(255) BINARY NOT NULL,
	short_name varchar(255) BINARY NOT NULL,
	description text,
	homepage varchar(255),
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (code),
	UNIQUE (code)
);


CREATE TABLE meet_point_series
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	point_series_id int unsigned NOT NULL,
	-- 第3戦、など
	express_in_series varchar(255) BINARY NOT NULL,
	-- 例）CX 東北による2013-14シーズンの1発目のレースならば THK-134-001
	meet_code varchar(11) BINARY NOT NULL,
	entry_category_name varchar(255) BINARY NOT NULL,
	grade tinyint unsigned,
	-- その大会で取得したポイントの有効期間の開始日。開始日当日も有効である。
	point_term_begin date,
	-- その大会で取得したポイントの有効期間の終了日。終了日当日はポイントは有効であり、翌日は無効となる。
	point_term_end date,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	-- カンマ区切りでそれぞれの集計に関するヒントを提供する
	hint varchar(255) BINARY,
	PRIMARY KEY (id)
);


CREATE TABLE name_change_logs
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- 例）THK-134-0002
	-- 標準では12文字になるが、最後が4桁を超える可能性ありとして長さ16文字としている。
	racer_code varchar(16) BINARY NOT NULL,
	new_fam varchar(255) BINARY,
	new_fir varchar(255) BINARY,
	old_data text BINARY,
	by_user varchar(50) BINARY,
	note text BINARY,
	created datetime,
	modified datetime,
	PRIMARY KEY (id)
);


CREATE TABLE parm_vars
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- 呼び出し時のキーとなる値
	pkey varchar(64) BINARY NOT NULL,
	value varchar(255) BINARY,
	PRIMARY KEY (id),
	UNIQUE (id),
	UNIQUE (pkey)
);


CREATE TABLE point_series
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	point_series_group_id int unsigned,
	name varchar(255) BINARY NOT NULL,
	short_name varchar(255) BINARY NOT NULL,
	description text BINARY,
	calc_rule smallint unsigned NOT NULL,
	-- シーズンごと、1年ごと、積算など
	sum_up_rule tinyint unsigned NOT NULL,
	-- 個人、チームなど
	-- 
	point_to tinyint unsigned NOT NULL,
	point_term_rule tinyint unsigned DEFAULT 1,
	season_id int unsigned,
	-- 集計などのヒント（上位何戦までを比較するか）。基本的には key:value,key:value,,, と記入する。
	hint varchar(255) BINARY,
	is_active tinyint(1) DEFAULT 1 NOT NULL,
	public_psrset_group_id int unsigned,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE point_series_groups
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	name varchar(255) BINARY NOT NULL,
	-- ゼロから100までの値を格納する。World Cup ランキングが90、JCX が60など。表示順序のために利用する。
	priority_value tinyint NOT NULL,
	description text,
	is_active tinyint(1) DEFAULT 1 NOT NULL,
	created datetime,
	modified datetime,
	deleted tinyint(1) DEFAULT 0,
	deleted_date datetime,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE point_series_racers
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- 例）THK-134-0002
	-- 標準では12文字になるが、最後が4桁を超える可能性ありとして長さ16文字としている。
	racer_code varchar(16) BINARY NOT NULL,
	point_series_id int unsigned NOT NULL,
	point int unsigned NOT NULL,
	bonus int,
	racer_result_id int unsigned,
	meet_point_series_id int unsigned,
	note text BINARY,
	created datetime,
	modified datetime,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE racers
(
	-- 例）THK-134-0002
	-- 標準では12文字になるが、最後が4桁を超える可能性ありとして長さ16文字としている。
	code varchar(16) BINARY NOT NULL,
	family_name varchar(255) BINARY NOT NULL,
	family_name_kana varchar(255) BINARY NOT NULL,
	family_name_en varchar(255) BINARY NOT NULL,
	first_name varchar(255) BINARY NOT NULL,
	first_name_kana varchar(255) BINARY NOT NULL,
	first_name_en varchar(255) BINARY NOT NULL,
	team varchar(255) BINARY,
	team_en varchar(255) BINARY,
	gender tinyint NOT NULL,
	birth_date date,
	-- JPN など
	nationality_code char(3) DEFAULT 'JPN',
	-- 形式: 99ME0123456 で11文字であるが、変更される可能性を考えて text としている。
	jcf_number varchar(255) BINARY,
	-- 形式: JPN19870123 の国 code + 生年月日の形式。
	uci_number varchar(255) BINARY,
	-- UCI 登録の固有番号
	uci_code varchar(255) BINARY,
	uci_id varchar(255) BINARY,
	uci_nation_code varchar(3) BINARY,
	-- 国外、ハイフン付与を考慮して text で処理する。
	phone varchar(255),
	mail varchar(255) BINARY,
	country_code char(3) DEFAULT 'JPN',
	-- 国外郵便番号を考慮し、text 形式で扱う。
	zip_code varchar(255) BINARY,
	prefecture varchar(255) BINARY,
	address varchar(255) BINARY,
	note text BINARY,
	cat_limit varchar(255) BINARY,
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
	status tinyint DEFAULT 0 NOT NULL,
	lap int NOT NULL,
	goal_milli_sec int unsigned,
	lap_out_lap int,
	rank_at_lap_out int,
	rank_per smallint,
	run_per smallint,
	ajocc_pt int unsigned DEFAULT 0 NOT NULL,
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
	name varchar(255) BINARY NOT NULL,
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
	name varchar(255) BINARY NOT NULL,
	short_name varchar(255) BINARY NOT NULL,
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
	racer_result_id int unsigned NOT NULL,
	lap int NOT NULL,
	time_milli int unsigned NOT NULL,
	created datetime,
	modified datetime,
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
	macine varchar(255) BINARY,
	operator varchar(255) BINARY,
	note text,
	created datetime,
	modified datetime,
	deleted_date datetime,
	deleted tinyint(1) DEFAULT 0 NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (id),
	UNIQUE (entry_group_id)
);


CREATE TABLE tmp_ajoccpt_racer_sets
(
	id bigint unsigned NOT NULL AUTO_INCREMENT,
	ajoccpt_local_setting_id int unsigned,
	season_id int unsigned NOT NULL,
	-- C1, CL3 など
	category_code varchar(16) BINARY NOT NULL,
	-- タイトル行、選手データ行の別などを表す。
	type tinyint unsigned NOT NULL,
	-- タイトル号はゼロ
	rank int unsigned NOT NULL,
	-- 例）THK-134-0002
	-- 標準では12文字になるが、最後が4桁を超える可能性ありとして長さ16文字としている。
	racer_code varchar(16) BINARY NOT NULL,
	name varchar(255) BINARY,
	team varchar(255) BINARY,
	point_json text BINARY,
	sumup_json text BINARY,
	created datetime,
	modified datetime,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE tmp_point_series_racer_sets
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	point_series_id int unsigned NOT NULL,
	set_group_id int unsigned DEFAULT 1 NOT NULL,
	-- タイトル行、選手データ行の別などを表す。
	type tinyint unsigned NOT NULL,
	-- タイトル号はゼロ
	rank int unsigned NOT NULL,
	-- 例）THK-134-0002
	-- 標準では12文字になるが、最後が4桁を超える可能性ありとして長さ16文字としている。
	racer_code varchar(16) BINARY NOT NULL,
	name varchar(255) BINARY,
	team varchar(255) BINARY,
	point_json text BINARY,
	sumup_json text BINARY,
	created datetime,
	modified datetime,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE tmp_result_update_flags
(
	id int NOT NULL AUTO_INCREMENT,
	-- cakephp のための primary key として。
	entry_category_id int unsigned NOT NULL,
	result_updated datetime NOT NULL,
	points_sumuped tinyint(1) DEFAULT 0,
	ajoccpt_sumuped tinyint(1) DEFAULT 0 NOT NULL,
	created datetime,
	modified datetime,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE unite_racer_log
(
	id int unsigned NOT NULL AUTO_INCREMENT,
	-- 例）THK-134-0002
	-- 標準では12文字になるが、最後が4桁を超える可能性ありとして長さ16文字としている。
	united varchar(16) BINARY NOT NULL,
	-- 統合先選手のコード
	unite_to varchar(16) BINARY NOT NULL,
	at_date datetime NOT NULL,
	log text,
	user_by varchar(50) BINARY,
	-- 1:done もしくは 2:reverted
	status tinyint DEFAULT 1 NOT NULL,
	created datetime,
	modified datetime,
	PRIMARY KEY (id),
	UNIQUE (id)
);


CREATE TABLE users
(
	id int NOT NULL AUTO_INCREMENT,
	username varchar(50) BINARY NOT NULL,
	password varchar(255) BINARY NOT NULL,
	group_id int unsigned NOT NULL,
	email varchar(255) BINARY,
	active tinyint(1) DEFAULT 0 NOT NULL,
	created datetime DEFAULT null,
	modified datetime DEFAULT null,
	deleted_date datetime DEFAULT null,
	deleted tinyint(1) DEFAULT 0,
	PRIMARY KEY (id),
	UNIQUE (username)
);



