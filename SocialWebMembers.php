<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 11/10/2015
 * Time: 11:27 AM
 */
include_once 'SocialWebHeader.php';

if(!$loggedin) die();

echo "<div class='main'>";

$user = $_SESSION['user'];

if(isset($_GET['view'])){
    $view = sanitizeString($_GET['view']);

    if($view == $user) $name = "Your";
    else $name = "$view's ";

    echo "<h3>$name Profile</h3>";
    showProfile($view);
    echo "<a class='button' href='SocialWebMessages.php?view=$view'>".
        "View $name message</a><br/><br/>";
    die("</div></body></html>");
}

if(isset($_GET['add'])) {
    $add = sanitizeString($_GET['add']);

    $query = "SELECT * FROM friends WHERE user='$add' AND friend='$user'";
    if (mysqli_num_rows(mysqli_query($db_server, $query)) == 0) {
        mysqli_query($db_server, "INSERT INTO friends VALUES ('$add', '$user')");
    }
}
elseif(isset($_GET['remove'])){
    $remove = sanitizeString($_GET['remove']);
    $query = "DELETE FROM friends WHERE user='$remove' AND friend='$user'";
    mysqli_query($db_server, $query);
}

$query = "SELECT user FROM members ORDER BY user";
$result = mysqli_query($db_server, $query);
$num = mysqli_num_rows($result);

echo "<h3>Other Members</h3><ul>";

for($i=0; $i<$num; ++$i){
    $row = mysqli_fetch_row($result);
    if($row[0] == $user) continue;

    echo "<li><a href='SocialWebMembers.php?view=$row[0]'>$row[0]</a>";
    $follow = "follow";

    $t1 = mysqli_num_rows(mysqli_query($db_server,
        "SELECT * FROM friends WHERE user='$row[0]' AND friend='$user'"));
    $t2 = mysqli_num_rows(mysqli_query($db_server,
        "SELECT * FROM friends WHERE user='$user' AND friend='$row[0]'"));

    if(($t1 + $t2) > 1) echo "&harr; is a mutual friend";
    elseif($t1 == 1) echo "&harr; you are following";
    elseif($t2 == 1) {
        echo "&rarr; is following you";
        $follow = "recip";
    }

    if(!$t1) echo "[<a href='SocialWebMembers.php?add=$row[0]'>$follow</a>]";
    else echo"[<a href='SocialWebMembers.php?remove=".$row[0] . "'>drop</a>]";
}
echo "<br /></div></body></html>";