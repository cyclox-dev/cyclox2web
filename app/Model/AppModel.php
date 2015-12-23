<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model
{
	/**
	 * 直前に保存した id のリスト
	 * @var type 
	 */
	private $__idList = array();
	
	/**
	 * soft delete のためのオーバライド。ref: https://github.com/CakeDC/utils
	 * @param type $id
	 * @return type
	 */
	public function exists($id = null) {
		if ($this->Behaviors->attached('SoftDelete')) {
			return $this->existsAndNotDeleted($id);
		} else {
			return parent::exists($id);
		}
	}
	
	/**
	 * soft delete のためのオーバライド。ref: https://github.com/CakeDC/utils
	 * @param type $id
	 * @param type $cascade
	 * @return type
	 */
	public function delete($id = null, $cascade = true) {
		$result = parent::delete($id, $cascade);
		if ($result === false && $this->Behaviors->enabled('SoftDelete')) {
		   return (bool)$this->field('deleted', array('deleted' => 1));
		}
		return $result;
	}
	
	/**
	 * deleted flag を考慮しない DB 上に存在しているかをかえす。
	 * @param type $id
	 * @return type
	 */
	public function existsOnDB($id = null) {
		return parent::exists($id);
	}
	
	// override
	function afterSave($created, $options = array())
	{
		$this->__idList[] = $this->getID();
		
		return parent::afterSave($created, $options);
	}
	
	/**
	 * 直前に更新したオブジェクトの ID の配列をかえす
	 * @return Array ID 配列
	 */
	public function getUpdatedIdList()
	{
		return $this->__idList;
	}
}
