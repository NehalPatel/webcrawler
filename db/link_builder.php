<?php

require_once dirname( __FILE__ ) . '/db_helper.php';

//save urls in database
function save_urls($urls = array())
{
	if(empty($urls))
		return false;

	foreach ($urls as $key => $link) {

		//generate hash code for each url
		$data = array();
		$data['hash'] = $key;
		$data['url'] = $link['url'];
		$data['title'] = $link['title'];
		$data['data'] = $link['data'];

		save_link( $data );
	}

	return true;
}

function get_urls_from_db($offset, $limit)
{
	return get_urls($offset, $limit);
}

?>