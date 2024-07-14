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

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        handlePostRequest($usuarioapi);
        break;
    case 'GET':
        handleGetRequest($usuarioapi);
        break;
    default:
        http_response_code(405);
        echo json_encode(["message" => "Método no permitido."]);
        break;
}

function handlePostRequest($usuarioapi) {
    $data = json_decode(file_get_contents("php://input"), true);
   
    if ($data) {
        $nombre = $data['nombre'] ?? '';
        $apellidos = $data['apellidos'] ?? '';
        $Edad = $data['edad'] ?? '';
        $correo = $data['correo'] ?? '';
        $usuario = $data['usuario'] ?? '';
        $contrasena = $data['contrasena'] ?? '';

        if ($usuarioapi->crearUsuario($nombre, $apellidos, $Edad, $correo, $usuario, $contrasena)) {
            http_response_code(201);
            echo json_encode(["message" => "Usuario creado exitosamente."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Error al crear el usuario."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Datos inválidos."]);
    }
}

function handleGetRequest($usuarioapi) {
    $usuarios = $usuarioapi->ObtenerUsuarios();
    header('Content-Type: application/json');
    echo json_encode($usuarios);
}

?>
