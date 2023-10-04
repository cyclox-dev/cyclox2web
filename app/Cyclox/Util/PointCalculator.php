<?php

App::uses('EntryRacer', 'Model');
App::uses('RacerResultStatus', 'Cyclox/Const');

/*
 *  created at 2015/08/16 by shun
 */

/**
 * Description of PointCalculator
 *
 * @author shun
 */
class PointCalculator extends CakeObject
{
	public static $JCX_156;
	public static $KNS_156;
	public static $IBRK_167;
	public static $CCM_167;
	public static $TKI_178;
	public static $KNT_178;
	public static $THK_178;
	public static $JCX_201;
	public static $TCX_223;
	public static $JCX_234;
	
	private static $TABLE_JCX156_GRADE1 = array(
		300, 240, 210, 180, 165, 150, 135, 120, 105, 90, 
		87,  84,  81,  78,  75,  72,  69,  66,  63, 60,
		58,  56,  54,  52,  50,  48,  46,  44,  42, 40,
		39,  38,  37,  36,  35,  34,  33,  32,  31, 30,
		29,  28,  27,  26,  25,  24,  23,  22,  21, 20,
	);
	const RUN_PT_JCX156_GRACE1 = 10; // 51位以下のポイント
	private static $TABLE_JCX156_GRADE2 = array(
		200, 160, 140, 120, 110, 100, 90,  80,  70,  60,
		58,  56,  54,  52,  50,  48,  46,  44,  42,  40,
		39,  38,  37,  36,  35,  34,  33,  32,  31,  30,
		29,  28,  27,  26,  25,  24,  23,  22,  21,  20,
		19,  18,  17,  16,  15,  14,  13,  12,  11,  10,
	);
	const RUN_PT_JCX156_GRACE2 = 5; // 51位以下のポイント
	const JCX156_BONUS_TO156 = 20;
	const JCX156_BONUS_167TO = 10;
	
	private static $TABLE_KNS156 = array(
		200, 160, 140, 120, 110, 100, 90,  80,  70,  60,
		58,  56,  54,  52,  50,  48,  46,  44,  42,  40,
		39,  38,  37,  36,  35,  34,  33,  32,  31,  30,
		29,  28,  27,  26,  25,  24,  23,  22,  21,  20,
		19,  18,  17,  16,  15,  14,  13,  12,  11,  10,
	);
	const RUN_PT_KNS156 = 5;
	
	private static $TABLE_IBRK167 = array(
		56, 47, 41, 36, 32, 28, 25, 22, 20, 18,
		16, 14, 13, 12, 11, 10, 9, 9, 8, 8,
		7, 7, 7, 6, 6, 6, 5, 5, 5, 5,
		4, 4, 4, 4, 3, 3, 3, 3, 3, 3,
		2, 2, 2, 2, 2, 2, 2, 1, 1, 1,
	);
	const RUN_PT_IBRK167 = 1;
	
	private static $TABLE_TKI178 = array(
		56, 47, 41, 36, 32, 28, 25, 22, 20, 18,
		16, 14, 13, 12, 11, 10, 9, 9, 8, 8,
		7, 7, 7, 6, 6, 6, 5, 5, 5, 5,
		4, 4, 4, 4, 3, 3, 3, 3, 3, 3,
		2, 2, 2, 2, 2, 2, 2, 1, 1, 1,
	);
	const RUN_PT_TKI178 = 1;
	
	private static $TABLE_THK178 = array(
		40,30,20,15,10,8,6,4,2,1
	);
	
	private static $TABLE_JCX201_GRADE1 = array(
		250, 200, 160, 150, 140, 130, 120, 110, 100, 95,
		90, 85, 80, 78, 76, 74, 72, 70, 68, 66,
		64, 62, 60, 58, 56, 54, 52, 50, 48, 46,
		44, 42, 40, 38, 36, 38, 36, 34, 32, 30,
		29, 28, 27, 26, 25, 24, 23, 22, 21, 20,
		19, 18, 17, 16, 15, 14, 13, 12, 11, 10,
		9, 8, 7, 6, 5, 4, 3, 2

	);
	const RUN_PT_JCX201_GRADE1 = 1; // 69位以下のポイント
	private static $TABLE_JCX201_GRADE2 = array(
		200, 160, 140, 120, 110, 100, 90, 80, 70, 60,
		58, 56, 54, 52, 50, 48, 46, 44, 42, 40,
		39, 38, 37, 36, 35, 34, 33, 32, 31, 30,
		29, 28, 27, 26, 25, 24, 23, 22, 21, 20,
		19, 18, 17, 16, 15, 14, 13, 12, 11, 10,
		9, 8, 7, 6, 5, 4, 3, 2, 1, 1,
		1, 1, 1, 1, 1, 1, 1, 1

	);
	const RUN_PT_JCX201_GRADE2 = 1; // 69位以下のポイント

