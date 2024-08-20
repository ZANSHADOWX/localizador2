<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $conn = Cconexion::ConexionBD();
    
    if ($conn) {
        try {
            $stmt = $conn->prepare('INSERT INTO usuarios (name, email, username, password) VALUES (:name, :email, :username, :password)');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();
            
            // Redirigir a la página principal después de la creación de la cuenta
            header('Location: login.html');
            exit();
        } catch (PDOException $e) {
            echo "Error al registrar el usuario: " . $e->getMessage();
        }
    }
}
?>
