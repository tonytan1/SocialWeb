<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 11/10/2015
 * Time: 12:48 AM
 */
include_once 'SocialWebHeader.php';

if(!$loggedin) die();

echo "<div class='main'><h3>Your Profile</h3>";
$user = $_SESSION['user'];//?
showProfile($user);



if(isset($_POST['text'])){
    $text = sanitizeString($_POST['text']);
    $text = preg_replace('/\s\s+/', ' ', $text);
    $user = $_SESSION['user'];//?
    showProfile($user);

    if(mysqli_num_rows(mysqli_query($db_server, "SELECT * FROM profiles WHERE user='$user'")) > 0){
        mysqli_query($db_server, "UPDATE profiles SET text='$text' WHERE user='$user'");
    }
    else{
        mysqli_query($db_server, "INSERT INTO profiles VALUES('$user', '$text')");
    }
}
else{
    $user = $_SESSION['user'];//?

    $result = mysqli_query($db_server, "SELECT * FROM profiles WHERE user='$user'");

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_row($result);
        $text = stripslashes($row[1]);
    }
    else $text = "";
}

$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

if(isset($_FILES['image']['name'])){
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = true;

    switch($_FILES['image']['type']){
        case "image/gif": $src = imagecreatefromgif($saveto); break;
        case "image/jpeg": //Allow both regular and progressive jpegs
        case "image/pjpeg": $src = imagecreatefromjpeg($saveto); break;
        default: $typeok = false; break;
    }

    if($typeok){
        list($w, $h) = getimagesize($saveto);

        $max = 100;
        $tw = $w;
        $th = $h;

        if($w > $h && $max < $w){
            $th = $max/$w * $h;
            $tw = $max;
        }
        elseif($h > $w && $max < $h){
            $tw = $max / $h*$w;
            $th = $max;
        }
        elseif($max < $w){
            $tw = $th = $max;
        }

        $tmp = imagecreatetruecolor($tw, $th);
        imagecopyresampled($tmp, $src, 0,0,0,0, $tw, $th, $w, $h);
        imageconvolution($tmp, array(array(-1, -1, -1), array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
        imagejpeg($tmp, $saveto);// output jprg to $saveto

        imagedestroy($tmp);
        imagedestroy($src);
    }
}




echo <<<_END
<form method='post' action='SocialWebProfile.php' enctype='multipart/form-data'>
<h3>Enter or edit your detials and/or upload an image</h3>
<textarea name='text' cols='50' rows='3'>$text</textarea><br/>
Image: <input type='file' name='image' size='14' maxlength='32'/>
<Input type='submit' value='Save Profile'/>
</form></div><br /><body></html>
_END;

