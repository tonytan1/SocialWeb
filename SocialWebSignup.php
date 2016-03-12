<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 8/10/2015
 * Time: 9:44 PM
 */
include_once 'SocialWebHeader.php';

echo <<<_END
<script>
function checkUser(user){
    if(user.value == ''){
        O('info').innerHTML = ''
        return
    }

    params = 'user=' + user.value
    request = new ajaxRequest()
    request.open("POST", "checkuser.php", true)
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.setRequestHeader("Content-type", params.length)
    request.setRequestHeader("Connection", "close")

    request.onreadystatechange = function(){
    if(this.readyState == 4)
        if(this.status == 200)
            if(this.responseText != null)
                O('info').innerHTML = this.responseText
    }

    function ajaxRequest(){
        try{ var request = new XMLHttpRequest()}
        catch(e1){
            try{ request = new ActiveXObject("Msxml2.XMLHTTP") }
            catch(e2){
                try{ request = new ActiveXObject("Microsoft.XMLHTTP") }
                catch(e3){
                    request = false
        }   }   }
        return request
    }
</script>
<div class='main'><h3>Please enter your details to sign up</h3>
_END;

$error = $user = $pass = "";
if(isset($_SESSION['user'])) destorySession();

if(isset($_POST['user'])){
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if($user == ""|| $pass == ""){
        $error = "Not all fields were entered <br /> <br />";
    }
    else{
        if(mysqli_num_rows(queryMysql("SELECT * FROM members WHERE user = '$user'")))
            $error = "That username already exists <br /><br />";
        else{
            queryMysql("INSERT INTO members VALUES('$user', '$pass')");
            die("<h4> Account created</h4> Please Log in.<br /><br />");
        }
    }
}

echo <<<_END
<form method='post' action = 'SocialWebSignup.php' name="signupform">$error
<span class='fieldname'>Username</span>
<input type='text' maxlength='16' name='user' value='$user'
    onBlur='checkUser(this)'/><span id='info'></span><br />
<span class='fieldname'>Password</span>
<input type='text' maxlength='16' name='pass' value = '$pass' /><br />
<span class = 'fieldname'>&nbsp;</span>
<input type='submit' value='Sign up'/>
</form></div><br /></body></html>
_END;


