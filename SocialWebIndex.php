<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 6/10/2015
 * Time: 9:41 PM
 */
include_once 'SocialWebHeader.php';

echo"<br/><span class='main'>Welcome to Tony Nest,";

if($loggedin){
    echo "$user, you are logged in";
}
else{
    echo "Please sign up and/or login to join in";
}

echo "</span>";