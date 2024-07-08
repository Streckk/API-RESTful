<?php 

    include 'includes/Database.php';
    include 'includes/UsuarioAPI.php';


    $database = new Database();
    $db = $database->getConnection();

    $usuarioapi = new UsuarioAPI($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $nombre = $data['nombre'] ?? '';
    $apellidos = $data['apellidos'] ?? '';
    $Edad = $data['edad'] ?? '';
    $correo = $data['email'] ?? '';
    $usuario = $data['usuario'] ?? '';
    $contrasena = $data['contrasena'] ?? '';

    if ($usuarioapi->crearUsuario($nombre, $apellidos, $Edad, $correo, $usuario, $contrasena)) {
        http_response_code(201);
        echo json_encode(array("message" => "Usuario creado exitosamente."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error al crear el usuario."));
    }
   } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $usuarios = $usuarioapi->ObtenerUsuarios();
        header('Content-Type: application/json');
        echo json_encode($usuarios);
   }


?>