<?php 

session_start();
error_reporting(E_ERROR | E_PARSE);
$userFile = fopen($_SESSION["password"] . "/" . $_SESSION["username"].".txt", "a+");

// while (!feof($userFile)){ // fero => end of file

    // echo fgets($userFile). "<br>";

// }

if($_POST["add"]) { 
    var_dump($_POST);
    if ($_POST["title"] != "" && $_POST["main"] != ""){
        echo $_POST["title"];
        fwrite($userFile, $_POST["title"] . "|");
        fwrite($userFile, $_POST["main"] . "\n");
        $_POST["title"] = "";
        $_POST["main"] = "";
    }
}

if ($_POST["signOut"]){
    session_unset();
    session_destroy();
    header("location: index.php");
    exit();
}
// fclose($userFile);
?>


<html>
    <head>
        <title>to do list</title>
        <meta charset="UTF-8">
        <meta name="viewport" width="device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="second_page_style.css">
    </head>
    <body>
        <div class="header">
            <div class="header_contents">
                <div class="username_part">
                    <?php echo $_SESSION["username"] . "'s to do list"?>
                </div>
                <div class="signIn_button">
                    <form action="" method="post">
                        <input type="submit" name="signOut" value="sing out">
                    </form>
                </div>
            </div>
        </div>

        <div class="body">
            <div class="left_side">
                <div class="title_place">
                    <span>1</span> - title is here
                </div>
            </div>

            <div class="right_side">

            </div>

        </div>

        <div class="add_section">
            <div class="add_section_content">
                <div class="title_input">
                <form action="" method="POST">
                        <input type="text" value="" name="title" placeholder="title">
                
                    </div>

                <div class="main_input">
                    
                        <input type="text" value="" name="main" placeholder="specefication">
                    </div>

                <div class="add_button">

                        <input type="submit" name="add" value="add">
                    </form>

                </div>
            </div>
        </div>

    </body>
</html>

<!-- <script>

    document.querySelector("form").addEventListener("submit",function(e){
        e.preventDefault();
    })

    let addButton = document.querySelector(".add_button input");
    console.log(addButton)
    let title = document.querySelector(".title_input input");
    console.log(title);
    let mainText = document.querySelector(".main_input input");
    let leftSide = document.querySelector(".left_side");
    let counter = 0;
    
            counter ++;
            let titlePlace = document.createElement("div");
            titlePlace.className = "title_place";
            titlePlace.innerHTML = `
            <span>${counter}</span> - 
            `;
            
            leftSide.appendChild(titlePlace);

</script>
