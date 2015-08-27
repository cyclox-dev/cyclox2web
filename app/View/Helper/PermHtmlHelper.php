<?php

/*
 *  created at 2015/08/26 by shun
 */

App::uses('HtmlHelper', 'View/Helper');

/**
 * Description of PermHtmlHelper
 *
 * @author shun
 */
class PermHtmlHelper extends HtmlHelper
{
	public $helpers = array('Permission');

	public function link($title, $url = null, $options = array(), $confirmMessage = false)
	{
		/* @20150826 以下削除。Delete が動かないため。
		$options = array_merge(array(
			'escape' => false,
			), $options);
		//*/
		$url = ($url !== null) ? $url : $title;
		
		//$this->log('checks', LOG_DEBUG);
		//$this->log($url, LOG_DEBUG);

		if ($this->Permission->check($url)) {
			return parent::link($title, $url, $options, $confirmMessage);
		}
		return null;
	}

}
