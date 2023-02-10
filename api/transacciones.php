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

    $sql = " INSERT INTO transacciones(id_servicio,id_usuario,numero_comprobante,monto_deuda,monto_abonado,estado,fecha,hora) 
    VALUES (:id_servicio,:id_usuario,:numero_comprobante,:monto_deuda,:monto_abonado,:estado,:fecha,:hora) ";
           
    try {   
      $statement = $dbConn->prepare($sql);
      bindAllValues($statement, $_POST);

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
      $sql = $dbConn->prepare("SELECT * FROM transacciones where id_transaccion=:id");
      $sql->bindValue(':id', $_GET['id']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
    
      exit();
	  }
    else if (isset($_GET['id_servicio']))
    {
      //Mostrar transacciones por servicio      
      $sql = $dbConn->prepare("SELECT * FROM transacciones where id_servicio in ( :id_servicio )");
      $sql->bindValue(':id_servicio', $_GET['id_servicio']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }    
    else if (isset($_GET['id_usuario']))
    {
      //Mostrar transacciones por usuarios    
      $sql = $dbConn->prepare("SELECT * FROM transacciones where id_usuario in ( :id_usuario )");
      $sql->bindValue(':id_usuario', $_GET['id_usuario']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }    
    else if (isset($_GET['fecha']))
    {
      //Mostrar un servicios
      $sql = $dbConn->prepare("SELECT * FROM transacciones where fecha in ( :fecha )");
      $sql->bindValue(':fecha', $_GET['fecha']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }    
    else if (isset($_GET['estado']))
    {
      //Mostrar un servicios
      $sql = $dbConn->prepare("SELECT * FROM transacciones where estado in ( :estado )");
      $sql->bindValue(':estado', $_GET['estado']);
      $sql->execute();
      header("HTTP/1.1 200 OK");
      echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
      exit();
	  }    
    else
    {
      //Mostrar lista de servicios
      $sql = $dbConn->prepare("SELECT * FROM transacciones");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
	  }
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
// Registrar nuevo usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{   
    
}

//Obtiene el usuario para validar los datos
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
 // $_GET = json_decode(file_get_contents('php://input'),true);
    
}




//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>