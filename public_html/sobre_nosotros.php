<?php
    require_once "scripts/get_company_info.php";
    
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
    $services = array(); // Array to save categories
    $page_id = 7;

    try {
        if ($conn->connect_error) {
            echo "No se ha podido establecer una conexión con la base de datos.";
            exit();
        } else {
            // Fetching categories from database and storing then in the array for further use.

            // Getting page metadata
            $sql = "select title, description from pages_metadata where id_page = (select id from pages where id = ".$page_id.")";  
            if ($res = $conn->query($sql)) {
                $rows = $res->fetch_assoc();
                $page_title = $rows['title'];
                $page_description = $rows['description'];
                $res->free();
            }
        }
    } catch (Exception $e) {
        echo $e;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$page_title." | ".$GLOBALS["site_settings"][2]?></title>
    <meta name="description" content="<?=$page_description?>">
    <meta name="robots" content="index, follow">
    <link rel="icon" href="./includes/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./includes/css/footer.css">
    <link rel="stylesheet" href="./includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="./includes/css/styles.css">
    <link rel="stylesheet" href="./includes/fonts/fontawesome-all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5GCTKSYQEQ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-5GCTKSYQEQ');
    </script>
</head>

<body>
    <?php
        require_once "./scripts/check_maintenance.php";
        include './includes/header.php';
    ?>
    <div class="container content">
        <h1 class="title">Sobre nosotros</h1>
        <?=$GLOBALS["site_settings"][9]?>
    </div>

    <?php
        include './includes/footer.php';
    ?>
    <!-- SB Forms JS -->
    <script src="./includes/js/jquery.min.js"></script>
    <script src="./includes/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>