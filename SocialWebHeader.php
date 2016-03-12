<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 5/10/2015
 * Time: 10:01 PM
 */

session_start();

echo "<!DOCTYPE html>\n<html><head><script src='OSC.js'></script>";
include 'SocialWebFunctions.php';

$userstr = '(Guest)';

if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr = "($user)";
}
else {
    $loggedin = FALSE;
    $user = '';
}

echo "<title>$app_name$userstr</title><link rel='stylesheet'".
     " href='SocialWebStyles.css' type='text/css'/>".
     "</head><body><div class='app_name'>$app_name$userstr</div>";

if($loggedin){
    echo ("<br /><ul class='menu'>".
          "<li><a href='SocialWebMembers.php?view=$user'>HOME</a></li>".
          "<li><a href='SocialWebMembers.php'>Members</a></li>".
          "<li><a href='SocialWebFriends.php'>Friends</a></li>".
          "<li><a href='SocialWebMessages.php'>Messages</a></li>".
          "<li><a href='SocialWebProfile.php'>Edit Profile</a></li>".
          "<li><a href='SocialWebLogout.php'>Log Out</a></li></ul><br/>");
}
else{
    echo ("<br /><ul class='menu'>".
        "<li><a href='SocialWebIndex.php'>HOME</a></li>" .
         "<li><a href='SocialWebSignup.php'>Sign up</a></li>".
         "<li><a href='SocialWebLogin.php'>Log in</a></li></ul><br/>".
         "<span class='info'>&#8658; You must be logged in to view the social site.</span><br /><br />");
}