//NO TOCAR SI NO SABEN XD

<?php
require 'conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nombre = $_POST['name'] ?? '';
    $telefono = $_POST['phone'] ?? '';
    $estilista_id = $_POST['stylist'] ?? '';
    $paquete_id = $_POST['package'] ?? '';
    $tipo_corte_id = $_POST['tipo_corte'] ?? null; 
    $corte_id = $_POST['corte'] ?? null; 
    $fecha = $_POST['date'] ?? '';
    $hora = $_POST['time'] ?? '';
    $notas = $_POST['notes'] ?? '';

    
    $conn = Cconexion::ConexionBD();

    if ($conn) {
        try {
            
            if ($paquete_id) {
                $sql_check_paquete = "SELECT 1 FROM Paquetes WHERE id = :paquete_id";
                $stmt_check_paquete = $conn->prepare($sql_check_paquete);
                $stmt_check_paquete->execute([':paquete_id' => $paquete_id]);
                if (!$stmt_check_paquete->fetchColumn()) {
                    throw new Exception("El paquete con ID $paquete_id no existe.");
                }
            }

            if ($tipo_corte_id) {
                $sql_check_tipo_corte = "SELECT 1 FROM TiposCorte WHERE id = :tipo_corte_id";
                $stmt_check_tipo_corte = $conn->prepare($sql_check_tipo_corte);
                $stmt_check_tipo_corte->execute([':tipo_corte_id' => $tipo_corte_id]);
                if (!$stmt_check_tipo_corte->fetchColumn()) {
                    throw new Exception("El tipo de corte con ID $tipo_corte_id no existe.");
                }
            }

            if ($corte_id) {
                $sql_check_corte = "SELECT 1 FROM Cortes WHERE id = :corte_id";
                $stmt_check_corte = $conn->prepare($sql_check_corte);
                $stmt_check_corte->execute([':corte_id' => $corte_id]);
                if (!$stmt_check_corte->fetchColumn()) {
                    throw new Exception("El corte con ID $corte_id no existe.");
                }
            }

            
            $sql = "INSERT INTO Citas (nombre, telefono, estilista_id, paquete_id, tipo_corte_id, corte_id, fecha, hora, notas)
                    VALUES (:nombre, :telefono, :estilista_id, :paquete_id, :tipo_corte_id, :corte_id, :fecha, :hora, :notas)";
            
            $stmt = $conn->prepare($sql);
            
            // Ejecutar la consulta
            $stmt->execute([
                ':nombre' => $nombre,
                ':telefono' => $telefono,
                ':estilista_id' => $estilista_id,
                ':paquete_id' => $paquete_id,
                ':tipo_corte_id' => $tipo_corte_id,
                ':corte_id' => $corte_id,
                ':fecha' => $fecha,
                ':hora' => $hora,
                ':notas' => $notas
            ]);

            
            header("Location: confirmacion.html");
            exit();
        } catch (PDOException $e) {
        
            header("Location: error.html");
            exit();
        } catch (Exception $e) {
            
            header("Location: error.html");
            exit();
        }
    } else {
        
        header("Location: error.html");
        exit();
    }
}
?>
