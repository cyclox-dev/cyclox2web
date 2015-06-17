<?php
App::uses('AppController', 'Controller');
/**
 * CategoryRacers Controller
 *
 * @property CategoryRacer $CategoryRacer
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CategoryRacersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CategoryRacer->recursive = 0;
		$this->set('categoryRacers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CategoryRacer->exists($id)) {
			throw new NotFoundException(__('Invalid category racer'));
		}
		$options = array('conditions' => array('CategoryRacer.' . $this->CategoryRacer->primaryKey => $id));
		$this->set('categoryRacer', $this->CategoryRacer->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CategoryRacer->create();
			if ($this->CategoryRacer->save($this->request->data)) {
				$this->Session->setFlash(__('The category racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category racer could not be saved. Please, try again.'));
			}
		}
		$categories = $this->CategoryRacer->Category->find('list');
		$racers = $this->CategoryRacer->Racer->find('list');
		$this->set(compact('categories', 'racers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CategoryRacer->exists($id)) {
			throw new NotFoundException(__('Invalid category racer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CategoryRacer->save($this->request->data)) {
				$this->Session->setFlash(__('The category racer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The category racer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CategoryRacer.' . $this->CategoryRacer->primaryKey => $id));
			$this->request->data = $this->CategoryRacer->find('first', $options);
		}
		$categories = $this->CategoryRacer->Category->find('list');
		$racers = $this->CategoryRacer->Racer->find('list');
		$this->set(compact('categories', 'racers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) 
	{
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		
		if (!$id) {
			throw new NotFoundException(__('Invalid category_racer'));
		}
		
		$meet = $this->CategoryRacer->findById($id);
		if (!$meet) {
			throw new NotFoundException(__('Invalid category_racer'));
		}
		
		$this->CategoryRacer->set('id', $id);
		
		$ret = $this->CategoryRacer->saveField('deleted', date('Y-m-d H:i:s'));
		if (is_array($ret)) {
			$this->Session->setFlash(__('選手カテゴリー所属情報を削除しました。'));
		} else {
			$this->Session->setFlash(__('削除に失敗しました。'));
		}
		
		return $this->redirect(array('action' => 'index'));
	}
}
