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

$tableName = $_SESSION["username"] . $_SESSION["password"];

if( isset($_POST["add"]) ) { 
    if ($_POST["title"] != "" && $_POST["main"] != ""){
        $sql = "INSERT INTO $tableName(title, body) VALUES(:title, :body)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['title' => $_POST["title"],'body'=> $_POST["main"]]);
        header("Location: " . $_SERVER["REQUEST_URI"]);
        exit();
    }
}

if (isset($_POST["signOut"])){
    session_unset();
    session_destroy();
    header("location: /index.php");
    exit();
}

if (isset($_POST["submitText"])){
    $newText = $_POST["bodyText"];
    $id = $_SERVER["REQUEST_URI"];
    $character = '=';
    $id = strstr($id, $character, false);
    $id = str_replace("=",'', $id);
    $sql = "UPDATE $tableName SET body = :body WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['body'=> $newText, 'id' => $id]);
}


?>




<html>
    <head>
        <title>to do list</title>
        <meta charset="UTF-8">
        <meta name="viewport" width="device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="/public/styles/second_page_style.css">
    </head>
    <body>
        <div class="header">
            <div class="header_contents">
                <div class="username_part">
                    <?php echo str_replace("_"," ",$_SESSION["username"]) . "'s to do list"?>
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
                <!-- <div class="title_place">
                    <div class="title">
                        - title is here
                    </div>
                    <div class="images">
                        <div class="delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" viewBox="0 0 24 24" fill="none">
    <path d="M5 5L19 19M5 19L19 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
                        </div>
                        <div class="delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" viewBox="0 0 24 24" fill="none">
<path fill-rule="evenodd" clip-rule="evenodd" d="M20.8477 1.87868C19.6761 0.707109 17.7766 0.707105 16.605 1.87868L2.44744 16.0363C2.02864 16.4551 1.74317 16.9885 1.62702 17.5692L1.03995 20.5046C0.760062 21.904 1.9939 23.1379 3.39334 22.858L6.32868 22.2709C6.90945 22.1548 7.44285 21.8693 7.86165 21.4505L22.0192 7.29289C23.1908 6.12132 23.1908 4.22183 22.0192 3.05025L20.8477 1.87868ZM18.0192 3.29289C18.4098 2.90237 19.0429 2.90237 19.4335 3.29289L20.605 4.46447C20.9956 4.85499 20.9956 5.48815 20.605 5.87868L17.9334 8.55027L15.3477 5.96448L18.0192 3.29289ZM13.9334 7.3787L3.86165 17.4505C3.72205 17.5901 3.6269 17.7679 3.58818 17.9615L3.00111 20.8968L5.93645 20.3097C6.13004 20.271 6.30784 20.1759 6.44744 20.0363L16.5192 9.96448L13.9334 7.3787Z" fill="#0F0F0F"/>
</svg>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="right_side">
            <div class="submitButton" style="float: right;height: 7%;width: 8%;float: right;visibility: hidden;">
            <form action="" method="post">
                    <input type="submit" name="submitText" value="submit" style="height: 100%;width: 100%;font-size: 1rem;position: relative;">
                </div>
                <div class="main_text">
                    
                    <textarea name="bodyText" rows="37" cols="163" readonly></textarea>
                </div>
                
                </form>
            </div>

        </div>

        <div class="add_section">
            <div class="add_section_content">
                <div class="title_input">
                <form action="" method="post">
                        <input type="text" value="" name="title" placeholder="title">

                    </div>

                <div class="main_input">

                        <textarea  rows="" cols="" value="" name="main" placeholder="specefication"></textarea>
                    </div>

                <div class="add_button">

                        <input type="submit" name="add" value="add">
                    </form>

                </div>
            </div>
        </div>

    </body>
</html>


<?php 


