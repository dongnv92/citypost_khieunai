<?php
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Ho_Chi_Minh');

/*// Define Config Database
define('_DB_SERVER', 'localhost');
define('_DB_USER', 'citypost');
define('_DB_PASS', 'dong2442');
define('_DB_NAME', 'citypost_city');

// Connect To Database
$db_connect = mysqli_connect(_DB_SERVER, _DB_USER, _DB_PASS, _DB_NAME) or die('Cant Connect To Database');
mysqli_query($db_connect,"SET NAMES 'utf8'");
$submit	= $_POST['submit'];*/


define('_URL_HOME', 'https://citypost.com.vn/');
define('_URL_ADMIN', '#');

$act 	    = isset($_REQUEST['act']) 	    ? trim($_REQUEST['act']) 		: '';
$id 	    = isset($_REQUEST['id']) 	    ? trim($_REQUEST['id']) 		: '';


/** Check data before insert */
function checkInsert($text){
    global $db_connect;
    if (get_magic_quotes_gpc()){
        $text = mysqli_real_escape_string($db_connect, stripslashes($text));
    }else{
        $text = mysqli_real_escape_string($db_connect, $text);
    }
    return $text;
}

function getTextStatus($status){
    $text = '';
    switch ($status){
        case 0:
            $text = 'Mới tạo';
            break;
        case 1:
            $text = 'Chưa xử lý';
            break;
        case 2:
            $text = 'Đang xử lý';
            break;
        case 3:
            $text = 'Đã xử lý';
            break;
    }
    return $text;
}

function getGlobal($table, $data, $select = '*', $option = ''){
    global $db_connect;
    foreach ($data as $key => $value) {
        $colums[] = "`" . $key . "` = '" . checkInsert($value) . "'";
    }
    $colums_list = implode(' AND ', $colums);

    if($option['order_by']){
        $extra = ' '.$option['order_by'].' ';
    }
    if($option['limit']){
        $extra .= ' '. $option['limit'] .' ';
    }

    if($option['query']){
        $query = $option['query'];
    }else{
        $query = 'SELECT '. $select .' FROM `'. $table .'` WHERE '.$colums_list.' '.$extra;
    }

    $q = mysqli_query($db_connect, $query);
    $n = mysqli_fetch_array($q);
    return $n;
}
