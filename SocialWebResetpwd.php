<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 10/11/2015
 * Time: 11:41 PM
 */

include_once "SocialWebHeader.php";

if (isset($_POST['user'])){
    $username = $_POST['user'];
    $email = $_POST['email'];
    $query="select * from members where user='$username'";
    $result = mysqli_query($db_server, $query);
    $rows=mysqli_fetch_array($result);
    if($rows['email'] == $email){
        $rows=mysqli_fetch_array($result);
        $password  =  $rows['pass'];//FETCHING PASS

        //Details for sending E-mail
        $from = "Tony Nest";
        $url = "http://www.tonynest.com/";
        $body  =  "have fun with friends
		-----------------------------------------------
		Url : $url;
		email Details is : $email;
		Here is your password  : $password;
		Sincerely,
		Coding Cyber";
        $from = "tanxiucai1@hotmail.com";
        $subject = "TonyNest Password recovered";
        $headers1 = "From: $from\n";
        $headers1 .= "Content-type: text/html;charset=iso-8859-1\r\n";
        $headers1 .= "X-Priority: 1\r\n";
        $headers1 .= "X-MSMail-Priority: High\r\n";
        $headers1 .= "X-Mailer: Just My Server\r\n";
        $sentmail = mail( $email, $subject, $body, $headers1 );
    } else {
        if ($_POST ['email'] != "") {
            echo "<span style=' #ff0000'> Not found your email in our database</span>";
            $sentmail = '';
		}
    }
    //If the message is sent successfully, display sucess message otherwise display an error message.
    if($sentmail==1)
    {
        echo "<span style='color: #ff0000;'> Your Password Has Been Sent To Your Email Address.</span>";
    }
    else
    {
        if($_POST['email']!="")
            echo "<span style='color: #ff0000;'> Cannot send password to your e-mail address.Problem with sending mail...</span>";
    }
}
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Home: Webpage</title>
</head>
<body>
<form action="SocialWebResetpwd.php" method="post">
    <label> Enter your Username : </label>
    <input id="user" type="text" name="user" />
    <label><br /> Enter your email address:</label>
    <input id= "email" type="text" name="email"/>
    <input id="button" type="submit" name="button" value="Submit" />
</form>
</body>
</html>