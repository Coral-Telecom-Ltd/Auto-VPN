<!DOCTYPE html>
<html>
<head>
<title>Coral-Meet</title>
<script src="./vendor/jquery/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="./css/style.css" />
</head>
<body>
    <!--Contact Form-->
<div stype='background-image: url("youtube-banner.png");'>

<script>
function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}
</script>

<?php

$serverIP = $_SERVER['HTTP_HOST'];
// Check if user exists
$user_exists = false;
if (isset($_POST["username"])){
    $user = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $filename = fopen("profiles.txt","r");
    while(! feof($filename))  {
        $result = fgets($filename);
        $result = substr($result,0,strlen($result)-1);
        if (strlen($result) > 1 and strcmp($result, $user) == 0){
            $user_exists = true;
        }
    }
}

// If not got user info or user exists, ask for username and system password
if (empty($_POST["send"]) or $user_exists or (!empty($_POST["send"]) and strlen($_POST["username"]) == 0)) {
    if ($user_exists){
        $hash = hash('ripemd160', $user.date('ljFY'));
        $hash = substr($hash,0,12);
    }
    
?>

    <div id="contact-popup">
        <form class="contact-form" action="" id="contact-form"
            method="post" enctype="multipart/form-data">
            <div class="watermark"></div>
<?php
if ( $user_exists) {
?>      
            <center>
            <h3>Welcome to your collaboration room!</h3>
            <font size='3'>Click on the link below to enter. Copy & share the link with others who you want to invite.</font>
            </center>
<?php
}
else {
?>
            <h1>Please enter assigned user name:</h1>
     
            
            <div>
                <div>
                    <input type="text" id="username" name="username"
                        class="inputBox" />
                </div>
            </div>
            <div>
                <input type="submit" id="send" name="send" value="Generate Link"/>
            </div>
<?php
}

    if ($user_exists){
        echo "<br><center><a href='https://".$serverIP."/";
        echo $hash."' class='w3-btn w3-black'>https://".$serverIP."/".$hash."</a></center><br>";
        echo "<a class='cls_copy_pg_action copyAction copy-action-btn' data-value='https://".$serverIP."/".$hash."'> <i class='far fa-copy'></i><center><font size='2'> Copy URL </font><img alt='copy' src='copy.png'
         width=15' height='15'> </center></a><br>";
         echo "<center><font size='1'>This solution has been developed using open-sources platforms including FreeSwitch, OpenVPN, GoogleCloudAI, Jitsi and OpenSwan</font></center><br>";
    }
    else{
        echo "<br><center><font size='3'><i>Developed by QUBIT INC - an Indian startup of engineers from IIT Delhi and Coral Telecom</i></font></center>";
        echo "<br><center><font size='2'>Not yet registered?  <a href='https://".$serverIP."/coralmeet/register.php'>Click Here</a></font></center>";
    }
?>

        </form>
    </div>

<?php
}

if (!empty($_POST["send"]) and strlen($_POST["username"]) == 0){
    echo "Username can not be empty.";
}
elseif (!empty($_POST["send"])and !$user_exists) {
    echo "Username not registered! Please contact Coral Telecom.";
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

        if (username == "") {
            $("#userName").html("required.");
            $("#username").addClass("input-error");
        }
        return valid;
    });
});
$(document).on("click", ".copy-action-btn", function() { 
      var trigger = $(this);
      $(".copy-action-btn").removeClass("text-success");
      var $tempElement = $("<input>");
        $("body").append($tempElement);
        var copyType = $(this).data("value");
        $tempElement.val(copyType).select();
        document.execCommand("Copy");
        $tempElement.remove();
        $(trigger).addClass("text-success");

  });
</script>


