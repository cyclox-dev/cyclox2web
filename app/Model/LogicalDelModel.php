<?php

App::uses('AppModel', 'Model');

/*
 *  created at 2015/07/01 by shun
 */

/**
 * Description of LogicalDelModel
 *
 * @author shun
 */
class LogicalDelModel extends AppModel
{
	// 使ってません。find() 全部通せると思ったけどアソシエーション取得にはかかわらずで微妙。
	/**
	 * Model.find() の override。deleted を除外する機能を持つ。
	 * @param type string $type Type of find operation (all / first / count / neighbors / list / threaded)
	 * @param array $query Option fields (conditions / fields / joins / limit / offset / order / page / group / callbacks)
	 * @param boolean deleted を除外するか
	 * @return array|null Array of records, or Null on failure.
	 */
	public function xxx_find($type = 'first', $query = array(), $excludeDeleted = true)
	{
		if ($excludeDeleted) {
			if (!$query) {
				$query = array();
			}

			$hasConditions = false;
			if (!empty($query)) {
				if (array_key_exists('conditios', $query) && !empty($query['conditions'])) {
					$query['conditions'][$this->name . 'deleted'] = null;
					$hasConditions = true;
				}
			}

			if (!$hasConditions) {
				$query['conditions'] = array($this->name . '.deleted' => null);
			}
		}
		
		return parent::find($type, $query);
	}
	
	/**
	* 論理削除を行う。Model->id が設定されていること。
	*
	* @return bool True on success
	* @link http://book.cakephp.org/2.0/en/models/deleting-data.html
	*/
	public function logicalDelete()
	{
		if (!$this->exists($this->id)) {
			throw new NotFoundException(__('Invalid object'));
		}
		
		$this->set($this->primaryKey, $this->id);
		$ret = $this->saveField('deleted', date('Y-m-d H:i:s'));
		
		return is_array($ret);
	}
}
