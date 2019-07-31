<?php

/* 
 *  created at 2015/06/12 by shun
 */

/**
 * 選手レース結果ステータス
 */
class RacerResultStatus
{
	public static $DNS;
    public static $FIN;
    public static $DNF;
    public static $DSQ;
    public static $LAPOUT;
    public static $LAPOUT80;
	
	private static $statuses;
	
	public static function statuses()
	{
		return self::$statuses;
	}
	
	public static function init()
	{
		self::$DNS = new RacerResultStatus(0, '出走せず', 'DNS', 0, false, array());
		self::$FIN = new RacerResultStatus(1, 'ゴール到達', 'FIN', 100, true, array());
		self::$DNF = new RacerResultStatus(2, 'ゴールできず', 'DNF', 30, false, array());
		self::$DSQ = new RacerResultStatus(3, '失格(除外)', 'DSQ', 10, false, array());
		self::$LAPOUT = new RacerResultStatus(4, '周回遅れラップアウト', 'DNF(Lap-Out)', 60, true, array('lapout', 'lap-out', 'lapped'));
		self::$LAPOUT80 = new RacerResultStatus(5, '80%ラップアウト適用', 'DNF(80%Out)', 65, true, array('80%out', '80%-out', '80%lapout'));
		
		self::$statuses = array(
			self::$DNS,
			self::$FIN,
			self::$DNF,
			self::$DSQ,
			self::$LAPOUT,
			self::$LAPOUT80
		);
	}
	
	private $val;
	private $msg;
	private $code;
	private $rank;
	private $isRankedStatus;
	private $otherNames;
	
	private function __construct($v, $m, $c, $l, $is, $os)
	{
		$this->val = $v;
		$this->msg = $m;
		$this->code = $c;
		$this->rank = $l;
		$this->isRankedStatus = $is;
		$this->otherNames = $os;
	}
	
	/**
	 * 指定値の RacerResultStatus インスタンスを取得する
	 * @param int $value 整数値
	 * @return RacerResultStatus RacerResultStatus インスタンス。該当するものがない場合、DNS をかえす。
	 */
	public static function ofVal($value) {
		foreach (self::$statuses as $status) {
			if ($status->val() == $value) {
				return $status;
			}
		}
		 return self::$DNS;
	}
	
	/**
	 * 指定表現の RacerResultStatus インスタンスをかえす
	 * @param string $ex 表現値
	 * @param object $retAsNone 見つからなかったときにかえす値
	 * @return RacerResultStatus RacerResultStatus インスタンス。該当するものがない場合、$retAsNone をかえす。
	 */
	public static function ofExpress($ex, $retAsNone)
	{
		$lowered = strtolower($ex);
		
		foreach (self::$statuses as $st) {
			if (strtolower($st->code()) === $lowered) {
				return $st;
			}
			
			foreach ($st->otherNames() as $ons) {
				if (strtolower($ons) === $lowered) {
					return $st;
				}
			}
		}
		
		 return $retAsNone;
	}
	
	/** @return int DB 値 */                                                                           
    public function val() { return $this->val; }
    /** @return string 文字列表現 */                                                                    
    public function express() { return $this->msg; }
    /** @return string コード */
    public function code() { return $this->code; }
    /** @return int ステータス自体の順位 */
    public function rank() { return $this->rank; }
    /** @return boolean 順位適用となるステータスであるか */
    public function isRankedStatus() { return $this->isRankedStatus; }
	/** @return array 別名 */
	public function otherNames() { return $this->otherNames; }
}
RacerResultStatus::init();
