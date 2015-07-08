<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    var $components = array(
		'DebugKit.Toolbar',
		'PageTitle',
		'Session',
		'Auth' => array(/*
			'loginRedirect' => array(
				'controller' => 'pages',
				'action' => 'display'
			),//*/
			'logoutRedirect' => array(
				'controller' => 'users',
				'action' => 'login',
			),
			'authenticate' => array(
                'Basic' => array(
					'passwordHasher' => 'Blowfish',
					//'fields' => array('username' => 'email'),
				)//*/
            ),
		)
	);

	/*
    public $helpers = array(
        'Session',
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
    );//*/
	
	function beforeFilter()
	{
		$this->set('auth', $this->Auth->user());
		$this->log('here is ' . $this->request->here());
		
		if ($this->_isApiCall()) {
			$this->log('is api call');
			$this->log($this->request->data);
			AuthComponent::$sessionKey = false;
		}
	}
	
	protected function _isApiCall()
	{
		return isset($this->request->params['ext']) && $this->request->params['ext'] === 'json';
	}
	
	public function beforeRender() 
	{
		parent::beforeRender();
		
		// ページタイトルの設定
		
		$param = null;
		if (!empty($this->request->params['pass'][0])) {
			$param = $this->request->params['pass'][0];
		}
		$this->set('title_for_layout', $this->PageTitle->getPageTitle($this->name, $this->action, $param));
	}
}