    private static $TABLE_JCX234_GRADE1 = array(
		200, 160, 140, 120, 100, 80, 60, 40, 20, 10,
		8, 8, 8, 8, 8, 6, 6, 6, 6, 6,
		4, 4, 4, 4, 4, 2, 2, 2, 2, 2
	);
    private static $TABLE_JCX234_GRADE2 = array(
		100, 80, 70, 60, 50, 40, 30, 20, 10, 5,
		4, 4, 4, 4, 4, 3, 3, 3, 3, 3,
		2, 2, 2, 2, 2, 1, 1, 1, 1, 1
	);
	const RUN_PT_JCX234 = 0; // 31位以下のポイント
	
	// const として
	const __KEY_STARTED_OVER = 'started_over';
	const __KEY_TABLE = 'table';
	
	private static $TABLE_CCM167; // --> init() で初期化
	private static $TABLE_KNT178; // --> init() で初期化
	private static $TABLE_TCX223; // --> init() で初期化
	
	private static $calculators;
	
	public static function calculators()
	{
		return self::$calculators;
	}
	
	public static function init()
	{
		$str = '';
		for ($i = 0; $i < count(self::$TABLE_JCX156_GRADE1); $i++) {
			$str .= ' ' . self::$TABLE_JCX156_GRADE1[$i] . ',';
			if (($i + 1) % 10 == 0) {
				$str .= '</br>';
			}
		}
		$str2 = '';
		for ($i = 0; $i < count(self::$TABLE_JCX156_GRADE2); $i++) {
			$str2 .= ' ' . self::$TABLE_JCX156_GRADE2[$i] . ',';
			if (($i + 1) % 10 == 0) {
				$str2 .= '</br>';
			}
		}
		$text = '2015-16シーズンの JCX シリーズにて採用されたポイント付与ルール。</br>'
			. 'シリーズレース設定では必ずグレードを指定すること。グレードは 1 もしくは 2 を指定する。</br>'
			. '---</br>'
			. 'グレード1のポイントテーブルは以下のとおり</br>'
			. $str
			. (count(self::$TABLE_JCX156_GRADE1) + 1) . '位以下:' . self::RUN_PT_JCX156_GRACE1 . '</br>'
			. '---</br>グレード2のポイントテーブルは以下のとおり</br>'
			. $str2
			. (count(self::$TABLE_JCX156_GRADE2) + 1) . '位以下:' . self::RUN_PT_JCX156_GRACE2 . '</br>'
			. '---</br>'
			. 'また、レースのトップ選手と同一集会で完走した場合、2015-16シーズンは' . self::JCX156_BONUS_TO156
			. 'pt、2016-17シーズン以降は' . self::JCX156_BONUS_167TO . 'pt のボーナスポイントが付与される。'
			;
		self::$JCX_156 = new PointCalculator(1, 'JCX-156', '2015-16 JCX で使用するポイントテーブル。', $text);
		
		$str = '';
		for ($i = 0; $i < count(self::$TABLE_KNS156); $i++) {
			$str .= ' ' . self::$TABLE_KNS156[$i] . ',';
			if (($i + 1) % 10 == 0) {
				$str .= '</br>';
			}
		}
		$text = '2015-16シーズンの関西クロス C1, CM1, CL1 で採用されたポイント付与ルール。'
			. '2015-16 JCX シリーズのグレード2と同じポイントテーブルである。ただし同一周回ボーナスは無し。'
			. 'グレードの指定は必要ない。</br>'
			. '---</br>'
			. 'ポイントテーブル</br>' . $str;
		self::$KNS_156 = new PointCalculator(2, 'KNS-156', '2015-16 関西クロスで使用するポイントテーブル。配点は JCX ポイントと同じ。完走ボーナスは無し。', $text);
		
		$str = '';
		for ($i = 0; $i < count(self::$TABLE_IBRK167); $i++) {
			$str .= ' ' . self::$TABLE_IBRK167[$i] . ',';
			if (($i + 1) % 10 == 0) {
				$str .= '</br>';
			}
		}
		$text = '2016-17 茨城クロスのシリーズランキングのために作られたポイントテーブル。15-16 AJOCC ポイントの出走41人〜のテーブルと同じである。'
			. '51位以下は' . self::RUN_PT_IBRK167 . 'ポイント。ボーナスなどは無し。グレードの指定は必要ない。'
			. 'DNS,DNF にもポイントが付与される（リザルトがゼッケン順に並んでいることを前提としている）。</br>---</br>'
			. 'ポイントテーブル</br>' . $str;
		self::$IBRK_167 = new PointCalculator(3, 'IBRK-167', '2016-17 茨城クロスのポイントテーブル。AJOCC ポイントの出走41〜と同じ。', $text);
		
		// table 初期化
		self::$TABLE_CCM167 = array(
			array(
				self::__KEY_STARTED_OVER => 40, self::__KEY_TABLE => array(
					56, 47, 41, 36, 32, 28, 25, 22, 20, 18,
					16, 14, 13, 12, 11, 10,  9,  9,  8,  8,
					 7,  7,  7,  6,  6,  6,  5,  5,  5,  5,
					 4,  4,  4,  4,  3,  3,  3,  3,  3,  3,
					 2,  2,  2,  2,  2,  2,  2,  1,  1,  1,
					 1,  1,  1,  1,  1,  1,  1,  1,  1,  1,
				)
			),
			array(
				self::__KEY_STARTED_OVER => 20, self::__KEY_TABLE => array(
					42, 34, 28, 24, 21, 18, 15, 13, 11, 10,
					9,  8,  7,  6,  6,  5,  5,  4,  4,  4,
					3,  3,  3,  3,  2,  2,  2,  2,  2,  2,
					2,  1,  1,  1,  1,  1,  1,  1,  1,  1,
				)
			),
			array(
				self::__KEY_STARTED_OVER => 0, self::__KEY_TABLE => array(
					28, 20, 15, 12, 10, 8,  6,  5,  4,  3,
					3,  2,  2,  2,  1,  1,  1,  1,  1,  1,
				)
			)
		);
		$str = '';
		for ($i = 0; $i < count(self::$TABLE_CCM167); $i++) {
			$str .= '---</br>';
			$pack = self::$TABLE_CCM167[$i];
			$str .= ($pack[self::__KEY_STARTED_OVER] + 1) . '人以上</br>';
			for ($j = 0; $j < count($pack[self::__KEY_TABLE]); $j++) {
				$str .= ' ' . $pack[self::__KEY_TABLE][$j] . ',';
				if (($j + 1) % 10 == 0) {
					$str .= '</br>';
				}
			}
		}
		
		$text = '2016-17 信州クロスのシリーズランキングのために作られたポイントテーブル。'
			. '15-16 AJOCC ポイントと同じ配点である。ボーナスなどは無し。グレード 1 or 2 を指定すること。'
			. 'グレード2の場合には獲得得点が半分となる（小数点以下切り上げ）。'
			. '</br>ポイントテーブル</br>' . $str;
		self::$CCM_167 = new PointCalculator(4, 'CCM-167', '2016-17 信州クロスのポイントテーブル。15-16 AJOCC ポイントと同じ。グレード2は得点半分。', $text);
		
		$str = '';
		for ($i = 0; $i < count(self::$TABLE_TKI178); $i++) {
			$str .= ' ' . self::$TABLE_TKI178[$i] . ',';
			if (($i + 1) % 10 == 0) {
				$str .= '</br>';
			}
		}
		$text = '2017-18 東海クロスのシリーズランキングのために作られたポイントテーブル。（ただしスタート順決定のため、16-17のリザルトに対しても利用する、とのこと。）'
			. 'IBRK_167 と同じ配点、51位以下は' . self::RUN_PT_TKI178 . 'ポイント。順位があるリザルトに対してのみポイントが付与される（DNS,DNF に対してポイントは無し）。'
			. 'グレードの指定は必要ない。</br>---</br>'
			. 'ポイントテーブル</br>' . $str;
		self::$TKI_178 = new PointCalculator(5, 'TKI-178', '201-18 東海クロスのポイントテーブル。$IBRK_167 ポイントと同じテーブルだが、ポイント対象は順位ありリザルトのみ。', $text);
		
		self::$TABLE_KNT178 = array(
			array(
				self::__KEY_STARTED_OVER => 39, self::__KEY_TABLE => array(
					56, 47, 41, 36, 32, 28, 25, 22, 20, 18,
					16, 14, 13, 12, 11, 10,  9,  9,  8,  8,
					 7,  7,  7,  6,  6,  6,  5,  5,  5,  5,
					 4,  4,  4,  4,  3,  3,  3,  3,  3,  3,
					 2,  2,  2,  2,  2,  2,  2,  1,  1,  1,
					 1,  1,  1,  1,  1,  1,  1,  1,  1,  1,
				)
			),
			array(
				self::__KEY_STARTED_OVER => 19, self::__KEY_TABLE => array(
					42, 34, 28, 24, 21, 18, 15, 13, 11, 10,
					9,  8,  7,  6,  6,  5,  5,  4,  4,  4,
					3,  3,  3,  3,  2,  2,  2,  2,  2,  2,
					2,  1,  1,  1,  1,  1,  1,  1,  1,
				)
			),
			array(
				self::__KEY_STARTED_OVER => 0,self::__KEY_TABLE => array(
					28, 20, 15, 12, 10, 8,  6,  5,  4,  3,
					3,  2,  2,  2,  1,  1,  1,  1,  1,
				)
			)
		);
		
		
		$str = '';
		for ($i = 0; $i < count(self::$TABLE_KNT178); $i++) {
			$str .= '---</br>';
			$pack = self::$TABLE_KNT178[$i];
			$str .= ($pack[self::__KEY_STARTED_OVER] + 1) . '人以上</br>';
			$n = count($pack[self::__KEY_TABLE]);
			for ($j = 0; $j < $n; $j++) {
				$str .= ' ' . $pack[self::__KEY_TABLE][$j] . ',';
				if (($j + 1) % 10 == 0 || $j == $n-1) {
					$str .= '</br>';
				}
			}
		}
		
		$text = '2017-18 関東地域のシリーズランキングのために作られたポイントテーブル。'
			. '17-18 AJOCC ポイントと同じ配点である。ボーナスなどは無し。グレード分けは無し。'
			. '</br>ポイントテーブル</br>' . $str;
		self::$KNT_178 = new PointCalculator(6, 'KNT-178', '2017-18 関東地方のポイントテーブル。17-18 AJOCC ポイントと同じ。グレード指定なし。', $text);
		
		$str = '';
		for ($i = 0; $i < count(self::$TABLE_THK178); $i++) {
			$str .= ' ' . self::$TABLE_THK178[$i] . ',';
			if (($i + 1) % 10 == 0) {
				$str .= '</br>';
			}
		}
		$text = '2017-18 東北 CX のシリーズランキングのために作られたポイントテーブル。順位があるリザルトに対してのみポイントが付与される（DNS,DNF に対してポイントは無し）。'
			. 'ボーナス、出走ポイントは無し。グレードの指定は必要ない。</br>---</br>'
			. 'ポイントテーブル</br>' . $str;
		self::$THK_178 = new PointCalculator(7, 'THK-178', '2017-18 東北 CX のポイントテーブル。ポイントは10位まで。', $text);
		
		$str = '';
		for ($i = 0; $i < count(self::$TABLE_JCX201_GRADE1); $i++) {
			$str .= ' ' . self::$TABLE_JCX201_GRADE1[$i] . ',';
			if (($i + 1) % 10 == 0) {
				$str .= '</br>';
			}
		}
		$str2 = '';
		for ($i = 0; $i < count(self::$TABLE_JCX201_GRADE2); $i++) {
			$str2 .= ' ' . self::$TABLE_JCX201_GRADE2[$i] . ',';
			if (($i + 1) % 10 == 0) {
				$str2 .= '</br>';
			}
		}
		$text = '2020-21シーズンの JCX シリーズにて採用されたポイント付与ルール。</br>'
			. 'シリーズレース設定では必ずグレードを指定すること。グレードは 1 もしくは 2 を指定する。</br>'
			. '---</br>'
			. '※2020-04-01より前の大会でのポイントについては JCX-156 のポイントが付与される。'
			. 'グレード1のポイントテーブルは以下のとおり</br>'
			. $str
			. (count(self::$TABLE_JCX201_GRADE1) + 1) . '位以下:' . self::RUN_PT_JCX201_GRADE1 . '</br>'
			. '---</br>グレード2のポイントテーブルは以下のとおり</br>'
			. $str2
			. (count(self::$TABLE_JCX201_GRADE2) + 1) . '位以下:' . self::RUN_PT_JCX201_GRADE2 . '</br>'
			;
		self::$JCX_201 = new PointCalculator(8, 'JCX_201', '2020-21 JCX で使用するポイントテーブル。', $text);
		
		// table 初期化
		self::$TABLE_TCX223 = array(
			array(
				self::__KEY_STARTED_OVER => 39, self::__KEY_TABLE => array(
					180,150,130,110,100,90,80,70,60,52,
					46,42,40,38,36,35,34,33,32,31,
					30,29,28,27,26,25,24,23,22,21,
					20,19,18,17,16,15,14,13,12,11,
					10,9,8,7,6,5,4,3,2,1,

				)
			),
			array(
				self::__KEY_STARTED_OVER => 19, self::__KEY_TABLE => array(
					150,120,100,90,80,70,60,52,45,39,
					34,30,27,26,25,24,23,22,21,20,
					19,18,17,16,15,14,13,12,11,10,
					9,8,7,6,5,4,3,2,1,0

				)
			),
			array(
				self::__KEY_STARTED_OVER => 0, self::__KEY_TABLE => array(
					100,80,70,60,50,42,34,28,22,17,
					12,8,7,6,5,4,3,2,1,0

				)
			)
		);
		$str = '';
		for ($i = 0; $i < count(self::$TABLE_TCX223); $i++) {
			$str .= '---</br>';
			$pack = self::$TABLE_TCX223[$i];
			$str .= ($pack[self::__KEY_STARTED_OVER] + 1) . '人以上</br>';
			for ($j = 0; $j < count($pack[self::__KEY_TABLE]); $j++) {
				$str .= ' ' . $pack[self::__KEY_TABLE][$j] . ',';
				if (($j + 1) % 10 == 0) {
					$str .= '</br>';
				}
			}
		}
		
		$text = '2022-23 東北クロスのシリーズランキングのために作られたポイントテーブル。'
			. '22-23 AJOCC ポイントと同じ配点である。ただしJCXテーブルは使用しない。ボーナスなどは無し。グレード指定は不要。'
			. '</br>ポイントテーブル</br>' . $str;
		self::$TCX_223 = new PointCalculator(9, 'TCX_223', '2022-23 東北クロスのポイントテーブル。22-23 AJOCC ポイントと同じ（JCX テーブル無し）。', $text);

        $str = '';
		$str .= '---</br>';
		$str .= '全日本選手権のポイントテーブルは以下のとおり</br>';
		$pack = self::$TABLE_JCX234_GRADE1;
		for ($j = 0; $j < count($pack); $j++) {
			$str .= ' ' . $pack[$j] . ',';
			if (($j + 1) % 10 == 0) {
				$str .= '</br>';
			}
        }
        $str .= ($j + 1) . '位以下:' . self::RUN_PT_JCX234 . '</br>';
		$str .= '---</br>';
		$str .= '全日本選手権以外のJCX戦のポイントテーブルは以下のとおり</br>';
		$pack = self::$TABLE_JCX234_GRADE2;
		for ($j = 0; $j < count($pack); $j++) {
			$str .= ' ' . $pack[$j] . ',';
			if (($j + 1) % 10 == 0) {
				$str .= '</br>';
			}
		}
        $str .= ($j + 1) . '位以下:' . self::RUN_PT_JCX234 . '</br>';
		
		$text = '2023-24シーズンの JCX シリーズ（全日本選手権を含む）にて採用されたポイント付与ルール。</br>'
			. 'シリーズレース設定では必ずグレードを指定する。全日本選手権はグレード 1 それ以外のJCX戦はグレード 2 を指定する。</br>'
			. '</br>ポイントテーブル</br>' . $str;
		self::$JCX_234 = new PointCalculator(10, 'JCX_234', '2023-24 JCX シリーズ（全日本選手権を含む）のポイントテーブル。', $text);
		
		self::$calculators = array(
			self::$JCX_156,
			self::$KNS_156,
			self::$IBRK_167,
			self::$CCM_167,
			self::$TKI_178,
			self::$KNT_178,
			self::$THK_178,
			self::$JCX_201,
			self::$TCX_223,
			self::$JCX_234,
		);
	}
	
