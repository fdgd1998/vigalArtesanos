<?php
    session_start();
    require_once '../../../scripts/check_session.php';
    require_once '../../../../connection.php';
    // Publishers cannot modify categories.
    if ($_POST && $_SESSION['account_type'] != 'publisher') {
        try {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            if ($conn->connect_error) {
                print("No se ha podido conectar a la base de datos");
                exit();
            } else {
                $stmt = "update categories set cat_enabled='".$status."' where id=".$id; //Updating category.
                if ($conn->query($stmt) === TRUE) {
                    echo "El estado de la categoría se ha cambiado correctamente";
                }
                $conn->close();
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>