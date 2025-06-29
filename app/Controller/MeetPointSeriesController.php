<?php
App::uses('AppController', 'Controller');
/**
 * MeetPointSeries Controller
 *
 * @property MeetPointSeries $MeetPointSeries
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class MeetPointSeriesController extends AppController
{
	public $uses = array('MeetPointSeries', 'Meet', 'MeetGroup');

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->MeetPointSeries->recursive = 0;
		$this->set('meetPointSeries', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MeetPointSeries->exists($id)) {
			throw new NotFoundException(__('Invalid meet point series'));
		}
		$options = array('conditions' => array('MeetPointSeries.' . $this->MeetPointSeries->primaryKey => $id));
		$this->set('meetPointSeries', $this->MeetPointSeries->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($pointSeriesId = null) {
		if ($this->request->is('post')) {
			$this->MeetPointSeries->create();
			if ($this->MeetPointSeries->save($this->request->data)) {
				$this->Flash->success(__('The meet point series has been saved.'));
				// シリーズにリダイレクト
				return $this->redirect('/point_series/view/' . $this->request->data['MeetPointSeries']['point_series_id']);
			} else {
				$this->Flash->set(__('The meet point series could not be saved. Please, try again.'));
			}
		}
		$pointSeries = $this->MeetPointSeries->PointSeries->find('list');
		
		$opt = array(
			'order' => array('code' => 'DESC'),
			'recursive'=> 0,
		);
		$mts = $this->Meet->find('list', $opt);
		$meets = array();
		foreach ($mts as $code => $name)
		{
			$meets[$code] = $code . ':' . $name;
		}
		
		$this->set(compact('pointSeries', 'meets'));
		
		if ($pointSeriesId != null) {
			$this->set('psid', $pointSeriesId);
		}
		
		$this->set('meetGroups', $this->MeetGroup->find('list'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->MeetPointSeries->exists($id)) {
			throw new NotFoundException(__('Invalid meet point series'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->MeetPointSeries->save($this->request->data)) {
				$this->Flash->success(__('The meet point series has been saved.'));
				return $this->redirect(array('action' => 'view', $id));
			} else {
				$this->Flash->set(__('The meet point series could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('MeetPointSeries.' . $this->MeetPointSeries->primaryKey => $id));
			$this->request->data = $this->MeetPointSeries->find('first', $options);
		}
		$pointSeries = $this->MeetPointSeries->PointSeries->find('list');
		
		$opt = array(
			'order' => array('code' => 'DESC'),
			'recursive'=> 0,
		);
		$mts = $this->Meet->find('list', $opt);
		$meets = array();
		foreach ($mts as $code => $name)
		{
			$meets[$code] = $code . ':' . $name;
		}
		
		$this->set(compact('pointSeries', 'meets'));
		$this->set('meetGroups', $this->MeetGroup->find('list'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->MeetPointSeries->id = $id;
		if (!$this->MeetPointSeries->exists()) {
			throw new NotFoundException(__('Invalid meet point series'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->MeetPointSeries->delete()) {
			$this->Flash->set(__('The meet point series has been deleted.'));
		} else {
			$this->Flash->set(__('The meet point series could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
