<?php

/*
 *  created at 2016/08/10 by shun
 */
App::uses('Component', 'Controller');
App::uses('Gender', 'Cyclox/Const');
App::uses('CategoryReason', 'Cyclox/Const');
App::uses('TransactionManager', 'Model');
App::uses('Racer', 'Model');
App::uses('CategoryRacer', 'Model');
App::uses('Category', 'Model');

/**
 * Description of AgedCategoryComponent
 *
 * @author shun
 */
class AgedCategoryComponent  extends Component
{
	private $Racer;
	private $CategoryRacer;
	private $Category;
	
	private $agedCats = null;
	
	/**
	 * 適正な aged category を付与する。不要な aged category については削除する。
	 * @param type $racerCode 選手コード
	 * @param date $date 付与基準日。この日以降に必要なカテゴリーのみを付与する。null の場合、現在日時となる。
	 * @param boolean $usesTransaction トランザクションを使用するか
	 * @return boolean ただしくチェックできたか
	 */
	public function checkAgedCategory($racerCode, $date = null, $usesTransaction = true)
	{
		$this->__setupParams();
		
		$putsLog = false;
		
		if (empty($racerCode)) {
			$this->log('選手コードを指定して下さい。', LOG_ERR);
			return false;
		}
		
		$baseDate = (empty($date)) ? date('Y-m-d') : $date;
		
		$racer = $this->Racer->find('first', array('conditions' => array('code' => $racerCode), 'recursive' => 2));
		if (empty($racer)) {
			$this->log('選手 code=' . $racerCode . ' の選手が見つかりません');
			return false;
		}
		
		$birth = $racer['Racer']['birth_date'];
		
		if (empty($birth)) {
			$this->log('選手 code=' . $racerCode . ' の選手について、生年月日が未設定です。skip します。', LOG_INFO);
			return true;
		}
		
		// >>> Transaction
		if ($usesTransaction) {
			$TransactionManager = new TransactionManager();
			$transaction = $TransactionManager->begin();
		}
		
		$deleteCrIds = array();
		foreach ($racer['CategoryRacer'] as $cr) {
			if (!empty($cr['Category']['is_aged_category'])) {
				$deleteCrIds[] = $cr['id'];
			}
		}
		
		foreach ($this->agedCats as $agedCat) {
			
			$gen = $agedCat['Category']['gender'];
			if ($gen != Gender::$UNASSIGNED->val()) {
				if ($racer['Racer']['gender'] != $gen) {
					continue;
				}
			}
			
			// 付与基準日から考えてその agedCat を与える必要があるかを判断
			$applyDate = $this->__getMinAgedDate($agedCat, $birth);
			$cancelDate = $this->__getMaxAgeDate($agedCat, $birth);
			
			if ($putsLog) $this->log('cat:' . $agedCat['Category']['code'] . ' ' . $applyDate . ' to ' . $cancelDate, LOG_DEBUG);
			
			if ($cancelDate != null && $cancelDate < $baseDate) {
				// 付与必要なし
				//if ($putsLog) $this->log('not need(over period)', LOG_DEBUG);
				continue;
			}
			
			$findsCr = false;
			
			if (!empty($racer['CategoryRacer'])) {
				foreach ($racer['CategoryRacer'] as $cr) {
					if ($cr['deleted']) continue;
					
					if ($cr['category_code'] == $agedCat['Category']['code'])
					{
						if ($cr['apply_date'] == $applyDate && $cr['cancel_date'] == $cancelDate) {
							if ($findsCr) {
								if ($putsLog) $this->log('cat:' . $cr['id'] . '/' . $cr['category_code'] . ' will be delete(duplicated).', LOG_INFO);
							} else {
								if ($putsLog) $this->log('FINDS cat:' . $cr['id'] . '/' . $cr['category_code'], LOG_INFO);
								$findsCr = true;
								
								// 削除 Cr.id リスト($deleteCrIds) から除外する
								$delIndex = -1;
								$index = 0;
								foreach ($deleteCrIds as $crid) {
									if ($crid == $cr['id']) {
										$delIndex = $index;
										break;
									}
									++$index;
								}
								array_splice($deleteCrIds, $delIndex, 1);
							}
						} else {
							if ($putsLog) $this->log('cat:' . $cr['id'] . '/' . $cr['category_code'] . ' will be delete.', LOG_INFO);
							// 不適な日にち指定のものは削除してしまう。
						}
					}
				}
			}
			
			if (!$findsCr) {
				if ($putsLog) $this->log('not find and will create.', LOG_INFO);
				
				// 新規に付与する必要あり
				$newCr = array('CategoryRacer' => array(
					'racer_code' => $racerCode,
					'category_code' => $agedCat['Category']['code'],
					'apply_date' => $applyDate,
					'cancel_date' => $cancelDate,
					'reason_id' => CategoryReason::$FIRST_REGIST->ID(),
					'reason_note' => '年少者カテゴリー自動付与'
				));
				
				$this->CategoryRacer->create();
				if (!$this->CategoryRacer->save($newCr)) {
					if ($usesTransaction) $TransactionManager->rollback($transaction);
					$this->log('カテゴリー所属の保存に失敗しました。', LOG_ERR);
					return false;
				}
			}
		}
		
		// 不要なカテゴリー所属を削除
		$ret = $this->__deleteCategories($deleteCrIds);
		if (!$ret) {
			if ($usesTransaction) $TransactionManager->rollback($transaction);
			$this->log('カテゴリー所属のチェックと修正に失敗しました。', LOG_ERR);
		} else {
			if ($usesTransaction) $TransactionManager->commit($transaction);
		}
		// <<< Transaction
		
		return $ret;
	}
	
