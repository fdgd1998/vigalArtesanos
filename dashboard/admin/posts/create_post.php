<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header("Location: ../../../../403.php");
        exit();
    }

    require_once '../../../modules/connection.php';

    if ($_POST) {
        $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

        if ($conn->connect_error) {
            echo "No se ha podido conectar a la base de datos.";
            exit();
        } else {
            $location = $_SERVER["DOCUMENT_ROOT"]."/uploads/posts/";

            if ($_POST["file_count"] == 1) {
                $temp = explode(".", $_FILES["image"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);
                move_uploaded_file($_FILES['image']['tmp_name'],$location.$newfilename);

                $stmt = "insert into posts (author, category, title, content, images) values ('".$_SESSION["user"]."', '".$_POST["category"]."', '".$_POST["title"]."', '".$_POST["content"]."', '".$newfilename."')";
                if ($conn->query($stmt) == TRUE) {
                    echo "La entrada se ha creado correctamente.";
                } else {
                    echo "No se ha podido crear la entrada.";
                }
            } else {
                $userid = 0;
                $fileNames = "";
                $i = 0;
                $sql = "select id from users where username = '".$_SESSION['user']."'";
                if ($res = $conn->query($sql)) {
                    $rows = $res->fetch_assoc();
                    $userid = $rows['id'];
                }
                $res->free();
                foreach ($_FILES as $file) {
                    $temp = explode(".", $file["name"]);
                    $newfilename = round(microtime(true)+$i).$userid.'.'.end($temp);
                    move_uploaded_file($file['tmp_name'],$location.$newfilename);
                    $fileNames .= $newfilename.",";
                    $i++;
                }
                $fileNames = substr($fileNames, 0, -1);
                
                $stmt = "insert into posts (author, category, title, content, images) values ('".$_SESSION["user"]."', '".$_POST["category"]."', '".$_POST["title"]."', '".$_POST["content"]."', '".$fileNames."')";
                if ($conn->query($stmt) === TRUE) {
                    echo "La entrada se ha creado correctamente.";
                } else {
                    echo "No se ha podido crear la entrada";
                }
            }
        }
        $conn->close();
    }
?>