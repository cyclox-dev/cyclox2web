<?php

App::uses('ApiBaseController', 'Controller');


/**
 * メンテナンス中の表示を行うコントローラ
 *
 * @author shun
 */
class MaintenanceController extends ApiBaseController
{
	//put your code here
	
	function beforeFilter()
	{
		parent::beforeFilter();
		
		$this->Auth->allow('index');
	}
	
	public function index()
	{
		
		// maintenance.json とはならないので以下無効なコード TODO: api call での対応
		if ($this->_isApiCall()) {
			return $this->error('現在メンテナンス中です。', self::STATUS_CODE_SERVICE_UNAVAILABEL);
		}
	}
}
