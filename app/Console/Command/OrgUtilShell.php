<?php

/*
 *  created at 2015/10/30 by shun
 */

App::uses('OrgUtilController', 'Controller');

/**
 * Description of OrgUtilShell
 *
 * @author shun
 */
class OrgUtilShell extends AppShell
{
	public function startup()
	{
		parent::startup();
		$this->OrgUtilController = new OrgUtilController();
	}
	
	public function create_racer_lists()
	{
		$this->OrgUtilController->create_racer_lists();
	}
}
