<?php

/*
 *  created at 2015/08/26 by shun
 */

/**
 * Description of PermissionHelper
 *
 * @author shun
 */
class PermissionHelper extends AppHelper
{
	public $helpers = array('Session');

	public function check($path)
	{
		if (!is_array($path)) {
			$path = Router::parse($path);
		}
		if (empty($path['controller'])) {
			$path['controller'] = $this->request->params['controller'];
		}
		if (empty($path['action'])) {
			$path['action'] = 'index';
		}

		if (!empty($path['prefix']) && $path['prefix'] == 'admin') {
			return true;
		}

		$this->log('path', LOG_DEBUG);
		$this->log($path, LOG_DEBUG);
		
		$key = 'Auth.Permissions.' . Inflector::camelize($path['controller']) . '.' . $path['action'];
		$this->log('key is:' . $key, LOG_DEBUG);
		$this->log('val is:' . $this->Session->read($key) . ' is_null:' . is_null($this->Session->read($key)), LOG_DEBUG);
		if ($this->Session->check($key))
		{
			$ret = ($this->Session->read($key) === true);
			$this->log('ret:' . $ret, LOG_DEBUG);
			return $ret;
		}

		$allkey = 'Auth.Permissions.controllers';
		if ($this->Session->check($allkey) && $this->Session->read($allkey) === true) {
			$this->log(':all key permissed', LOG_DEBUG);
			return true;
		}

		return false;
	}

}
