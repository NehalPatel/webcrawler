<?php

require_once dirname( __FILE__ ) . '/db_helper.php';

//save urls in database
function save_urls($urls = array())
{
	$response = [];
	if(empty($urls)){
		$response['status'] = 'error';
		$response['message'] = 'no URLs found in array';
		return $response;
	}

	$response['status'] = 'success';
	$response['message'] = 'All URLs are saved into database successfully.';

	foreach ($urls as $key => $link) {

		//generate hash code for each url
		$data = array();
		$data['hash'] = $key;
		$data['url'] = $link['url'];
		$data['title'] = $link['title'];
		$data['page_title'] = '';
		$data['data'] = '';

		if( ! save_link( $data ) ){
			$response['status'] = 'error';
			$response['message'] = 'Error while saving into database.';
			$response['data'] = $data;
		}
	}

	return $response;
}

function get_all_urls_from_db()
{
	return get_all_urls();
}
function get_urls_from_db($offset, $limit)
{
	return get_urls($offset, $limit);
}

?>