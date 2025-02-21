<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la configuración de la base de datos y las plantillas
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require __DIR__ . '/../../templates/header.php';
require __DIR__ . '/../../templates/navbar.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materiales de Clase - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        /* Estilos específicos para la página de materiales */

        /* Contenedor principal */
        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Títulos */
        h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        /* Lista de materiales */
        .materiales-list {
            list-style: none;
            padding: 0;
        }

        .materiales-list li {
            background: rgba(255, 255, 255, 0.8);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .materiales-list li:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .materiales-list h2 {
            color: #2575fc;
            /* Color azul */
            margin: 0 0 10px;
            font-size: 1.5rem;
        }

        .materiales-list p {
            color: #555;
            margin: 5px 0;
            font-size: 1rem;
        }

        .materiales-list small {
            color: #888;
            font-size: 0.9rem;
            display: block;
            margin-top: 10px;
        }

        /* Botón de descarga */
        .btn-descargar {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background: #2575fc;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .btn-descargar:hover {
            background: #6a11cb;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Materiales de Clase</h1>

        <?php
        // Consulta para obtener los materiales de clase
        try {
            $query = $pdo->query("SELECT * FROM materiales ORDER BY fecha_subida DESC");
            $materiales = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($materiales) > 0) {
                echo "<ul class='materiales-list'>";
                foreach ($materiales as $material) {
                    echo "<li>";
                    echo "<h2>" . htmlspecialchars($material['titulo']) . "</h2>";
                    echo "<p>" . htmlspecialchars($material['descripcion'] ?? 'Sin descripción') . "</p>";
                    echo "<small>Subido el: " . htmlspecialchars($material['fecha_subida']) . "</small>";
                    echo "<a href='" . htmlspecialchars($material['archivo']) . "' download class='btn-descargar'>Descargar</a>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No hay materiales disponibles.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error al cargar los materiales: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <?php
    // Incluimos el pie de página común
    require __DIR__ . '/../../templates/footer.php';
    ?>

</body>

</html>