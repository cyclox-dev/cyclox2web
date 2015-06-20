<?php

App::uses('AppController', 'Controller');

App::uses('Util', 'Cyclox/Util');


/*
 *  created at 2015/06/19 by shun
 */

/**
 * API 入出力のみを扱うコントローラクラス
 *
 * @author shun
 */
class ApiController extends AppController
{
	public $uses = array('Meet');
	
	public $components = array('Session', 'RequestHandler');
	
	const STATUS_CODE_BAD_REQUEST = 400;
 
    // JSONやXMLにして返す値を格納するための配列です。
    protected $result = array();
	
	/**
	 * 更新情報についての ID, code などのリストを取得する。
	 * @param date $date 最後の更新ダウンロード日時
	 */
	public function update_list($date = null)
	{
		// http://ajocc.net/api/update_list/2015-12-31.json
		
		if ($date) {
			if (Util::is_date($date)) {
				$opt = array('conditions' => array('modified >' => $date));
				$meets = $this->Meet->find('list', $opt);
			} else {
				return $this->error('パラメタには日付を指定して下さい。', self::STATUS_CODE_BAD_REQUEST);
			}
		} else {
			$opt = array('fields' => array('name'));
			$meets = $this->Meet->find('list', $opt);
		}
		
		return $this->success(array('meets', $meets));
	}
	
	 
	//++++++++++++++++++++++++++++++++++++++++
	// 以下、http://be-hase.com/php/478/ より拾いもの。
	
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
    }
	
	
}
