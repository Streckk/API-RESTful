<?php 

    class Database{
      private  $servername = "localhost";
      private  $username = "root";
      private  $password = "tumama123"; 
      private  $dbname = "registros"; 
      private  $port = 33065;
      public $conn;


      public function getConnection(){
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname,$this->port);
            echo "Conexión exitosa a la base de datos";
        } catch (Exception $e) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
      }

    }
?>