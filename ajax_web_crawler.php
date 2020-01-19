<?php

if (!isset($_POST['limit'])) {
	echo '';exit;
}

require_once dirname( __FILE__ ) . '/helpers/curl_request.php';
require_once dirname( __FILE__ ) . '/helpers/helper_functions.php';
require_once dirname( __FILE__ ) . '/db/link_builder.php';

$offset = $_POST['offset'];
$limit = $_POST['limit'];
$urls = get_urls_from_db($offset, $limit);

$result = array();
foreach ($urls as $key => $link) {
	$html = getUrl( $link['url'] );
	$data = strip_html_contents( $html );
	$title = stip_page_title( $html );

	$row = array();
	$row['hash'] = $link['hash'];

	if ( save_html($link['hash'], $title, $html, $data) ) {
		$row['status'] = 'success';
		$row['last_visited'] = date("Y-m-d H:i:s");
	} else {
		$row['status'] = 'failed';
	}
	$result[] = $row;
}

echo json_encode( $result );
exit;
?>