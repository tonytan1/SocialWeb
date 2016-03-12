<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 11/11/2015
 * Time: 12:02 AM
 */
include_once 'SocialWebFunctions.php';
$query = "ALTER TABLE socialweb.members DROP COLUMN email";

$db_server = mysqli_connect($db_host, $db_user, $db_pass);

$result = mysqli_query($db_server, $query) or die (mysqli_error($db_server));

// add email address as a new column
$query = "ALTER TABLE socialweb.members ADD email VARCHAR(50) NOT NULL after pass";

$db_server = mysqli_connect($db_host, $db_user, $db_pass);

$result = mysqli_query($db_server, $query) or die (mysqli_error($db_server));
return $result;

