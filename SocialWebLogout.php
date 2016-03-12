<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 21/10/2015
 * Time: 1:48 PM
 */

include_once 'SocialWebHeader.php';

if(isset($_SESSION['user'])){
    destorySession();

    echo "<div class='main'>You have been logged out. Please".
        "<a href='SocialWebIndex.php'>click here</a> to refresh the screen.";
}
else echo "<div class='main'><br />".
    "You cannot log out because you are not logged in";