$stmt = $pdo->query("SELECT * FROM $tableName");
while($row = $stmt->fetch()){
    
    $id = $row->id;
    $title = $row->title;
?>

<script>

var leftSide = document.querySelector(".left_side");

            var titlePlace = document.createElement("div");
            var title = document.createElement("div");
            titlePlace.className = "title_place";
            title.className = "title";

            title.innerHTML = `<?php echo $id . "- " . $title?>`;
            
            titlePlace.appendChild(title);
            leftSide.appendChild(titlePlace);

            var images = document.createElement("div");
            var Delete = document.createElement("div");
            var edit = document.createElement("div");


            images.className = "images";
            Delete.className = "delete";
            edit.className = "edit";
            Delete.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" viewBox="0 0 24 24" fill="none"><path d="M5 5L19 19M5 19L19 5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>`;
            edit.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="1.5rem" viewBox="0 0 24 24" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M20.8477 1.87868C19.6761 0.707109 17.7766 0.707105 16.605 1.87868L2.44744 16.0363C2.02864 16.4551 1.74317 16.9885 1.62702 17.5692L1.03995 20.5046C0.760062 21.904 1.9939 23.1379 3.39334 22.858L6.32868 22.2709C6.90945 22.1548 7.44285 21.8693 7.86165 21.4505L22.0192 7.29289C23.1908 6.12132 23.1908 4.22183 22.0192 3.05025L20.8477 1.87868ZM18.0192 3.29289C18.4098 2.90237 19.0429 2.90237 19.4335 3.29289L20.605 4.46447C20.9956 4.85499 20.9956 5.48815 20.605 5.87868L17.9334 8.55027L15.3477 5.96448L18.0192 3.29289ZM13.9334 7.3787L3.86165 17.4505C3.72205 17.5901 3.6269 17.7679 3.58818 17.9615L3.00111 20.8968L5.93645 20.3097C6.13004 20.271 6.30784 20.1759 6.44744 20.0363L16.5192 9.96448L13.9334 7.3787Z" fill="#0F0F0F"/></svg>`

            images.appendChild(Delete);
            images.appendChild(edit);
            titlePlace.appendChild(images);
            leftSide.appendChild(titlePlace);    
</script>

<?php } ?>




<script>

// const active =document.querySelector(".active");
let title_place =document.querySelector(".title_place");
let titles =document.querySelectorAll(".title");

titles.forEach(element => {
    // element.parentElement.parentElement.toggle("active");
    element.addEventListener("click",function(){
        // element.parentElement.classList.add("active");
        let id = element.childNodes[0].textContent.split("-")[0];
        // console.log(title);
        // console.log(title.length);
        // let test = element.childNodes[0].textContent.split("-")[0];
        // console.log(test);
        // console.log(test.length);
        window.location.href = "to do list.php?id=" + encodeURIComponent(id);
        
        // console.log(js_value);
        // console.log(js_value.length);
        
    })
    
    // element.parentElement.classList.remove("active");
});
</script>

<?php $id = $_GET['id']; { ?>

<script>
var mainText = document.querySelector("textarea");
mainText.value = `<?php 

        $sql = "SELECT * FROM $tableName WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $to_do = $stmt->fetch();
        echo $to_do->body; ?>`;

</script>

<?php } ?>

<script>

    let editImages = document.querySelectorAll(".edit");
    let submitButton = document.querySelector(".submitButton");
    let body =document.querySelector("textarea");
    editImages.forEach(element => {
        element.addEventListener("click", function(){
            let id = element.parentElement.parentElement.children[0].textContent.split("-")[0];
            // window.location.href = "to do list.php?id=" + encodeURIComponent(id);
            body.readOnly = false;
            submitButton.style.visibility = 'visible';
            // var id = element.parentElement.parentElement.children[0].textContent.split("-")[0];
            // window.location.href = "to do list.php?idMod=" + encodeURIComponent(id);
        })

        submitButton.addEventListener("click",function(){
            submitButton.style.visibility = 'hidden';
            // window.location.href = "to do list.php?bd=" + encodeURIComponent(body.value);
        })
    });

</script>
<?php 
// echo $_SERVER["REQUEST_URI"] 
?>
<?php 
// echo $_SERVER["REQUEST_URI"];
//     $bd = $_GET['bd'];
//     echo $bd;
//     echo $bd;
//     echo $bd;
//     echo $bd;

    // $sql = "DELETE FROM $tableName WHERE id = :id LIMIT 1";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(['id' => $idMod]);

    // $sql = "UPDATE $tableName SET body = :body WHERE body = :body";
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute(['body'=> $bd, 'id' => $id]);
    // echo 'Post Updated';

    // header("Location: " . $_SERVER["REQUEST_URI"]);    
?>



<script>

    let deleteImages = document.querySelectorAll(".delete");
    deleteImages.forEach(element => {
        element.addEventListener("click", function(){
            let idDel = element.parentElement.parentElement.children[0].textContent.split("-")[0];
            console.log(idDel);
            window.location.href = "to do list.php?idDel=" + encodeURIComponent(idDel);
            exit();
        })
    });
    
</script>
<?php 
    $idDel = $_GET['idDel'];
    $sql = "DELETE FROM $tableName WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $idDel]);
    header("Location: " . $_SERVER["REQUEST_URI"]);    
?>