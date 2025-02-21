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
    <title>Secretaría - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        /* Estilos específicos para la página de secretaría */

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

        /* Lista de trámites */
        .tramites-list {
            list-style: none;
            padding: 0;
        }

        .tramites-list li {
            background: rgba(255, 255, 255, 0.8);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .tramites-list li:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .tramites-list h2 {
            color: #2575fc;
            /* Color azul */
            margin: 0 0 10px;
            font-size: 1.5rem;
        }

        .tramites-list p {
            color: #555;
            margin: 5px 0;
            font-size: 1rem;
        }

        .tramites-list strong {
            color: #333;
        }

        /* Botón de más información */
        .btn-ver-detalle {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background: #2575fc;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .btn-ver-detalle:hover {
            background: #6a11cb;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Secretaría</h1>

        <?php
        // Consulta para obtener los trámites administrativos
        try {
            $query = $pdo->query("SELECT * FROM tramites ORDER BY nombre ASC");
            $tramites = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($tramites) > 0) {
                echo "<ul class='tramites-list'>";
                foreach ($tramites as $tramite) {
                    echo "<li>";
                    echo "<h2>" . htmlspecialchars($tramite['nombre']) . "</h2>";
                    echo "<p>" . htmlspecialchars($tramite['descripcion']) . "</p>";
                    if (!empty($tramite['archivo_requerido'])) {
                        echo "<p><strong>Documento requerido:</strong> " . htmlspecialchars($tramite['archivo_requerido']) . "</p>";
                    }
                    echo "<a href='tramites.php?id=" . htmlspecialchars($tramite['id_tramite']) . "' class='btn-ver-detalle'>Más información</a>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No hay trámites disponibles.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error al cargar los trámites: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <?php
    // Incluimos el pie de página común
    require __DIR__ . '/../../templates/footer.php';
    ?>

</body>

</html>