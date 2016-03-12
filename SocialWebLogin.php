<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 10/10/2015
 * Time: 9:43 PM
 */
include 'SocialWebHeader.php';

echo "<div class='main'>";
if(isset($_GET["user"])){
    $user = sanitizeString($_GET["user"]);
    $pass = sanitizeString($_GET["pass"]);

    if($user==""||$pass==""){
        $error = "Not all field were entered<br />";
    }
    else{
        echo "yes";
        $query = "SELECT user,pass FROM members where user='$user' AND pass='$pass'";
        $result = mysqli_query($db_server, $query);
        if(mysqli_num_rows($result) !=0){
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            die ("You are now logged in. Please <a href='SocialWebMembers.php?view=$user'>" ."click here</a> to continue.<br /><br />");
        }
        else{
            echo mysqli_num_rows($result);
            $error = "<span class='error'>Username/Password invalid</span><br/><br/>";
            echo "<div class='main'><h3>Please enter your details to log in</h3></div>";
        }
    }
}

echo <<<_END
<form action="/myPHP/SocialWeb/SocialWebLogin.php" method="get">
<span class="fieldname">Username</span>
<input type="text" maxlength="16" name="user" /><br/>
<span class="fieldname">Password</span>
<input type="password" maxlength="16" name="pass"/>
<br>
<span class="fieldname">&nbsp;</span>
<input type="submit" value="Login"/>
</form>
<a href='SocialWebResetpwd.php'>Forget Password</a>
<a href='SocialWebRSS.php'>RSS</a>
</div><br/></body></html>
_END;
