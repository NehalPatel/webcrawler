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

save_urls( $urls );

$urls = get_all_urls_from_db();

echo json_encode( $urls );
exit;
?>