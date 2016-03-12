<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 5/10/2015
 * Time: 9:09 PM
 */
$db_host = 'localhost';
$db_name = 'socialweb';
$db_user = 'tonytan';
$db_pass = 'p@55w0rd';
$app_name = 'Tony Nest';

$db_server = mysqli_connect($db_host, $db_user, $db_pass);
mysqli_select_db($db_server, $db_name) or die(mysqli_error($db_server));

function createTable($name, $query){
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Table '$name' created or already exists. <br />";
}

function queryMysql($query){
    $db_host = 'localhost';
    $db_user = 'tonytan';
    $db_pass = 'p@55w0rd';
    $db_name = 'socialweb';

    $db_server = mysqli_connect($db_host, $db_user, $db_pass);
    mysqli_query($db_server, "USE $db_name");

    $result = mysqli_query($db_server, $query) or die (mysqli_error($db_server));
    return $result;
}

function destorySession(){
    $_SESSION=array();

    if(session_id()!=""||isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}

function sanitizeString($var){
    $db_host = 'localhost';
    $db_user = 'tonytan';
    $db_pass = 'p@55w0rd';

    $db_server = mysqli_connect($db_host, $db_user, $db_pass);

    $var = strip_tags($var);//HTML、XML 以及 PHP 的标签
    $var = htmlentities($var);//字符转换为 HTML 实体
    $var = stripslashes($var);//delete backlash.
    return mysqli_real_escape_string($db_server, $var);
}

function showProfile($user){
    $db_host = 'localhost';
    $db_user = 'tonytan';
    $db_pass = 'p@55w0rd';
    //$db_name = 'socialweb';

    $db_server = mysqli_connect($db_host, $db_user, $db_pass);

    if(file_exists("$user.jpg"))
       echo "<img src='$user.jpg' align='left'/>";

    $query = "SELECT * FROM profiles WHERE user='$user'";


    //$row = mysqli_fetch_row($result);
    //echo stripslashes($row[1])."<br clear=left/><br/>";

    if ($result = mysqli_query($db_server, $query)) {
        echo "yes";
        /* fetch object array */
        while ($row = $result->fetch_row()) {
            echo "$row[0]: $row[1]";
        }
    }


    }













