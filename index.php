<!DOCTYPE html>
<html>
<head>
<title>Coral-Meet</title>
<script src="./vendor/jquery/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="./css/style.css" />
</head>
<body>
    <!--Contact Form-->
<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
include('./phpseclib/Net/SSH2.php');
// Check if user exists
$server_ip = $_SERVER['HTTP_HOST']; 
$user_exists = false;
if (isset($_POST["username"])){
    $user = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $filename = "http://".$server_ip."/coralmeet/current_profiles/".$user.".ovpn";
    try{
        @$myfile = fopen($filename, "r");
        @$user_exists = fread($myfile,1);
    }
    catch(Exception $e){}

}

// If not got user info or user exists, ask for username and system password
if (empty($_POST["send"]) or $user_exists) {
?>

    <div id="contact-popup">
        <form class="contact-form" action="" id="contact-form"
            method="post" enctype="multipart/form-data">
            <h1>
<?php
if ( $user_exists) {
?>
            Username exists! Enter a new username
<?php
}
else {
?>
            Please Enter username and password
<?php
}
?>         
            </h1>
            <div>
                <div>
                    <label>username: </label><span id="userName"
                        class="info"></span>
                </div>
                <div>
                    <input type="text" id="username" name="username"
                        class="inputBox" />
                </div>
            </div>
            <div>
                <div>
                    <label>password of the system: </label><span id="passWord"
                        class="password"></span>
                </div>
                <div>
                    <input type="password" id="password" name="password"
                        class="inputBox" />
                </div>
            </div>
            <div>
                <div>
                    <label>meeting name: </label><span id="meetingName"
                        class="info"></span>
                </div>
                <div>
                    <input type="text" id="meetingname" name="meetingname"
                        class="inputBox" />
                </div>
            </div>
            <div>
                <input type="submit" id="send" name="send" value=

<?php
if (! glob('*.ovpn')) {
?>
            "Install OpenVPN Client"
<?php
}
else {
?>
            "Go to meeting"
<?php
}
?>

                 />
            </div>


        </form>
    </div>

<?php
}
?>

<?php
if (! empty($_POST["send"])) {
    $user = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $pass = filter_var($_POST["password"], FILTER_SANITIZE_EMAIL);
    $meet = filter_var($_POST["meetingname"], FILTER_SANITIZE_EMAIL);
    echo "Hello user:".$user; echo "<br>";
    // Open vpn is setup and ovpn file is downloaded, simply run
    if (file_exists($user.".ovpn")) {
        $output = exec("sudo.cmd openvpn shreshth.ovpn");
        echo $output;
    } 
    // Download and install OpenVPN and run
    else {
        $output = shell_exec('openvpn');
        // If OpenVPN not installed, install it
        if (!$output){
            $url = 'https://swupdate.openvpn.org/community/releases/openvpn-install-2.4.8-I602-Win10.exe';
            $ch = curl_init($url);
            $file_name = "openvpn-installer.exe";
            $save_file_loc = './'.$file_name;
            $fp = fopen($save_file_loc, 'wb');
            curl_setopt($ch, CURLOPT_FILE, $fp); 
            curl_setopt($ch, CURLOPT_HEADER, 0); 
            curl_exec($ch); 
            curl_close($ch); 
            fclose($fp); 
            $output = shell_exec('openvpn-installer');
        }
        $server_ip = $_SERVER['HTTP_HOST']; 
        if (!file_exists("45.79.121.176:8090/current_profiles/".$user.".ovpn"))  
        {
            $ssh = new Net_SSH2("45.79.121.176");
            if (!$ssh->login('root', '#$$uteq$$#')) {exit('Login Failed');}
            echo $ssh->exec('./openvpn-install-2.sh 1 '.$user);
            echo $ssh->exec('mv '.$user.'.ovpn /var/www/html/current_profiles/'.$user.'.ovpn');
            copy('http://45.79.121.176:8090/current_profiles/'.$user.'.ovpn', $user.'.ovpn');
        }
        $output = exec("sudo.cmd openvpn ".$user.".ovpn");
        echo $output;
    }
    sleep(3);
    $link = "<script>window.open('https://10.8.0.1/".$meet."')</script>";
    echo $link;
?>

<div id="success">Your user information received succesfully!</div>

<?php
}
?>

<script>
$(document).ready(function () {
    $("#contact-popup").show();
    //Contact Form validation on click event
    $("#contact-form").on("submit", function () {
        var valid = true;
        $(".info").html("");
        $("inputBox").removeClass("input-error");
        
        var username = $("#username").val();
        var password = $("#password").val();
        var meeting = $("#meetingname").val();

        if (username == "") {
            $("#userName").html("required.");
            $("#username").addClass("input-error");
        }
        if (password == "") {
            $("#passWord").html("required.");
            $("#password").addClass("input-error");
            valid = false;
        }
        if (password == "") {
            $("#meetingName").html("required.");
            $("#meetingname").addClass("input-error");
            valid = false;
        }
        return valid;
    });
});
</script>
