

<h1>大会情報編集</h1>
<?php
echo $this->Form->create('Meet');

echo $this->Form->input('code', array('type' => 'hidden'));
echo 'meet_group_code';
echo 'season_id';
// TODO: select の整備
echo $this->Form->input('at_date', array('label' => '開催日', 'dateFormat' => 'YMD'));
echo $this->Form->input('name', array('label' => '大会名称', 'type' => 'text'));
echo $this->Form->input('short_name', array('label' => '短縮名称', 'type' => 'text'));
echo $this->Form->input('location', array('label' => '開催地', 'type' => 'text'));
echo $this->Form->input('organized_by', array('label' => '主催', 'type' => 'text'));
echo $this->Form->input('homepage', array('label' => 'ホームページ URL', 'type' => 'text'));
echo $this->Form->input('start_frac_distance', array('label' => 'スタート端数距離'));
echo $this->Form->input('lap_distance', array('label' => '周回距離'));

echo $this->Form->end('保存');

?>