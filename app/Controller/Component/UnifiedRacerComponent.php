<?php

/*
 *  created at 2016/02/27 by shun
 */

App::uses('Component', 'Controller');
App::uses('Racer', 'Model');

/**
 * Description of UnifiedRacerComponent
 *
 * @author shun
 */
class UnifiedRacerComponent extends Component
{
	private $Racer;
	
	/**
	 * 新の（統合先の）選手コードをかえす
	 * @param string $code 選手ジード
	 * @return string 選手コード。無効な場合など null をかえす。
	 */
	public function trueRacerCode($code)
	{
		if (empty($code)) {
			return null;
		}
		
		$this->Racer = new Racer();
		
		$opt = array(
			'conditions' => array('code' => $code),
			'recursive' => -1
		);
		
		$racer = $this->Racer->find('first', $opt);
		
		if (isset($racer['Racer']['united_to'])) {
			return $racer['Racer']['united_to'];
		}
		
		return null;
	}
}
