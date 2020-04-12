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

<?php
// Check if user exists
$user_exists = false;
if (isset($_POST["username"])){
    $user = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $filename = fopen("profiles.txt","r");
    while(! feof($filename))  {
        $result = fgets($filename);
        $result = substr($result,0,strlen($result)-1);
        if (strcmp($result, $user) == 0){
            $user_exists = true;
        }
    }
}

// If not got user info or user exists, ask for username and system password
if (empty($_POST["send"]) or $user_exists) {
    if ($user_exists){
        $hash = hash('ripemd160', $user);
        $hash = substr($hash,0,9);
    }
    
?>

    <div id="contact-popup">
        <form class="contact-form" action="" id="contact-form"
            method="post" enctype="multipart/form-data">
            <div class="watermark"></div>
<?php
if ( $user_exists) {
?>
            <h1>Welcome to Coral Collaboration</h1>
<?php
}
else {
?>
            <h1>Please enter valid username:</h1>
     
            
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
        echo "<center><a href='https://collaboration.coraltele.com/";
        echo $hash."' class='w3-btn w3-black'>Click Here</a></center>";
    }
?>

        </form>
    </div>

<?php
}

if (!empty($_POST["send"])and !$user_exists) {
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
</script>


