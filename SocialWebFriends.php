<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 11/10/2015
 * Time: 1:35 PM
 */
include_once 'SocialWebHeader.php';

if(isset($_GET['view'])) $view = sanitizeString($_GET['view']);
else                     $view = $user;

if($view == $user){
    $name1 = $name2 = "Your";
    $name3 = "You are";
}
else{
    $name1 = "<a href='SocialWebMembers.php?view=$view'>$view</a>'s";
    $name2 = "$view's";
    $name3 = "$view is";
}

echo "<div class='main'>";

//uncomment this line if you wish the user's profile to show here
//showProfile($view);
$followers = array();
$following = array();

$result = mysqli_query($db_server, "SELECT * FROM friends WHERE user='$view'");
$num = mysqli_num_rows($result);

for($i=0; $i<$num; ++$i){
    $row = mysqli_fetch_row($result);
    $followers[$i] = $row[1];
}

$result = mysqli_query($db_server, "SELECT * FROM friends WHERE friend='$view'");
$num = mysqli_num_rows($result);

for($j=0; $j<$num; ++$j){
    $row = mysqli_fetch_row($result);
    $following[$j] = $row[0];
}

$mutual = array_intersect($followers, $following);// extract all members common to both array and return a new array
$followers = array_diff($followers, $mutual);//keep only those people who are not mutual friend
$following = array_diff($following, $mutual);
$friends = false;

if(sizeof($mutual)){
    echo "<span class='subhead'>$name2 mutual friends</span><ul>";
    foreach($mutual as $friend){
        echo "<li><a href='SocialWebMembers.php?view=$friend'>$friend</a> ";
    }
    echo "</ul>";
    $friends = true;
}

if(sizeof($followers)){
    echo "<span class='subhead'>$name2 followers</span><ul>";
    foreach($followers as $friend)
        echo "<li><a href='SocialWebMembers.php?view=$friend'>$friend</a> ";
    echo "</ul>";
    $friends = true;
}

if(!$friends) echo "<br /> You don't have any friends yet.<br /><br />";
echo "<a class='button' href='SocialWebMessages.php?view=$view'>".
    "View $name2 messages</a>";


