<?php

App::uses('AppModel', 'Model');

/*
 *  created at 2015/08/02 by shun
 */

/**
 * Description of TransactionManager
 *
 * @author shun
 */

class TransactionManager extends AppModel {
    
	public $useTable = false;
	
    public function begin() {
        $dataSource = $this->getDataSource();
        $dataSource->begin($this);
        return $dataSource;
    } 

    public function commit($_dataSource) {
        $_dataSource->commit();
    }

    public function rollback($_dataSource) {
        $_dataSource->rollback();
    }

}