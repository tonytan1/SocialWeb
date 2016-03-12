<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 20/9/15
 * Time: 10:16 PM
 */
$user = mysql_fix_String($_POST['user']);
$pass = mysql_fix_String($_POST['pass']);
$query = "SELECT * FROM users WHERE user = '$user' AND pass = '$pass'";

function mysql_fix_String($string) {
    $db_hostname = 'localhost' ;
    $db_database = 'test';
    $db_username = 'root';
    $db_password = 'root';
    $db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

    if(get_magic_quotes_gpc()) $string = stripslashes($string);
    return mysqli_real_escape_string($string, $db_server);
}

//using placeholders
$query = 'PERPARE statement FROM "INSERT INTO classics VALUES (?,?,?,?,?)"';
mysqli_query($db_server, $query);

$query = 'SET @author = "Emily Bronte",
              @title = "Wuthering Heights",
              @category = "Classic Fiction",
              @year = "1847",
              @isbn = "9780553212587"';
mysqli_query($db_server, $query);

$query = 'EXECUTE statement USING @author, @title, @category, @year, @isbn';
mysqli_query($db_server, $query);

$query = 'DEALLOCATE PREPARE statement';
mysqli_query($db_server, $query);

// preventing both SQL and XSS injection attacks

function mysql_entities_fix_string($string){
    return htmlentities(mysql_fix_string($string));// mysql_fix_string has been defined
    //fix call... then call ...
}

$user = mysql_entities_fix_string($_POST['user']);
$pass = mysql_entities_fix_string($_POST['pass']);
$query = "SELECT * FROM users WHERE user='$user' AND pass='$pass'";

