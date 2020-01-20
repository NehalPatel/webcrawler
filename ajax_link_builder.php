<?php
if (!isset($_POST['web_url'])) {
	echo '';exit;
}

require_once dirname( __FILE__ ) . '/helpers/curl_request.php';
require_once dirname( __FILE__ ) . '/helpers/helper_functions.php';
require_once dirname( __FILE__ ) . '/db/link_builder.php';

$web_url = $_POST['web_url'];

$html = getUrl( $web_url );
// $html = file_get_contents('sample.html');

$html = clean_html($html);
$urls = getURLs($html, $web_url);

$response = save_urls( $urls );
if( $response['status'] == 'error'){
	echo json_encode( $response );
}

$urls = get_all_urls_from_db();

$response['status'] = 'success';
$response['message'] = 'All URLs are saved into database successfully.';
$response['result'] = $urls;

// print_r($response);exit;

echo json_encode( $response );
exit;
?>