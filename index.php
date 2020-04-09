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
if (empty($_POST["send"])) {
?>

    <div id="contact-popup">
        <form class="contact-form" action="" id="contact-form"
            method="post" enctype="multipart/form-data">
            <h1>Please Enter username and password</h1>
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
    echo "Hello user:".$user; echo "<br>";
    // Open vpn is setup and ovpn file is downloaded
    if (file_exists($user.".ovpn")) {
        exec("openvpn ".$user.".ovpn")
    } else {
        $url = 'https://swupdate.openvpn.org/community/releases/openvpn-install-2.4.8-I602-Win10.exe';
        $ch = curl_init($url);
        $file_name = "openvpn.exe";
        $save_file_loc = './'.$file_name;
        $fp = fopen($save_file_loc, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp); 
        curl_setopt($ch, CURLOPT_HEADER, 0); 
        curl_exec($ch); 
        curl_close($ch); 
        fclose($fp); 
        $output = shell_exec('openvpn');
        $server_ip = $_SERVER['HTTP_HOST']; 
        if (file_exists($server_ip."/vpn_configs/"))  
    }
?>

<div id="success">Your contact information is received successfully!</div>

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

        if (username == "") {
            $("#userName").html("required.");
            $("#username").addClass("input-error");
        }
        if (password == "") {
            $("#passWord").html("required.");
            $("#password").addClass("input-error");
            valid = false;
        }
        return valid;
    });
});
</script>
