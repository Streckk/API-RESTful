<?php 

    class UsuarioAPI{
        private $conn;

        public function __construct($db){
            $this->conn = $db;
        }
    
        public function ObtenerUsuarios(){
            $sql = "SELECT * FROM usuarios";
            $result = $this->conn->query($sql);

            $usuarios = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $usuarios[] = $row;
                }
            }
            return $usuarios;
        }
        public function crearUsuario($nombre,$apellidos,$Edad,$correo,$usuario,$contrasena) {
            $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nombre, apellidos, Edad, correo, usuario, contrasena) VALUES (?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($sql);

            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->conn->error));
            }

            $stmt->bind_param("ssssss", $nombre,$apellidos,$Edad,$correo,$usuario,$hashedPassword);

            if ($stmt->execute()) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                http_response_code(500);
                return false;
            }
        }
    }

?>