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
		'Acl',
		'Auth' => array(
			'authorize' => array('Actions' => array('actionPath' => 'controllers'), 'Controller')
		),
		'Maintenance.Maintenance' => array(
			'maintenanceUrl' => array(
                'controller' => 'maintenance',
                'action' => 'index'
            ),
			'allowedIp' => array('127.0.0.1'),
		)
	);

	/*
    public $helpers = array(
        'Session',
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
    );//*/

	public $helpers = array(
        'Session',
        'Html' => array('className' => 'PermHtml'),
        'Form' => array('className' => 'PermForm'),
    );//*/
	
	function beforeFilter()
	{
		$this->set('auth', $this->Auth->user());
		$this->log('here is ' . $this->request->here(), LOG_DEBUG);
		
		//$this->Auth->allow();
		
		// $components['Auth'] に設定すると API 通信時に html が飛んでしまうことがあるため、
		// URL から判定して認証設定を決める。
		
		if ($this->_isApiCall()) {
			//$this->log($this->request->data);
			
			Configure::write('Exception', array(
				'handler' => 'ErrorHandler::handleException',
				'renderer' => 'AppExceptionRenderer',
				'log' => true
			));
			App::import('Lib', 'Error/ApiException');
			App::import('Lib', 'Error/AppExceptionRenderer');

			//*
			AuthComponent::$sessionKey = false;// TODO: reload で再度要求されてない？
			
			$this->Auth->authenticate = array(
				'Basic' => array(
					'passwordHasher' => 'Blowfish',
					'fields' => array('username' => 'email'),
				)
			);//*/
		} else {
			// API 処理でフィルタされないように。
			$this->Auth->actionPath = 'controllers/';
			$this->Auth->authorize = 'Actions'; // TODO: 個別処理を考えたら Controller を追加すること。

			$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
			$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
			$this->Auth->loginRedirect = '/';

			$this->Auth->authenticate = array(
				'Form' => array(
					'passwordHasher' => 'Blowfish',
					'fields' => array('username' => 'email'),
				)
			);
		}
	}
	
	public function isAuthorized($user) {
		return true;
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
