<?php
    session_start();
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/scripts/check_session.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/admin/gallery/scripts/get_friendly_url.php';
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/XMLSitemapFunctions.php";
    
    if (!HasPermission("manage_categories")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_POST)) {
        try {
            $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
            $image_name = "";
            $cat_name = "";
            
            if ($conn->connect_error) {
                echo "No se ha podido conectar a la base de datos.";
                exit();
            } else {
                // checking if there are posts of the category to be deleted
                $conn->begin_transaction();
                $stmt = "select count(id) as id from gallery where category = ".$_POST["cat_id"];
                if ($conn->query($stmt)->fetch_assoc()["id"]> 0) {
                    throw new Exception("Existen posts pertenecientes a esta categoría. La categoría no se puede eliminar. Para borrarla, comprueba que no existen posts de dicha categoría e inténtalo de nuevo.");
                }

                // getting filename and deleting it
                $stmt = "select friendly_url, image from categories where id = ".$_POST["cat_id"];
                    if ($res = $conn->query($stmt)) {
                        $rows = $res->fetch_assoc();
                        $image_name = $rows['image'];
                        $cat_name = $rows['friendly_url'];
                        $res->free();
                    }
                
                // deleting entry from database
                $conn->query("delete from categories where id = ".$_POST['cat_id']);
                $conn->query("delete from pages where cat_id = ".$_POST['cat_id']);
                $conn->query("delete from pages_metadata where id_page = (select id from pages where cat_id = ".$_POST['cat_id']."))");
                if ($conn->commit()) {
                    unlink($_SERVER["DOCUMENT_ROOT"]."/uploads/categories/".$image_name); // deleting the file
                    $sitemap = readSitemapXML();
                    deleteSitemapUrl($sitemap, "https://vigalartesana.es/galeria/".$cat_name);
                    writeSitemapXML($sitemap);
                    echo "La categoría se ha eliminado correctamente.";
                } else {
                    $conn->rollback();
                    echo "Ha ocurrido un error al eliminar la categoría.";
                }
            }
        } catch (Exception $e) {
            $conn->close();
            echo $e;
        }
    }
?>