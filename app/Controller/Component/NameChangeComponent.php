<?php

/*
 *  created at 2018/12/03 by shun
 */

App::uses('Component', 'Controller');
App::uses('MailReporter', 'Cyclox/Util');
App::uses('NameChangeLog', 'Model');

/**
 * Description of NameChangeLogComponent
 *
 * @author shun
 */
class NameChangeComponent extends Component
{
	private $logs = array();
	
	/**
	 * 名前変更ログを push する
	 * @param type $rcode 選手コード
	 * @param type $fam 新しい family_name。empty で変更なし。
	 * @param type $fir 新しい first_name。empty で変更なし。
	 * @param type $oldData 書き換え前データ。json 形式。
	 */
	public function pushLog($rcode, $fam, $fir, $oldData, $user)
	{
		if (empty($fam) && empty($fir)) return;
		
		$u = empty($user) ? "unknown" : $user;
		
		$this->logs[] = array('NameChangeLog' => array(
			'racer_code' => $rcode,
			'new_fam' => (empty($fam) ? '[変更なし]' : $fam),
			'new_fir' => (empty($fir) ? '[変更なし]' : $fir),
			'old_data' => $oldData,
			'by_user' => $u,
		));
	}
	
	/**
	 * push されたログを保存する。
	 * @return boolean 保存に成功したか。
	 */
	public function saveLogs()
	{
		if (empty($this->logs)) return true;

		$NameChangeLog = new NameChangeLog();
		$saved = $NameChangeLog->saveMany($this->logs);

		$msg = "選手名の変更が検出されました。\n";

		if (!$saved) {
			$this->log('選手名変更ログの保存に失敗しました。内容は以下の通り。', LOG_ERR);
			$this->log(print_r($this->logs), LOG_ERR);

			$msg .= '\n--> ！！！ ただし保存に失敗しました ！！！\n\n';
		}

		$msg .= "（結婚などの例外を除き、一般には名前の変更がなされることはありません。）\n\n";
		$msg .= "変更の詳細については以下のアドレスに記録されています。\n";

		foreach ($NameChangeLog->insertedIds as $nclId) {
			$msg .= Router::url(array('controller' => 'name_change_logs', 'action' => 'view', $nclId), array('full' => true)) . "\n";
		}

		MailReporter::report($msg);
		
		return $saved;
	}
}
