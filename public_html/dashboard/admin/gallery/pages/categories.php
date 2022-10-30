<?php
    session_start(); // starting the session.
    require_once dirname($_SERVER["DOCUMENT_ROOT"], 1).'/connection.php';
    require_once $_SERVER["DOCUMENT_ROOT"].'/dashboard/scripts/check_permissions.php';
    
    if (!HasPermission("manage_categories")) {
        include $_SERVER["DOCUMENT_ROOT"].'/dashboard/includes/forbidden.php';
        exit();
    }

    if (isset($_GET['order'])) $order = $_GET['order']; // getting order if GET variable is set.

    $conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name); // Opening database connection.
    $categories = array();

    if ($conn->connect_error) {
      print("No se ha podido conectar a la base de datos");
      exit();
    } else {
        // Fetching categories from databases and sorting them.
        $sql = "";
        if ($_SESSION["account_type"] == "superuser" || $_SESSION["account_type"] == "administrator") {
          $sql = "select * from categories ";
        } else {
          $sql = "select * from categories where uplodadedBy = ".$_SESSION["userid"];
        }
        
        if (isset($_GET['order'])) {
          switch($_GET['order']) {
            case 'asc':
              $sql .= " order by name asc";
              break;
            case 'desc':
              $sql .= " order by name desc";
              break;
            default:
              $sql .= " order by name asc";
          } 
        } else {
          $sql .= " order by name asc";
        }
        ;
        if ($res = $conn->query($sql)) {
          while ($rows = $res->fetch_assoc()) {
            array_push($categories, array ("id" => $rows["id"], "name" => $rows["name"]));
          }
        } else {
          echo "No hay resultados.";
        }
    }
    $conn->close();
?>

<!-- Delete category modal -->
<div class="modal fade" id="delete-cat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel-delete" >Editando categoría ...</h5>
          <button id="close-edit-cat" type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="modal-body" class="modal-body">
          <p>¿Estás seguro de que deseas borrar esta categoría? No podrás borrarla si hay imágenes que pertenecen a ella.</p>
        </div>
        <div id="modal-footer1" class="modal-footer">
          <button id="cancel-cat-delete" type="button" class="btn my-button" data-dismiss="modal"><i class="i-margin fas fa-times-circle"></i>Cancelar</button>
          <button id="cat-delete" type="button" class="btn my-button-2"><i class="i-margin fas fa-trash"></i>Borrar</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container settings-container">
<h1 class="title">Categorías</h1>
<button type="button" id="create-cat" class="btn my-button" style="margin-bottom: 15px;"><i class="far fa-plus-square" style="padding-right:5px;"></i>Crear categoría</button>

<div class="input-group mb-6" style="width: 300px; margin-bottom: 20px;">
      <div class="input-group-prepend">
        <span class="input-group-text" id="basic-addon1">Ordenar</span>
      </div>
      <select id="result-order" class="form-control">
        <option value="asc" <?=isset($order)?($order=='asc'?'selected':''):''?>>Ascendente</option>
        <option value="desc" <?=isset($order)?($order=='desc'?'selected':''):''?>>Descendente</option>
      </select>
    </div>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($categories as $item) {
                    // Showing categories on the page.
                    echo '<tr>';
                    echo '<td>'.$item['name'].'</td>';
                    echo '<td><div>';
                    echo '<a class="btn my-button-3 cat-edit-form" title="Editar categoría" id="catid-'.$item['id'].'" name="'.$item['name'].'">
                              <i class="i-margin fas fa-edit"></i>
                              Editar
                          </a>
                          <a class="btn my-button-2 cat-delete" title="Borrar categoría" id="catid-'.$item['id'].'" name="'.$item['name'].'">
                              <i class="i-margin fas fa-trash"></i>
                              Borrar
                          </a>';
                    }
                    echo '</div></td>';
                    echo '</tr>';    
                ?>
            </tbody>
        </table>
    </div>
</div>