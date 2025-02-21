<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la configuración de la base de datos y las plantillas
require_once __DIR__ . '/../../config/config.php';
require __DIR__ . '/../../templates/header.php';
require __DIR__ . '/../../templates/navbar.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamentos - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <style>
        /* Estilos específicos para la página de departamentos */

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

        h2 {
            color: #2575fc;
            font-size: 1.5rem;
        }

        /* Lista de departamentos */
        .departamentos-list {
            list-style: none;
            padding: 0;
        }

        .departamentos-list li {
            background: rgba(255, 255, 255, 0.8);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .departamentos-list li:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .departamentos-list li a {
            text-decoration: none;
            color: #333;
            display: block;
            transition: color 0.3s ease;
        }

        .departamentos-list li a:hover {
            color: #6a11cb;
        }

        /* Descripción del departamento */
        .departamentos-list p {
            color: #555;
            margin: 5px 0 0;
            font-size: 1rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Departamentos</h1>

        <?php
        // Consulta para obtener los departamentos de la base de datos
        try {
            $query = $pdo->query("SELECT * FROM departamentos");
            $departamentos = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($departamentos) > 0) {
                echo "<ul class='departamentos-list'>";
                foreach ($departamentos as $departamento) {
                    echo "<li>";
                    echo "<a href='detalle.php?id=" . $departamento['id_departamento'] . "'>";
                    echo "<h2>" . htmlspecialchars($departamento['nombre']) . "</h2>";
                    echo "<p>" . htmlspecialchars($departamento['descripcion']) . "</p>";
                    echo "</a>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No hay departamentos disponibles.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error al cargar los departamentos: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <?php
    // Incluimos el pie de página común
    require __DIR__ . '/../../templates/footer.php';
    ?>

</body>

</html>