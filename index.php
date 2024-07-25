<?php 
session_start();
error_reporting(E_ERROR | E_PARSE);

$host = "localhost";
$user = "root";
$password = "951753bs";
$dbname = "to_do_list";
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;

$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


function tableExists($pdo, $table) {
    try {
        $result = $pdo->query("SELECT 1 FROM {$table} LIMIT 1");
    } catch (Exception $e) {
        return FALSE;
    }
    return $result !== FALSE;
}


if ( $_POST["signIn"] ){
    if ($_POST["password"] !== "" && $_POST["username"] !== ""){
        if ( $_POST["checkbox1"]){
            
            $password = str_replace( ' ','',filter_input(INPUT_POST,'password', FILTER_SANITIZE_SPECIAL_CHARS));
            $username = str_replace( ' ','_',filter_input(INPUT_POST,'username', FILTER_SANITIZE_SPECIAL_CHARS));
            $tableName = $username . $password;

            $result = tableExists($pdo, $tableName);
            if ($result == 1) {
                $password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_SPECIAL_CHARS);
                $_SESSION['password'] = str_replace(' ','',$password);

                $username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_SPECIAL_CHARS);
                $_SESSION['username'] = str_replace(' ','_',$username);
            }else{
                $error_message = "wrong password or usernmae";
            }
        }
    }
}elseif($_POST["signUp"]){
    if ($_POST["password"] !== "" && $_POST["username"] !== ""){
    
        $password = str_replace( ' ','',filter_input(INPUT_POST,'password', FILTER_SANITIZE_SPECIAL_CHARS));
        $username = str_replace( ' ','_',filter_input(INPUT_POST,'username', FILTER_SANITIZE_SPECIAL_CHARS));

        $tableName = $username . $password;

        $result = tableExists($pdo, $tableName);

    if ($result == 1) {
        $error_message = "username and password are already in use";
    }else{
    
        $password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $_SESSION['password'] = str_replace(' ','',$password);

        $username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $_SESSION['username'] = str_replace(' ','_',$username);

    $statements  = ["CREATE TABLE $tableName( 
        id   INT(50) AUTO_INCREMENT,
        title  VARCHAR(100) NOT NULL, 
        body TEXT NOT NULL,
        PRIMARY KEY(id)
    )"];
    
    foreach ($statements as $statement) {
        $pdo->exec($statement);
    }
}
}
}






if ( isset($_SESSION["password"])){
    header("Location: /public/pages/to do list.php");
    exit();
}else {

?>

<html>
    <head>
        <title>to do list</title>
        <meta charset="UTF-8">
        <meta name="viewport" width="device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="/public/styles/style.css">
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

                    <div class="error_message">
                        <?php echo $error_message ?>
                    </div>

                </div>
            </div>
        </div>

    </body>
</html>
<?php } ?>