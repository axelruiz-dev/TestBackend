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
    $sql = "INSERT INTO servicios(nombre) VALUES (:nombre)";
        
    try {
      $statement = $dbConn->prepare($sql);
      bindAllValues($statement, $input);

      $statement->execute();
     
      $postId = $dbConn->lastInsertId();
      if($postId)
      {
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
    if (isset($_GET['id']))
    {
      //Mostrar un servicios
      $sql = $dbConn->prepare("SELECT * FROM servicios where id_servicio=:id");
      $sql->bindValue(':id', $_GET['id']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }
    else {
      //Mostrar lista de servicios
      $sql = $dbConn->prepare("SELECT * FROM servicios");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
	}
    //=========================================================
    break;
  case 'PUT':
    //=========================================================
    $_PUT   = json_decode(file_get_contents('php://input'),true);
    $input  = $_PUT;
    $postId = $input['id_servicio'];
    $fields = getParams($input);

    $sql = "UPDATE servicios SET $fields  WHERE id_servicio='$postId' ";

    try {  
      $statement = $dbConn->prepare($sql);
      bindAllValues($statement, $input);

      $statement->execute();
      header("HTTP/1.1 200 OK");
      exit();
      } catch (Exception $e) {
      echo 'Excepción capturada: ', $e->getMessage(), "\n";
    }    
    //=========================================================
    break; 
  case 'DELETE':
    //=========================================================
    $id = $_GET['id'];
    $statement = $dbConn->prepare("DELETE FROM servicios where id=:id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();  
    //=========================================================
    break; 
  
  default:
    //En caso de que ninguna de las opciones anteriores se haya ejecutado
    header("HTTP/1.1 400 Bad Request");
    break;
}

?>





<?php
include "../private/config.php";
include "../private/utils.php";


$dbConn =  connect($db);


header("Content-Type: application/json");
/*
  listar todos los servicios o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
 // $_GET = json_decode(file_get_contents('php://input'),true);
    
}

// Crear un nuevo servicio
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
	$id = $_GET['id'];
  $statement = $dbConn->prepare("DELETE FROM servicios where id=:id");
  $statement->bindValue(':id', $id);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
   
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>