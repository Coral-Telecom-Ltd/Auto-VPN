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
// Check if user exists
$user_exists = false;
if (isset($_POST["username"])){
    $user = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
    $filename = fopen("profiles.txt","r");
    while(! feof($filename))  {
        $result = fgets($filename);
        if (strpos($result, $user) !== false){
            $user_exists = true;
        }
    }
}

// If not got user info or user exists, ask for username and system password
if (empty($_POST["send"]) or $user_exists) {
    if ($user_exists){
        $hash = hash('ripemd160', $user);
        $hash = substr($hash,0,6);
    }
    
?>

    <div id="contact-popup">
        <form class="contact-form" action="" id="contact-form"
            method="post" enctype="multipart/form-data">
            
<?php
if ( $user_exists) {
?>
            <h1>Username Created! Here is your link:</h1>
<?php
}
else {
?>
            <h1>Please enter valid username:</h1>
     
            
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
                <input type="submit" id="send" name="send" value="Generate Link"/>
            </div>
<?php
}

    if ($user_exists){
        echo "<a href='https://collaboration.coraltele.com/";
        echo $hash."'>https://collaboration.coraltele.com/".$hash."</a>";
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
