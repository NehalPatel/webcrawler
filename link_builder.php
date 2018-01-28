<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<?php
header( 'Content-Type: text/html; charset=utf-8' );
require_once dirname( __FILE__ ) . '/helpers/curl_request.php';
require_once dirname( __FILE__ ) . '/helpers/helper_functions.php';
require_once dirname( __FILE__ ) . '/db/link_builder.php';

//$output = getUrl('http://www.gujaratsamachar.com/');
$html = file_get_contents('sample.html');

$html = clean_html($html);
$urls = getURLs($html, 'http://www.gujaratsamachar.com/');

//print_r(  $html );
// echo "<pre>";
// print_r( $urls );
// echo "</pre>";

save_urls( $urls );
?>