<?php

/*
 *  created at 2015/08/31 by shun
 */

App::uses('ExceptionRenderer', 'Error');
//App::uses('ApiException', 'Error');

/**
 * 主に .json 形式でのエラーを表示するための renderer
 *
 * @author shun
 */
class AppExceptionRenderer extends ExceptionRenderer
{
    public function __construct(Exception $exception)
	{
        parent::__construct($exception);
        
        //if ($exception instanceof ApiException) {
            $this->method = 'errorApi';
        //}
    }

    public function errorApi($error)
	{
        $message = $error->getMessage();
		
		// 500 を返すと通信自体が失敗となり、エラー内容が表示できないので常に 200 をかえす。
		//$this->controller->response->statusCode($error->getCode());
		$this->controller->response->statusCode(200);
		
		$meta = array(
			'url' => $this->controller->request->here,
			'method' => $this->controller->request->method(),
		);
		$obj = array(
			'meta' => $meta,
			'error' => array(
				'message' => $message,
				'code' => 400,
			),
			'error_exception' => get_class($error),
			'_serialize' => array('meta', 'error', 'error_exception')
		);

		$this->controller->set($obj);
		
        $this->_outputMessage('errorApi'); 
    }
}
