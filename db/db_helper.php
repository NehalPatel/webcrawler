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

	$title = mysqli_real_escape_string($conn, $data['title']);

	$sql = 'INSERT INTO ' . TABLE . ' (hash, url, title, page_title, html, data, created_at) VALUES ("'. $data['hash'] .'", "'. $data['url'] .'", "'. $title . '", "","","", "'. date('Y-m-d H:i:s') .'")';

	// echo $sql . '<br />';exit;

	if ($conn->query($sql) === TRUE) {
	    return true;
	}

	// echo $sql . '<br />';exit;

	return false;
}

function get_all_urls()
{
	global $conn;

	$sql = "SELECT * FROM " . TABLE ." WHERE last_visited < '" . date("Y-m-d") ."'";
	//echo $sql . "<br>";
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

function get_urls($offset = 20, $limit = 10)
{
	global $conn;

	//$sql = "SELECT * FROM " . TABLE ." WHERE last_visited < '" . date("Y-m-d") ."'";
	$sql = "SELECT * FROM " . TABLE ." WHERE last_visited < '" . date("Y-m-d") ."' LIMIT ".$offset.",".$limit;
	//echo $sql . "<br>";
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

function save_html($hash, $title, $data)
{
	global $conn;

	$title = mysqli_real_escape_string($conn, $title);
	$data = mysqli_real_escape_string($conn, $data);

	$sql = 'UPDATE ' . TABLE . ' SET page_title="'. $title .'", data="'. $data .'", last_visited="'. date("Y-m-d") .'" WHERE hash="'. $hash .'"';

	// echo $sql . '<br />';exit;

	if ($conn->query($sql) === TRUE) {
	    return true;
	}

	return false;
}

function limitString($string, $limit = 100)
{
	// Return early if the string is already shorter than the limit
	if (strlen($string) < $limit) {
		return $string;
	}

	$regex = "/(.{1,$limit})\b/";
	preg_match($regex, $string, $matches);
	return $matches[1];
}

?>