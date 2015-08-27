<?php

/*
 *  created at 2015/08/26 by shun
 */

App::uses('FormHelper', 'View/Helper');

/**
 * Description of PermFormHelper
 *
 * @author shun
 */
class PermFormHelper extends FormHelper
{
	public $helpers = array('Permission', 'Html');
	
	public function postLink($title, $url = null, $options = array(), $confirmMessage = false)
	{
		$url = ($url !== null) ? $url : $title;
		
		//$this->log('checks', LOG_DEBUG);
		//$this->log($url, LOG_DEBUG);

		if ($this->Permission->check($url)) {
			return parent::postLink($title, $url, $options, $confirmMessage);
		}
		return null;
	}
}
