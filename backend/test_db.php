<?php
require_once "../backend/config/db.php";

if ($conn->connect_error) {
    echo "❌ Error: " . $conn->connect_error;
} else {
    echo "✅ Conectado correctamente a la base de datos: " . $conn->host_info;
}
?>