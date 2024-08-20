<?php
class Cconexion {
    public static function ConexionBD() {
        $hostname = 'localhost';
        $dbname = 'Barberia';
        $username = 'sa';
        $password = '369';
        $puerto = 1433;

        try {
            $conn = new PDO("sqlsrv:Server=$hostname,$puerto;Database=$dbname", $username, $password);
            return $conn;
        } catch (PDOException $exp) {
            echo "No se logró conectar correctamente con la base de datos: $dbname, error: " . $exp->getMessage();
            return null;
        }
    }
}
?>
