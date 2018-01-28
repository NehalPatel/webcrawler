<?php

header('Content-Type: text/html; charset=utf-8');
require_once dirname( __FILE__ ) .'/settings.php';

// Create connection
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

if (!$conn->set_charset("utf8")) {
	printf("Error loading character set utf8: %s\n", $conn->error);
}

function check_duplicate( $hash = '' )
{
	global $conn;

	$sql = 'SELECT id,hash FROM ' . TABLE .' WHERE hash="' . $hash .'"';
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    	return true;
	}

	return false;
}

function sanitize($data)
{
	//return mysqli::real_escape_string($data);
	return htmlspecialchars($data, ENT_NOQUOTES, "UTF-8");
	//return $data;
}

function save_link( $data = array() )
{
	global $conn;

	if( check_duplicate($data['hash']) )
		return false;

	$sql = 'INSERT INTO ' . TABLE . ' (hash, url, title, data, created_at, last_visited) VALUES ("'. $data['hash'] .'", "'. $data['url'] .'", "'. sanitize($data['title']). '", "", "'. date('Y-m-d H:i:s') .'", "")';

	echo $sql . '<br />';

	if ($conn->query($sql) === TRUE) {
	    return true;
	}

	return false;
}

function get_urls($offset = 20, $limit = 10)
{
	global $conn;

	//$sql = "SELECT * FROM " . TABLE ." WHERE last_visited < '" . date("Y-m-d") ."'";
	$sql = "SELECT * FROM " . TABLE ." WHERE last_visited < '" . date("Y-m-d") ."' LIMIT ".$offset.",".$limit;
	echo $sql . "<br>";
	$result = $conn->query($sql);

	$records = array();

	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	    	$records[] = $row;
	    }

	    return $records;
	}

	return false;
}

?>