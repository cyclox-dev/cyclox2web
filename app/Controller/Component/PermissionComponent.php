<?php

/*
 *  created at 2015/08/26 by shun
 */

/**
 * Description of PermissionComponent
 *
 * @author shun
 */
class PermissionComponent extends Component
{
	public $components = array('Session', 'Auth', 'Acl');
	private $C = null;

	public function startup(Controller $controller)
	{
		$this->C = &$controller;
	}

	public function init()
	{
		$this->clear();

		$aro = $this->Acl->Aro->find('first', array(
			'conditions' => array(
				'Aro.model' => 'Group',
				'Aro.foreign_key' => $this->Auth->user('group_id'),
			),
		));

		$permissions = $this->Acl->Aro->Permission->find('all', array(
			'conditions' => array(
				'Permission.aro_id' => $aro['Aro']['id'],
			),
		));

		foreach ($permissions as $p) {
			if ($p['Permission']['_create'] == 1 && $p['Permission']['_read'] == 1 &&
				$p['Permission']['_update'] == 1 && $p['Permission']['_delete'] == 1) {
				$allow = true;
			} else {
				$allow = false;
			}

			if (!empty($p['Aco']['alias']) && $p['Aco']['alias'] == 'controllers') {
				$this->Session->write('Auth.Permissions.controllers', $allow);
			} elseif (!empty($p['Aco']['parent_id'])) {
				$parent = $this->Acl->Aco->findById($p['Aco']['parent_id']);
				$key = 'Auth.Permissions.' . $parent['Aco']['alias'] . '.' . $p['Aco']['alias'];
				$this->Session->write($key, $allow);
			}
		}
		
		$this->log('session:', LOG_DEBUG);
		$this->log($this->Session->read('Auth.Permissions'), LOG_DEBUG);

	}

	public function clear()
	{
		$this->Session->delete('Auth.Permissions');
	}

}
