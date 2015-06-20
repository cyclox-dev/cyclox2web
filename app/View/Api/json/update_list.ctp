<?php

/* 
 *  created at 2015/06/20 by shun
 */

$items = array(
	'meta'=> $meta
);

if (isset($error)) {
	$items['error'] = $error;
}

if (isset($response)) {
	$items['response'] = $response;
}

echo json_encode($items, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);