	/**
	 * 指定された id をもつカテゴリー所属を削除する。
	 * @param array $deleteIds int 型を格納する配列 not null
	 * @return boolean 成功ステータス
	 */
	private function __deleteCategories($deleteIds)
	{
		if (!is_array($deleteIds)) {
			$this->log('__deleteCategories() の引数が無効です。', LOG_ERR);
			return false;
		}
		
		if (empty($deleteIds)) {
			// ログ無し。
			return true;
		}
		
		foreach ($deleteIds as $did) {
			if (!$this->CategoryRacer->delete($did)) { // soft.delete 適用のために deleteAll() は使用しない
				$this->log('カテゴリー所属[id:' . $did .']の削除に失敗しました。', LOG_ERR);
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * カテゴリー開始のより遅い方を取得する
	 * @param type $agedCat カテゴリー
	 * @param type $birth 日付オブジェクト not empty
	 * @return string 日付
	 */
	private function __getMinAgedDate($agedCat, $birth)
	{
		$dateMin = null;
		if (!empty($agedCat['Category']['age_min'])) {
			$year = $this->__pullYear($birth) + $agedCat['Category']['age_min'] - 1;
			$dateMin = $year . '-04-01';
		}
		if (!empty($agedCat['Category']['school_year_min'])) {
			$year = $this->__pullFY($birth) + $agedCat['Category']['school_year_min'] + 1;
			$dt = $year . '-04-01';

			if ($dateMin == null || $dt > $dateMin) {
				$dateMin = $dt;
			}
		}
		
		return $dateMin;
	}
	
	/**
	 * カテゴリー終了のより早い方を取得する
	 * @param type $agedCat カテゴリー
	 * @param type $birth 日付オブジェクト not empty
	 * @return string 日付
	 */
	private function __getMaxAgeDate($agedCat, $birth)
	{
		$dateMax = null;
		if (!empty($agedCat['Category']['age_max'])) {
			$year = $this->__pullYear($birth) + $agedCat['Category']['age_max'];
			$dateMax = $year . '-03-31';
		}
		if (!empty($agedCat['Category']['school_year_max'])) {
			$year = $this->__pullFY($birth) + $agedCat['Category']['school_year_max'] + 2;
			$dt = $year . '-03-31';

			if ($dateMax == null || $dt < $dateMax) {
				$dateMax = $dt;
			}
		}
		
		return $dateMax;
	}
	
	/**
	 * 日付から年数をかえす
	 * @param date $date 日付
	 * @return int 年数。$date が empty の場合 null をかえす。
	 */
	private function __pullYear($date)
	{
		if (empty($date)) {
			return null;
		}
		
		return date('Y', strtotime($date));
	}
	
	/**
	 * 年度の数をかえす。2015-1-6 ならば 2014 をかえす。
	 * @param date $date 日付
	 */
	private function __pullFY($date)
	{
		$m = date('m', strtotime($date));
		
		$year = $this->__pullYear($date);
		if ($m < 4) {
			--$year;
		}
		
		return $year;
	}
	
	/**
	 * 初期設定
	 */
	private function __setupParams()
	{
		if (!isset($this->Racer) || empty($this->Racer)) {
			$this->Racer = new Racer();
			$this->Racer->Behaviors->load('Utils.SoftDelete');
		}
		if (!isset($this->CategoryRacer) || empty($this->CategoryRacer)) {
			$this->CategoryRacer = new CategoryRacer();
			$this->CategoryRacer ->Behaviors->load('Utils.SoftDelete');
		}
		if (!isset($this->Category) || empty($this->Category)) {
			$this->Category = new Category();
			$this->Category->Behaviors->load('Utils.SoftDelete');
		}
		
		if (empty($this->agedCats))
		{
			$opt = array(
				'conditions' => array(
					'is_aged_category' => 1,
					// BETAG: 
					'NOT' => array(
						'code' => array('CChild1', 'CChild2', 'CY')
					),
				),
				'recursive' => -1
			);
			
			$this->agedCats = $this->Category->find('all', $opt);
			
			//$this->log('aged cat:', LOG_DEBUG);
			//$this->log($this->agedCats, LOG_DEBUG);
		}
	}
}
