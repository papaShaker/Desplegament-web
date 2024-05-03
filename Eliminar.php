<?php

require_once('Connexio.php');

class Eliminar {
    function eliminarProducte($id) {
        // Verifica si todos los campos requeridos están presentes
        if (!isset($id)) {
            echo '<p>Se requiere del ID para eliminar el producto.</p>';
            return;
        }

        // Crea una instancia de la clase de conexión
        $conexionObj = new Connexio();

        // Obtiene la conexión a la base de datos
        $conexion = $conexionObj->obtenirConnexio();

        // Construye la consulta SQL
        $consulta = "DELETE FROM productes WHERE id = '$id'";

        // Ejecuta la consulta y muestra un mensaje de éxito o error
        if ($conexion->query($consulta) === TRUE) {
            echo '<meta http-equiv="refresh" content="0; url=Principal.php">';
            exit();
        } else {
            // Muestra un mensaje de error si la consulta falla
            echo '<p>Error al intentar eliminar el producto: ' . $conexion->error . '</p>';
        }

        // Cierra la conexión a la base de datos
        $conexion->close();
    }
}

// Crea una instancia de la clase Eliminar
$eliminar = new Eliminar();

// Verificar si el formulario ha sido enviado
if(isset($_GET['id'])) {
    // Retrieve the ID from the URL
    $id = $_GET['id'];

    $eliminar->eliminarProducte($id);
} else {
    // Si el formulario no ha sido enviado, redirige a la página principal.
    echo '<meta http-equiv="refresh" content="0; url=Principal.php">';
}