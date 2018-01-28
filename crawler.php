<?php
require_once dirname( __FILE__ ) . '/helpers/curl_request.php';
require_once dirname( __FILE__ ) . '/helpers/helper_functions.php';
require_once dirname( __FILE__ ) . '/db/link_builder.php';


$urls = get_urls_from_db(0, 1);

foreach ($urls as $key => $link) {
	$html = getUrl( $link['url'] );
	$html = strip_html_contents( $html );

	save_html($link['hash'], $html);
}
echo "<pre>";
print_r($urls);
print_r($html);
echo "</pre>";

?>