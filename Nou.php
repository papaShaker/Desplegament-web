<?php

require_once('Connexio.php');
require_once('Header.php');

class Nou {
    public function nouProducte($nom, $descripcio, $preu, $categoria) {
        // Verifica si todos los campos requeridos están presentes
        if (!isset($nom) || !isset($descripcio) || !isset($preu) || !isset($categoria)) {
            echo '<p>Se requieren todos los campos para actualizar el producto.</p>';
            return;
        }

        // Crea una instancia de la clase de conexión
        $conexionObj = new Connexio();

        // Obtiene la conexión a la base de datos
        $conexion = $conexionObj->obtenirConnexio();

        // Escapa las variables para prevenir SQL injection
        $nom = $conexion->real_escape_string($nom);
        $descripcio = $conexion->real_escape_string($descripcio);
        $preu = $conexion->real_escape_string($preu);
        $categoria = $conexion->real_escape_string($categoria);

        // Construye la consulta SQL
        $consulta = "INSERT INTO productes (nom, descripció, preu, categoria_id)
        VALUES ('$nom', '$descripcio', '$preu', '$categoria');";

        // Ejecuta la consulta y muestra un mensaje de éxito o error
        if ($conexion->query($consulta) === TRUE) {
            echo '<meta http-equiv="refresh" content="0; url=Principal.php">';
            exit();
        } else {
            // Muestra un mensaje de error si la consulta falla
            echo '<p>Error al agregar el producto: ' . $conexion->error . '</p>';
        }
        // Cierra la conexión a la base de datos
        $conexion->close();
    }

    public function mostrarFormulari() {
            // Estructura HTML de la página
        echo '<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Llista de productes</title>
            <!-- Enlace a Bootstrap desde su repositorio remoto -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        </head>
        <body>
            <div class="container mt-5" style="margin-bottom: 100px">
                <h2>Agregar producto</h2>
                <hr>
                <form action="Nou.php" method="POST">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom:</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcio" class="form-label">Descripció:</label>
                        <input type="text" name="descripcio" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="preu" class="form-label">Preu:</label>
                        <input type="number" name="preu" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría:</label>
                        <select name="categoria" class="form-select" required>
                            <option value="1">Electrònics</option>
                            <option value="2">Roba</option>
                        </select>
                    </div>

                    <!-- Agrega más campos según sea necesario -->

                    <hr>
                    <!-- Botones de guardar y cancelar -->
                    <input type="submit" value="Guardar" class="btn btn-primary">
                    <a href="Principal.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>';
            
    // Incluye el pie de página
    require_once('Footer.php');
    }
    
}

// Crear una instancia de la clase Nou
$nou = new Nou();

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario y llama a la función nouProducte con esos datos
    $nom = $_POST['nom'] ?? '';
    $descripcio = $_POST['descripcio'] ?? '';
    $preu = $_POST['preu'] ?? '';
    $categoria = $_POST['categoria'] ?? '';

    $nou->nouProducte($nom, $descripcio, $preu, $categoria);
} else {
    // Si el formulario no ha sido enviado, muestra el formulario
    $nou->mostrarFormulari();
}
?>