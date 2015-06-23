<?php

/* 
 *  created at 2015/06/21 by shun
 */

// 'Meet' key object の有無でエラー判定する
echo json_encode($meet, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// TODO: Exception について
// 正しい出力ができるよう調整すること。
// ref: http://be-hase.com/php/497/
// ref: http://ultrah.zura.org/2013/01/20/cakephp%E3%81%AE%E3%83%87%E3%83%95%E3%82%A9%E3%83%AB%E3%83%88%E3%82%A8%E3%83%A9%E3%83%BC%E8%A1%A8%E7%A4%BA%E3%82%92%E7%8B%AC%E8%87%AA%E7%89%88%E3%81%AB%E3%81%99%E3%82%8B%E3%81%B9%E3%81%8F%E3%80%81/
// Renderer 内で ext == json 判定するのがよさそう。