<?php

if (!isset($_REQUEST['page'])) {
    echo '';
    exit;
}

require_once dirname( __FILE__ ) . '/db/db_helper.php';

$page = $_REQUEST['page'];
$offset = ($page - 1)*10;
$limit = 10;

$select_sql = "select id, hash, url, title, page_title, SUBSTRING(`data`, 1, 300) as data FROM tbl_webdata LIMIT $offset, $limit";

// echo $select_sql;exit;

$result = mysqli_query($conn, $select_sql);

$search_result=[];

if( empty($result) ){

    $search_result['message'] = 'No records found';
    $search_result['result'] = '';

} else{

    $search_result['message'] = 'Records found';
    while($row = mysqli_fetch_assoc($result)){

        $search_result['result'][] = $row;

    }
}

// print_r($search_result);exit;

echo json_encode($search_result);
exit;