<?php
function login_check()
{
  return isset($_SESSION['user_login_checked']) ? $_SESSION['user_login_checked'] : false;
}


function getCategorias($mysqli, $todas = true) {
  $query = "SELECT * FROM categorias WHERE 1 = 1";
  if (!$todas) 
  {
    $query .= " and habilitada = 1";
  }
  $query .= " ORDER BY id desc";
  
  $resultado = $mysqli->query($query); 
  
  return $resultado;  
      
}

function getCategoria($mysqli, $id) {
  $query = "SELECT * FROM categorias WHERE id = ".$id;
  $resultado = $mysqli->query($query);
  $row = $resultado->fetch_assoc();
  
  if ($resultado) {
    $resultado->free();
  }
 
  return $row;
}

function getSubCategoria($mysqli, $id) {
  $query = "SELECT * FROM subcategorias WHERE id =".$id;
  $resultado = $mysqli->query($query);
  $subcategorias = array();
  while ($respuesta = $resultado->fetch_assoc()) {
    $subcategorias[] = $respuesta;
  }
  if ($resultado) {
    $resultado->free();
  }
  return $subcategorias;
}

function getSubCategorias($mysqli, $todas = true) {
  $query = "SELECT * FROM subcategorias WHERE 1 = 1";
  if (!$todas) {
    $query .= " and habilitada = 1";
  }
  $query .= " ORDER BY id desc";
  $resultado = $mysqli->query($query);
  $subcategorias = array();
  while ($respuesta = $resultado->fetch_assoc()) {
    $subcategorias[] = $respuesta;
  }
  if ($resultado) {
    $resultado->free();
  }
  return $subcategorias;
}

function getSubCategoriasFromCat($mysqli, $cat) {   
  $query = "SELECT * FROM subcategorias WHERE cat_id = " . $cat;
  $query .= " ORDER BY id desc";
  
  $resultado = $mysqli->query($query);
 
  return $resultado;
}

function getApunte($mysqli, $id)
{
  $query = "SELECT * FROM apuntes ";

  if (is_numeric($id)) {
    $query .= "WHERE id = $id ";
  } else {
    return array();
  }
  $query .= " and habilitada = 1";
  $resultado = $mysqli->query($query);

  $respuesta = $resultado->fetch_assoc();

  if($resultado)$resultado->free();

  return $respuesta;
}

function getApuntes($mysqli, $todas = true) {
  $query = "SELECT * FROM apuntes WHERE 1 = 1";
  if (!$todas) {
    $query .= " and habilitada = 1";
  }
  $query .= " ORDER BY id desc";
  $resultado = $mysqli->query($query);
  $apuntes = array();
  while ($respuesta = $resultado->fetch_assoc()) {
    $apuntes[] = $respuesta;
  }
  if ($resultado) {
    $resultado->free();
  }
  return $apuntes;
}

function getApuntesFromCategoria($mysqli, $id)
{
  $query = "SELECT * FROM apuntes WHERE cat_id = $id";

  $resultado = $mysqli->query($query);

  return $resultado;
}

function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
      header("Location: error.php?err=Could not initiate a safe session (ini_set)");
      exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],$cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
  }

  function getMensaje($state, $user = ''){
    switch ($state) {
      case 0:
      if (isset($user)) {
        $mensaje = "Bienvenido " . $user;
      }
      break;
      case 1:
      $mensaje = "Bienvenido ". $user ."<br> Por favor, revise su email para validar su cuenta";
      break;
      case 2:
      $mensaje = "Falta completar algún campo";
      break;
      case 3:
      $mensaje = "Contraseña incorrecta";
      break;
      case 4:
      $mensaje = "Email No encontrado, por favor, registrese";
      break;
      case 5:
      $mensaje = "Por favor, complete todos los campos";
      break;
      case 6:
      $mensaje = "El usuario ya se encontraba registrado. <br> Bienvenido " . $user;
      break;
      case 7:
      $mensaje = "Ese email se encuentra en uso, por favor, elija otro, o ingrese a su cuenta";
      break;
      case 8:
      $mensaje = "Codigo de confirmación Invalido";
      break;
      case 9:
      $mensaje = "Bienvenido ". $user ."<br> Hemos registrado tu usuario, pero no hemos podido enviarte un correo para validar tu cuenta. Por favor, ponte en contacto con nostros en cualquiera de nuestros puntos de recarga para solucionar este problema";
      break;
      case 10:
      $mensaje = "Usuario Validado Correctamente";
      break;
      case 11:
      $mensaje = "Usuario No encontrado";
      break;
      default:
      $mensaje = "Bienvenido...";
      break;
    }
    return $mensaje;
  }

function uploadFile($file, $cat, $subcat) {
  if ($file['error'] !== UPLOAD_ERR_OK) {
    $message = "Upload failed with error " . $file['error'];
    return array("message"=>$message, "ok"=>false);
  }
  $finfo = finfo_open(FILEINFO_MIME_TYPE);
  $mime = finfo_file($finfo, $file['tmp_name']);
  $ok = false;
  switch ($mime) {
     case 'application/pdf':
          $ok = true;
          break;
     default:
         return array("message"=>"Unknown/not permitted file type", "ok"=>false);
         break;
  }

  $ruta = '../uploads/'. $cat . '/' . $subcat;
  if (!file_exists($ruta)) {
    mkdir($ruta, 0777, true);
  }
  $ruta .= '/' . $file['name'];

  move_uploaded_file($file['tmp_name'], $ruta);

  return array("message"=>"ok", "ok"=>true, "ruta"=>$ruta);
}

function getUsuariosAdministradores($mysqli) {
  $query = "SELECT * FROM usuarios where grup <> 0 ORDER BY id desc";
  
  $resultado = $mysqli->query($query); 
  
  return $resultado;  
      
}

function getUsuario($mysqli, $id) {
  $query = "SELECT * FROM usuarios WHERE id = $id";
  
  $resultado = $mysqli->query($query); 
  
  return $resultado->fetch_assoc();
      
}

function getUsuarios($mysqli) {
  $query = "SELECT * FROM usuarios";
  
  $resultado = $mysqli->query($query); 
  
  return $resultado;
      
}

function getUsuariosNoAdmin($mysqli) {
  $query = "SELECT * FROM usuarios WHERE grup = 0";
  
  $resultado = $mysqli->query($query); 
  
  return $resultado;
      
}

function getSaldos($mysqli) {
  $query = "SELECT * FROM saldos";

  $resultado = $mysqli->query($query);

  return $resultado;
}

function getSaldo($mysqli, $id) {
  $query = "SELECT * FROM saldos WHERE id_usuario = $id";

  $resultado = $mysqli->query($query);
  $saldo = $resultado->fetch_assoc();
  return ($saldo['saldo']) ? $saldo['saldo'] : 0;
}

function getHistorial($mysqli) {
  $query = "SELECT * FROM historial";

  $resultado = $mysqli->query($query);
  
  return $resultado;
}

function getPedidos($mysqli) {
  $query = "SELECT * FROM pedidos";

  $resultado = $mysqli->query($query);
  
  return $resultado;
}

function getHistorialForUser($mysqli, $id) {
  $query = "SELECT * FROM historial WHERE id_usuario = $id";

  $resultado = $mysqli->query($query);
  
  return $resultado;
}

function getUsuarioByEmail($mysqli, $email)
{
  $query = "SELECT * FROM usuarios WHERE email = '$email'";
  
  $resultado = $mysqli->query($query);

  return $resultado->fetch_assoc();
}