<?php

/*
 *  created at 2015/08/31 by shun
 */

App::uses('ExceptionRenderer', 'Error');
//App::uses('ApiException', 'Error');

/**
 * Description of AppExceptionRenderer
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
        
        $this->controller->response->statusCode($error->getCode());
        $meta = array(
            'url' => $this->controller->request->here,
            'method' => $this->controller->request->method(),
        );
        $this->controller->set(array(
            'meta' => $meta,
            'error' => array(
                'message' => $message,
                'code' => 400,
            ),
            'error_exception' => $error,
            '_serialize' => array('meta', 'error')
        ));

        $this->_outputMessage('errorApi'); 
    }
}
