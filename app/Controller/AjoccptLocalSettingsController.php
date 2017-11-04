<?php
App::uses('AppController', 'Controller');
/**
 * AjoccptLocalSettings Controller
 *
 * @property AjoccptLocalSetting $AjoccptLocalSetting
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class AjoccptLocalSettingsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->AjoccptLocalSetting->recursive = 0;
		$this->set('ajoccptLocalSettings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->AjoccptLocalSetting->exists($id)) {
			throw new NotFoundException(__('Invalid ajoccpt local setting'));
		}
		$options = array('conditions' => array('AjoccptLocalSetting.' . $this->AjoccptLocalSetting->primaryKey => $id));
		$this->set('ajoccptLocalSetting', $this->AjoccptLocalSetting->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AjoccptLocalSetting->create();
			if ($this->AjoccptLocalSetting->save($this->request->data)) {
				$this->Flash->set(__('The ajoccpt local setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The ajoccpt local setting could not be saved. Please, try again.'));
			}
		}
		$seasons = $this->AjoccptLocalSetting->Season->find('list');
		$this->set(compact('seasons'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->AjoccptLocalSetting->exists($id)) {
			throw new NotFoundException(__('Invalid ajoccpt local setting'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->AjoccptLocalSetting->save($this->request->data)) {
				$this->Flash->set(__('The ajoccpt local setting has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->set(__('The ajoccpt local setting could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('AjoccptLocalSetting.' . $this->AjoccptLocalSetting->primaryKey => $id));
			$this->request->data = $this->AjoccptLocalSetting->find('first', $options);
		}
		$seasons = $this->AjoccptLocalSetting->Season->find('list');
		$this->set(compact('seasons'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->AjoccptLocalSetting->id = $id;
		if (!$this->AjoccptLocalSetting->exists()) {
			throw new NotFoundException(__('Invalid ajoccpt local setting'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->AjoccptLocalSetting->delete()) {
			$this->Flash->set(__('The ajoccpt local setting has been deleted.'));
		} else {
			$this->Flash->set(__('The ajoccpt local setting could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
