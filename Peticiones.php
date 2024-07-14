<?php 
    include 'includes/Database.php';
    include 'includes/UsuarioAPI.php';
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
    
    $database = new Database();
    $db = $database->getConnection();

    $usuarioapi = new UsuarioAPI($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error_log('Solicitud POST recibida');
    $data = json_decode(file_get_contents("php://input"), true);
   
    if ($data) {
        error_log('Datos recibidos: ' . json_encode($data));
        $nombre = $data['nombre'] ?? '';
        $apellidos = $data['apellidos'] ?? '';
        $Edad = $data['edad'] ?? '';
        $correo = $data['correo'] ?? '';
        $usuario = $data['usuario'] ?? '';
        $contrasena = $data['contrasena'] ?? '';
    
        if ($usuarioapi->crearUsuario($nombre, $apellidos, $Edad, $correo, $usuario, $contrasena)) {
            http_response_code(201);
            echo json_encode(array("message" => "Usuario creado exitosamente."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Error al crear el usuario."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Datos inválidos."));
    }
    
   } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $usuarios = $usuarioapi->ObtenerUsuarios();
        header('Content-Type: application/json');
        echo json_encode($usuarios);
   }


?>