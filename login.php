<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = Cconexion::ConexionBD();
    
    if ($conn) {
        $stmt = $conn->prepare('SELECT password FROM usuarios WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Iniciar sesión
            session_start();
            $_SESSION['username'] = $username; // Guardar el nombre de usuario en la sesión
            
            // Redirigir a la página principal
            header('Location: Index.html');
            exit();
        } else {
            echo "Nombre de usuario o contraseña incorrectos.";
        }
    }
}
?>
