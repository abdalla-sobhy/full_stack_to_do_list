<?php 

session_start();
error_reporting(E_ERROR | E_PARSE);
if ( $_POST["signIn"] || $_POST["signUp"]){
    if ($_POST["password"] !== "" && $_POST["username"] !== ""){
        if ( $_POST["checkbox1"]){
            $_SESSION['password'] = $_POST["password"];
            $_SESSION['username'] = $_POST["username"];
        }
    
    mkdir($_POST["password"]);
    fopen($_POST["password"] . "/" . $_POST["username"].".txt", "w+");
    header("Location: " . $_SERVER["REQUEST_URI"]);
    exit();
    }
}

if ( isset($_SESSION["password"])){
    header("Location: to do list.php");
    exit();
}else {

?>

<html>
    <head>
        <title>to do list</title>
        <meta charset="UTF-8">
        <meta name="viewport" width="device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

        <div class="centerDiv">
            <div class="title_text"><div class="hey_there">Hey There <div class="welcome"> Welcome </div></div> 2 the <br> 2 do <br> list </div>
        
            <div class="bottomHalf">
                <div class="bottomHalf_contents">

                <form action="" method="post">

                    <div class="unserName_and_password_area">
                        <div class="username_text_and_password_text">user name</div>
                        <div class="username_and_password_field">
                            <input type="text" name="username" placeholder="username">
                        </div>
                    </div>
                    <div class="unserName_and_password_area">
                        <div class="username_text_and_password_text">password</div>
                        <div class="username_and_password_field">
                            <input type="text" name="password" placeholder="password">
                        </div>
                    </div>

                    <div class="signUp_button_and_check_box">
                            <input type="submit" name="signIn" value="sign in">
                            <input type="submit" name="signUp" value="sign up">
                            <div class="remeber_me">remember me</div>
                            <input type="checkbox" name="checkbox1" style="height: 1rem; width:1rem; margin-top:1rem;">
                    </div>

                    </form>

                </div>
            </div>
        </div>

    </body>
</html>
<?php } ?>