	private $val;
	private $name;
	private $description;
	private $text;
	
	public function __construct($v, $n, $d, $t)
		// private にしたかったが、Object 継承すると public でなければならない。
	{
		parent::__construct();
		
		$this->val = $v;
		$this->name = $n;
		$this->description = $d;
		$this->text = $t;
	}
	
	/** @return int DB 上の記録値 */
    public function val() { return $this->val; }
    /** @return string 名前 */
    public function name() { return $this->name; }
    /** @return string 計算方法詳細 */
    public function description() { return $this->description; }
	/** @return string 内容詳細 */
    public function text() { return $this->text; }
	
	/**
	 * 計算オブジェクトをかえす。
	 * @param int $v DB 上の値
	 * @return PointCalculator 計算者。見つからない場合 null をかえす。
	 */
	public static function getCalculator($v) {
		foreach (self::$calculators as $calc) {
			if ($calc->val() == $v) return $calc;
		}
		return null;
	}
	
	/**
	 * 
	 * @param type $result
	 * @param type $grade
	 * @param int $raceLapCount レーストップの周回数
	 * @param int $raceStartedCount レース出走人数
	 * @param date $meetDate 大会開催日
	 * @return int 点数配列 array('point' => point, 'bonus' => bonus)。付与するポイントが皆無の場合、null をかえす。
	 */
	public function calc($result, $grade, $raceLapCount, $raceStartedCount, $meetDate) {
		$pt = null;
		switch ($this->val()) {
			case self::$JCX_156->val(): $pt = $this->__calcJCXElite156($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
			case self::$KNS_156->val(): $pt = $this->__calcKNS156($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
			case self::$IBRK_167->val(): $pt = $this->__calcIBRK167($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
			case self::$CCM_167->val(): $pt = $this->__calcCCM167($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
			case self::$TKI_178->val(): $pt = $this->__calcTKI167($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
			case self::$KNT_178->val(): $pt = $this->__calcKNT178($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
			case self::$THK_178->val(): $pt = $this->__calcTHK178($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
			case self::$JCX_201->val(): $pt = $this->__calcJCX201($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
			case self::$TCX_223->val(): $pt = $this->__calcTCX223($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
			case self::$JCX_234->val(): $pt = $this->__calcJCX234($result, $grade, $raceLapCount, $raceStartedCount, $meetDate); break;
		}
		
		if (empty($pt['point']) && empty($pt['bonus'])) {
			return null;
		}
		
		return $pt;
	}
	
	/**
	 * 2015-16シーズンに設定された JCX ポイントをかえす。16-17 のボーナスポイント変更(20->10)も適用済み。
	 * @param type $result 選手ごとリザルト
	 * @param type $grade グレードはこのポイントテーブルでは関係しない。
	 * @param type $raceLapCount レーストップの周回数
	 * @param int $raceStartedCount レース出走人数
	 * @param date $meetDate 大会開催日
	 * @return int ポイント。取得ポイントがない場合は null をかえす。
	 */
	private function __calcJCXElite156($result, $grade, $raceLapCount, $raceStartedCount, $meetDate)
	{
		//$this->log('grade:' . $grade . ' result:', LOG_DEBUG);
		//$this->log($result, LOG_DEBUG);
		//$this->log('ecat', LOG_DEBUG);
		//$this->log($ecat, LOG_DEBUG);
		
		if (empty($result['rank'])) return null;
		
		// grade -> points
		$set = array();
		$set[1] = array(
			'rank_pt' => self::$TABLE_JCX156_GRADE1,
			'run_pt' => self::RUN_PT_JCX156_GRACE1,
		);
		$set[2] = array(
			'rank_pt' => self::$TABLE_JCX156_GRADE2,
			'run_pt' => self::RUN_PT_JCX156_GRACE2,
		);
		
		// TODO: グレード無いなら警告が表示されるように
		
		if (empty($set[$grade])) {
			$this->log('指定グレード[' . $grade . ']のポイント設定がありません。', LOG_ERR);
			return null;
		}
		
		$pointMap = array();
		
		$rankIndex = $result['rank'] - 1;
		if (!empty($set[$grade]['rank_pt'][$rankIndex])) {
			$pointMap['point'] = $set[$grade]['rank_pt'][$rankIndex];
		} else if (!empty($set[$grade]['run_pt'])) {
			$pointMap['point'] = $set[$grade]['run_pt'];
		}
		
		//$this->log('result:', LOG_DEBUG);
		//$this->log($result, LOG_DEBUG);
		
		// 同一周回ならば +20pt
		if ($result['lap'] >= $raceLapCount && $result['status'] == RacerResultStatus::$FIN->val()) {
			$pointMap['bonus'] = $this->_isSeasonBefore1617($meetDate) ?
					self::JCX156_BONUS_TO156 : self::JCX156_BONUS_167TO; // 16-17 から 10pt に変更
		}

		return $pointMap;
	}
	
	/**
	 * 出走カテゴリーのトップの周回数をかえす
	 * @param EntryCategory-data $ecat 出走カテゴリー
	 * @return int 周回数。エラーがある場合 null をかえす。
	 */
	private function __pullTopLap($ecat) {
		if (empty($ecat)) return null;
		$this->log('ecat:', LOG_DEBUG);
		$this->log($ecat, LOG_DEBUG);
		
		$erModel = new EntryRacer();
		$erModel->actsAs = array('Utils.SoftDelete');
		$cdt = array('EntryRacer.entry_category_id' => $ecat['id'], 'RacerResult.rank' => 1);
		$resultLap = $erModel->find('first', array('conditions' => $cdt, 'fields' => 'RacerResult.lap'));
		
		//$this->log($eracers, LOG_DEBUG);
		
		if (empty($resultLap['RacerResult']['lap'])) return null;
		
		return $resultLap['RacerResult']['lap'];
	}
	
	/**
	 * 2015-16シーズンの関西クロスのポイントをかえす。配点は 15-16 の AJOCC ポイントと同じ。
	 */
	private function __calcKNS156($result, $grade, $raceLapCount, $raceStartedCount, $meetDate) {
		
		//$this->log('grade:' . $grade . ' result:', LOG_DEBUG);
		//$this->log($result, LOG_DEBUG);
		//$this->log('ecat', LOG_DEBUG);
		//$this->log($ecat, LOG_DEBUG);
		
		if (empty($result['rank'])) return null;
		
		$pointSet = array(
			'rank_pt' => self::$TABLE_KNS156,
			'run_pt' => self::RUN_PT_KNS156, // 順位付いたらもらえるポイント（51位以下）
		);
		
		$rankIndex = $result['rank'] - 1;
		
		$point = 0;
		if (isset($pointSet['rank_pt'][$rankIndex])) {
			$point = $pointSet['rank_pt'][$rankIndex];
		} else {
			$point = $pointSet['run_pt'];
		}
		
		$pointMap = array();
		$pointMap['point'] = $point;
		
		// 完走ボーナスは無し。20151120 by クマモトさん
		
		return $pointMap;
	}
	
	/**
	 * 2016-17 シーズンより前のシーズンであるかをかえす
	 * @param date $date 日付
	 * @return boolean 
	 */
	private function _isSeasonBefore1617($date)
	{
		if (empty($date)) {
			return false; // unlikely... 本メソッドを作成したのが1617なので巻き戻りはなしので false かえす。
		}
		
		return ($date < '2016-04-01');
	}
	
	/**
	 * 2016-17シーズンの茨城クロスのポイントをかえす。
	 */
	private function __calcIBRK167($result, $grade, $raceLapCount, $raceStartedCount, $meetDate)
	{
		$pointSet = array(
			'rank_pt' => self::$TABLE_IBRK167,
		);
		
		$point = 0;
		if (!empty($result['rank']))
		{
			$point = self::RUN_PT_IBRK167;
			$rankIndex = $result['rank'] - 1;

			if (isset($pointSet['rank_pt'][$rankIndex])) {
				$point = $pointSet['rank_pt'][$rankIndex];
			}
		} else {
			// 順位なしということは DNS, DNF, DSQ, LapOut, 80%Out
			// order_index で決定する
			if ($result['status'] != RacerResultStatus::$DSQ->val()) {
				$point = self::RUN_PT_IBRK167;
				$rankIndex = $result['order_index'] - 1;
				if (isset($pointSet['rank_pt'][$rankIndex])) {
					$point = $pointSet['rank_pt'][$rankIndex];
				}
			}
		}
		
		$pointMap = array();
		$pointMap['point'] = $point;
		
		// 完走ボーナスは無し。
		
		return $pointMap;
	}
	
	/**
	 * 2016-17シーズンの信州クロスのポイントをかえす。
	 */
	private function __calcCCM167($result, $grade, $raceLapCount, $raceStartedCount, $meetDate)
	{
		if (empty($result['rank'])) return null;
		
		$rankIndex = $result['rank'] - 1;
		$point = 0;
		
		foreach (self::$TABLE_CCM167 as $ccmTable) {
			if ($raceStartedCount > $ccmTable[self::__KEY_STARTED_OVER]) {
				if (isset($ccmTable[self::__KEY_TABLE][$rankIndex])) {
					$point = $ccmTable[self::__KEY_TABLE][$rankIndex];
				}
				break;
			}
		}
		
		if ($grade == 2) { // grade 2 は得点半分（小数点以下切り上げ 20160903指示あり by Togashi）
			$point = ceil($point / 2);
		}
		
		$pointMap = array();
		$pointMap['point'] = $point;
		
		// 完走ボーナスは無し。
		
		return $pointMap;
	}
	
	/**
	 * 2017-18シーズンの東海クロスのポイントをかえす。
	 */
	private function __calcTKI167($result, $grade, $raceLapCount, $raceStartedCount, $meetDate)
	{
		$pointSet = array(
			'rank_pt' => self::$TABLE_TKI178,
		);
		
		$point = 0;
		if (!empty($result['rank']))
		{
			$point = self::RUN_PT_TKI178;
			$rankIndex = $result['rank'] - 1;

			if (isset($pointSet['rank_pt'][$rankIndex])) {
				$point = $pointSet['rank_pt'][$rankIndex];
			}
		}
		
		$pointMap = array();
		$pointMap['point'] = $point;
		
		// 完走ボーナスは無し。
		
		return $pointMap;
	}
	
	/**
	 * 2017-18シーズンの関東地域のポイントをかえす。
	 */
	private function __calcKNT178($result, $grade, $raceLapCount, $raceStartedCount, $meetDate)
	{
		if (empty($result['rank'])) return null;
		
		$rankIndex = $result['rank'] - 1;
		$point = 0;
		
		foreach (self::$TABLE_KNT178 as $ptTable) {
			if ($raceStartedCount > $ptTable[self::__KEY_STARTED_OVER]) {
				if (isset($ptTable[self::__KEY_TABLE][$rankIndex])) {
					$point = $ptTable[self::__KEY_TABLE][$rankIndex];
				}
				break;
			}
		}
		
		$pointMap = array();
		$pointMap['point'] = $point;
		
		// 完走ボーナスは無し。
		
		return $pointMap;
	}
	
	/**
	 * 2017-18シーズンの東北 CX のポイントをかえす。
	 */
	private function __calcTHK178($result, $grade, $raceLapCount, $raceStartedCount, $meetDate)
	{
		$pointSet = array(
			'rank_pt' => self::$TABLE_THK178,
		);
		
		$point = 0;
		if (!empty($result['rank']))
		{
			$rankIndex = $result['rank'] - 1;

			if (isset($pointSet['rank_pt'][$rankIndex])) {
				$point = $pointSet['rank_pt'][$rankIndex];
			}
		}
		
		$pointMap = array();
		$pointMap['point'] = $point;
		
		// 完走ボーナスは無し。
		
		return $pointMap;
	}
	
	/**
	 * 2020-21シーズンに設定された JCX ポイントをかえす。
	 */
	private function __calcJCX201($result, $grade, $raceLapCount, $raceStartedCount, $meetDate)
	{
		//$this->log('grade:' . $grade . ' result:', LOG_DEBUG);
		//$this->log($result, LOG_DEBUG);
		//$this->log('ecat', LOG_DEBUG);
		//$this->log($ecat, LOG_DEBUG);
		
		if ($meetDate < '2020-04-01') {
			return $this->__calcJCXElite156($result, $grade, $raceLapCount, $raceStartedCount, $meetDate);
		}
		
		if (empty($result['rank'])) return null;
		
		// grade -> points
		$set = array();
		$set[1] = array(
			'rank_pt' => self::$TABLE_JCX201_GRADE1,
			'run_pt' => self::RUN_PT_JCX201_GRADE1,
		);
		$set[2] = array(
			'rank_pt' => self::$TABLE_JCX201_GRADE2,
			'run_pt' => self::RUN_PT_JCX201_GRADE2,
		);
		
		// TODO: グレード無いなら警告が表示されるように
		
		if (empty($set[$grade])) {
			$this->log('指定グレード[' . $grade . ']のポイント設定がありません。', LOG_ERR);
			return null;
		}
		
		$pointMap = array();
		
		$rankIndex = $result['rank'] - 1;
		if (!empty($set[$grade]['rank_pt'][$rankIndex])) {
			$pointMap['point'] = $set[$grade]['rank_pt'][$rankIndex];
		} else if (!empty($set[$grade]['run_pt'])) {
			$pointMap['point'] = $set[$grade]['run_pt'];
		}
		
		//$this->log('result:', LOG_DEBUG);
		//$this->log($result, LOG_DEBUG);

		return $pointMap;
	}
	
	/**
	 * 2022-23 シリーズの東北クロスのポイントをかえす。
	 */
	private function __calcTCX223($result, $grade, $raceLapCount, $raceStartedCount, $meetDate)
	{
		if (empty($result['rank'])) return null;
		
		$rankIndex = $result['rank'] - 1;
		$point = 1; // どのテーブルのどの順位でも最低値の 1pt が入る。
		
		foreach (self::$TABLE_TCX223 as $table) {
			if ($raceStartedCount > $table[self::__KEY_STARTED_OVER]) {
				if (isset($table[self::__KEY_TABLE][$rankIndex])) {
					$point = $table[self::__KEY_TABLE][$rankIndex];
				}
				break;
			}
		}
		
		$pointMap = array();
		$pointMap['point'] = $point;
		
		// 完走ボーナスは無し。
		
		return $pointMap;
	}

	/**
	 * 2023-24シーズンに設定された JCX ポイントをかえす。
	 */
	private function __calcJCX234($result, $grade, $raceLapCount, $raceStartedCount, $meetDate)
	{
		//$this->log('grade:' . $grade . ' result:', LOG_DEBUG);
		//$this->log($result, LOG_DEBUG);
		//$this->log('ecat', LOG_DEBUG);
		//$this->log($ecat, LOG_DEBUG);
		
		if (empty($result['rank'])) return null;
		
		// grade -> points
		$set = array();
		$set[1] = array(
			'rank_pt' => self::$TABLE_JCX234_GRADE1,
			'run_pt' => self::RUN_PT_JCX234,
		);
		$set[2] = array(
			'rank_pt' => self::$TABLE_JCX234_GRADE2,
			'run_pt' => self::RUN_PT_JCX234,
		);
		
		// TODO: グレード無いなら警告が表示されるように
		
		if (empty($set[$grade])) {
			$this->log('指定グレード[' . $grade . ']のポイント設定がありません。', LOG_ERR);
			return null;
		}
		
		$pointMap = array();
		
		$rankIndex = $result['rank'] - 1;
		if (!empty($set[$grade]['rank_pt'][$rankIndex])) {
			$pointMap['point'] = $set[$grade]['rank_pt'][$rankIndex];
		} else if (!empty($set[$grade]['run_pt'])) {
			$pointMap['point'] = $set[$grade]['run_pt'];
		}
		
		//$this->log('result:', LOG_DEBUG);
		//$this->log($result, LOG_DEBUG);

		return $pointMap;
	}
}
PointCalculator::init();
