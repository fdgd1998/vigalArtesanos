<?php
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_company_info.php";
    require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/get_uri.php";

    $services = array(); // Array to save categories
    $page_id = 8;
    
    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
    
    if ($GLOBALS["site_settings"][11] == "false" || ($GLOBALS["site_settings"][11] == "true" && isset($_SESSION["loggedin"]))) {
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
                $conn->close();
            }
        } catch (Exception $e) {
            include $_SERVER["DOCUMENT_ROOT"]."/errorpages/500.php";
            exit();
        }
    } else {
        $conn->close();
        require_once $_SERVER["DOCUMENT_ROOT"]."/scripts/set_503_header.php";
        set_503_header();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ($GLOBALS["site_settings"][11] == "false"): ?>
    <title><?=$page_title." | ".$GLOBALS["site_settings"][2]?></title>
    <meta name="description" content="<?=$page_description?>">
    <meta name="robots" content="index, follow">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5GCTKSYQEQ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-5GCTKSYQEQ');
    </script>
    <?php else: ?>
    <title>Página en mantenimiento</title>
    <?php endif; ?>
    <link rel="icon" href="./includes/img/favicon.ico" type="image/x-icon">
    <link rel="canonical" href="<?=GetUri();?>">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/footer.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/Navigation-Clean.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/css/styles.css">
    <link rel="stylesheet" href="<?=GetBaseUri()?>/includes/fonts/fontawesome-all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Great Vibes' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Quicksand">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        .map-responsive{
            overflow:hidden;
            padding-bottom:56.25%;
            position:relative;
            height:0;
            margin-bottom: 40px;
        }

        .map-responsive iframe{
            left:0;
            top:0;
            height:100%;
            width:100%;
            position:absolute;
        }
    </style>
    
</head>

<body>
<?php
    if ($GLOBALS["site_settings"][11] == "true" && !isset($_SESSION["loggedin"])) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_page.php";
        exit();
    }
    if ($GLOBALS["site_settings"][11] == "true" && isset($_SESSION["loggedin"])) {
        include $_SERVER["DOCUMENT_ROOT"]."/snippets/maintenance_message.php";
    }
    include $_SERVER["DOCUMENT_ROOT"].'/includes/header.php';
    ?>
    <div class="container content">
        <h1 class="title">Contacto</h1>
        <p class="title-description">Si quieres pedir más información, preguntar precios, pedir un presupuesto o preguntar cualquier otra cosa, no dudes en contactar con nosotros. ¡Estaremos encantados de atenderte!</p>
        <p class="title-description">También puedes usar el formulario de contacto al final de esta página.</p>
        <div class="row">
            <div class="col-lg-7">
                <p class="address"><?=$GLOBALS["site_settings"][1]?></p>
                <a class="contact-data" href="tel:<?=str_replace(' ','',$GLOBALS["site_settings"][0])?>"><?=$GLOBALS["site_settings"][0]?></a>
                <a class="contact-data" href="mailto:<?=$GLOBALS["site_settings"][3]?>"><?=$GLOBALS["site_settings"][3]?></a>
                <?php if (isset($GLOBALS["site_settings"][4]["whatsapp"])):?>
                    <a class="contact-data whatsapp" data-bs-hover-animate="pulse" target="blank" href="https://wa.me/<?=$GLOBALS["site_settings"][4]["whatsapp"]?>"><i class="fab fa-whatsapp fa-w-16"></i>WhatsApp</a>
                <?php endif; ?>
                <?php if (isset($GLOBALS["site_settings"][4]["instagram"])):?>
                    <a class="contact-data instagram" data-bs-hover-animate="pulse" target="blank" href="https://www.instagram.com/<?=$GLOBALS["site_settings"][4]["instagram"]?>"><i class="fab fa-instagram"></i>@<?=$GLOBALS["site_settings"][4]["instagram"]?></a>
                <?php endif; ?>
                <?php if (isset($GLOBALS["site_settings"][4]["facebook"])):?>
                    <a class="contact-data facebook" data-bs-hover-animate="pulse" target="blank" href="https://www.facebook.com/<?=$GLOBALS["site_settings"][4]["facebook"]?>"><i class="fab fa-facebook-square"></i>@<?=$GLOBALS["site_settings"][4]["facebook"]?></a>
                <?php endif; ?>
            </div>
            <div class="col-lg-5">
                <h2 class="title">Horarios</h2>
                <ul class="timetable">
                    <?php $i = 0; foreach ($GLOBALS["site_settings"][8] as $dia=>$horario): ?>
                        <li><?=$dia.": <strong>".$horario."</strong>"?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2 class="title">Ubicación</h2>
                <div class="map-responsive">
                    <iframe class="w-100" src="<?=$GLOBALS["site_settings"][7]?>" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-2 col-lg-3"></div>
            <div class="col-12 col-sm-8 col-lg-6">
                <h2 class="title">Formulario de contacto</h2>
                <div class="mb-3">
                    <label>Nombre:</label>
                    <input type="text" class="form-control" id="nombre">
                    <div class="invalid-feedback">
                        Introduce un nombre.
                    </div>
                </div>
                <div class="mb-3">
                    <label>Email:</label>
                    <input type="email" class="form-control" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                    <div class="invalid-feedback">
                        Introduce un email válido.
                    </div>
                </div>
                <div class="mb-3">
                    <label>Motivo de contacto:</label>
                    <select class="custom-select" id="motivo">
                        <option value="duda" selected>Consultar duda</option>
                        <option value="precio">Pedir precio</option>
                        <option value="presupuesto">Pedir presupuesto</option>
                        <option value="otro">Otra consulta</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Mensaje:</label>
                    <textarea rows="5" id="mensaje" class="form-control"></textarea>
                    <div class="invalid-feedback">
                        El mensaje no puede estar vacío.
                    </div>
                </div>
                <div class="g-recaptcha brochure__form__captcha" data-callback="recaptchaCallback" data-expired-callback="recaptchaExpired" data-sitekey="6LcpXp0dAAAAAIyqkuLt2hPzrYXE_eJv6adylhP8"></div>
                <div class="button-group text-right">
                    <button disabled style="margin-top: 10px;" class="btn my-button" id="submit-message">Enviar</button>
                </div>
            </div>
            <div class="col-12 col-sm-2 col-lg-3"></div>
        </div>
    </div>

    <?php
        include $_SERVER["DOCUMENT_ROOT"].'/includes/footer.php';
    ?>
    <script src="<?=GetBaseUri()?>/includes/js/jquery.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=GetBaseUri()?>/includes/js/contact.js"></script>
    <script src="<?=GetBaseUri()?>/dashboard/js/hide_spinner.js"></script>
    <script src="<?=GetBaseUri()?>/dashboard/js/show_spinner.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</body>
</html>