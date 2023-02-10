<?php  
include "../private/config.php";
include "../private/utils.php";

$dbConn =  connect($db);

header("Content-Type: application/json");

switch ($_SERVER['REQUEST_METHOD']) {
  case 'POST':
    //=========================================================
    //Convierte texto json en formato array 
    $_POST = json_decode(file_get_contents('php://input'),true);
    $input = $_POST;

    $sql = " INSERT INTO usuarios(nombre,email,documento,saldo,estado) VALUES (:nombre,:email,:documento,:saldo,:estado) ";
        
    try {   
      $statement = $dbConn->prepare($sql);
      bindAllValues($statement, $_POST);
      //Ejecutamos el insert
      $statement->execute(); 
      
      //Obtenemos el ultimo ID insertado para devolver como respuesta
      $postId = $dbConn->lastInsertId();
      if($postId) {
        $input['id'] = $postId;
        header("HTTP/1.1 200 OK");
        echo json_encode($input);
        exit();
      }
    } catch (Exception $e) {
      echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }
    //=========================================================
    break;
  case 'GET':
    //=========================================================
    if (isset($_GET['id'])) {
      try {
        //Retorna un usuario para validacion del login 
        $sql = $dbConn->prepare("SELECT * FROM usuarios where id_usuario=:id");
        $sql->bindValue(':id', $_GET['id']);

        $sql->execute();
        
        header("HTTP/1.1 200 OK");
        echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
        exit();
      } catch (Exception $e) {
        echo 'Excepción capturada: ', $e->getMessage(), "\n";
      }

      
	  }
    //=========================================================
    break;
  
  
  default:
    //En caso de que ninguna de las opciones anteriores se haya ejecutado
    header("HTTP/1.1 400 Bad Request");
    break;
}

?>