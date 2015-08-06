<?php

App::uses('AppController', 'Controller');

/*
 *  created at 2015/06/23 by shun
 */

/**
 * API 出力を行うコントローラーの基底クラス
 *
 * @author shun
 */
class ApiBaseController extends AppController
{
	const STATUS_CODE_BAD_REQUEST = 400;
	const STATUS_CODE_METHOD_NOT_ALLOWED = 405;
	const STATUS_CODE_WERVICE_UNAVAILABEL = 503;
	
	protected function _isApiCall()
	{
		return isset($this->request->params['ext']) && $this->request->params['ext'] === 'json';
	}
	
	// TODO: Exception 対策
	
	//++++++++++++++++++++++++++++++++++++++++
	// 以下、http://be-hase.com/php/478/ より拾いもの。
	
	// JSONやXMLにして返す値を格納するための配列です。
    protected $result = array();
	
	public function beforeFilter() 
	{
        parent::beforeFilter();

        // Ajaxでないアクセスは禁止。直アクセスを許すとXSSとか起きかねないので。
        //if (!$this->request->is('ajax')) throw new BadRequestException('アクセスが許可されていません。');
		// TODO: 必要ならばコメント外すこと。

        //meta情報とかを返すといいですね。とりあえずいまアクセスしているurlとhttp methodでも含めておきましょう
        $this->result['meta'] = array(
            'url' => $this->request->here,
            'method' => $this->request->method(),
        );
		$this->set('meta', $this->result['meta']);
		
        // nosniffつけるべし。じゃないとIEでXSS起きる可能性あり。
        $this->response->header('X-Content-Type-Options', 'nosniff');
    }
	
    // 成功系処理。$this->resultに値いれる
    protected function success($response = array()) 
	{
        $this->result['response'] = $response;
 
        $this->set('meta', $this->result['meta']);
        $this->set('response', $this->result['response']);
		
		$this->render('/Api/json/default');
    }
 
    // エラー系処理。$this->resultに値いれる
    protected function error($message = '', $code = 0) 
	{
        $this->result['error']['message'] = $message;
        $this->result['error']['code'] = $code;
 
        //ちゃんと400ステータスコードにするの大事。後述
        
		$this->set('error', $this->result['error']);
		$this->response->statusCode(400);
        //$this->set('_serialize', array('meta', 'error'));
		
		$this->render('/Api/json/default');
    }
 
    // バリデーションエラー系処理。$this->resultに値いれる
    protected function validationError($modelName, $validationError = array())
		{
        $this->result['error']['message'] = 'Validation Error';
        $this->result['error']['code'] = '422'; //エラーコードはプロジェクトごとに定義すべし
        $this->result['error']['validation'][$modelName] = array();
        foreach ($validationError as $key => $value) {
            $this->result['error']['validation'][$modelName][$key] = $value[0];
        }
 
        //ちゃんと400ステータスコードにするの大事。後述
        $this->response->statusCode(400);
        $this->set('meta', $this->result['meta']);
        $this->set('error', $this->result['error']);
        $this->set('_serialize', array('meta', 'error'));
		
		$this->render('/Api/json/default');
    }
}
