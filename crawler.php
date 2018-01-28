<?php
require_once dirname( __FILE__ ) . '/helpers/curl_request.php';
require_once dirname( __FILE__ ) . '/helpers/helper_functions.php';
require_once dirname( __FILE__ ) . '/db/link_builder.php';

$urls = get_urls_from_db(10, 10);

echo "<pre>";
print_r($urls);
echo "</pre>";

?>