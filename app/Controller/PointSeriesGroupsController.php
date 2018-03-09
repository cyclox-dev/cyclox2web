<?php
App::uses('AppController', 'Controller');
/**
 * PointSeriesGroups Controller
 *
 * @property PointSeriesGroup $PointSeriesGroup
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class PointSeriesGroupsController extends AppController
{
	public $uses = array('PointSeriesGroup', 'MeetGroup');

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
		$this->PointSeriesGroup->recursive = 0;
		$this->set('pointSeriesGroups', $this->Paginator->paginate());
	}
	
	private $__priorityNote = 'この値は表示上の順位付けに使われます。以下の値を参考に設定してください。</br>UCI World Cup=100, 大陸ランキング=97, ヨーロッパTopシリーズ=95, UCI ランキング=90,</br>JCF National=70, JCXシリーズ=60, 広範囲ローカルシリーズ=50,</br>ローカル10大会程度=40, ローカル5大会程度=35, ローカル3大会以下=30';

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PointSeriesGroup->exists($id)) {
			throw new NotFoundException(__('Invalid point series group'));
		}
		$options = array('conditions' => array('PointSeriesGroup.' . $this->PointSeriesGroup->primaryKey => $id));
		$this->PointSeriesGroup->hasMany['PointSeries']['order'] = array('PointSeries.id' => 'DESC');
		$this->set('pointSeriesGroup', $this->PointSeriesGroup->find('first', $options));
		
		$this->loadModel('Season');
		$this->set('seasons', $this->Season->find('list'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PointSeriesGroup->create();
			if ($this->PointSeriesGroup->save($this->request->data)) {
				$this->Flash->success(__('The point series group has been saved.'));
				return $this->redirect(array('action' => 'view', $this->PointSeriesGroup->id));
			} else {
				$this->Flash->error(__('The point series group could not be saved. Please, try again.'));
			}
		}
		$this->set('priority_note', $this->__priorityNote);
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PointSeriesGroup->exists($id)) {
			throw new NotFoundException(__('Invalid point series group'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PointSeriesGroup->save($this->request->data)) {
				$this->Flash->success(__('The point series group has been saved.'));
				return $this->redirect(array('action' => 'view', $id));
			} else {
				$this->Flash->error(__('The point series group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('PointSeriesGroup.' . $this->PointSeriesGroup->primaryKey => $id));
			$this->request->data = $this->PointSeriesGroup->find('first', $options);
		}
		$this->set('priority_note', $this->__priorityNote);
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PointSeriesGroup->id = $id;
		if (!$this->PointSeriesGroup->exists()) {
			throw new NotFoundException(__('Invalid point series group'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->PointSeriesGroup->delete()) {
			$this->Flash->success(__('The point series group has been deleted.'));
		} else {
			$this->Flash->error(__('The point series group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
