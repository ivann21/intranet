<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión y tiene el rol de alumno
if (!isset($_SESSION['username'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /modules/auth/login.php");
    exit();
} elseif ($_SESSION['role'] !== 'alumno') {
    echo "<script>alert('No tienes permiso para acceder a esta área.'); window.location.href = '/index.php';</script>";
    exit(); // Detener la ejecución del script
}

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
    <title>Zona de Alumnos - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        /* Estilos específicos para la página de alumnos */

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
            /* Color azul */
            font-size: 1.5rem;
            margin-bottom: 15px;
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

        .materiales-list h3 {
            color: #333;
            margin: 0 0 10px;
            font-size: 1.2rem;
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

        .materiales-list a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background: #2575fc;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .materiales-list a:hover {
            background: #6a11cb;
        }

        /* Lista de enlaces útiles */
        .enlaces-list {
            list-style: none;
            padding: 0;
        }

        .enlaces-list li {
            margin-bottom: 10px;
        }

        .enlaces-list a {
            color: #2575fc;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .enlaces-list a:hover {
            color: #6a11cb;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Zona de Alumnos</h1>

        <!-- Sección de Materiales de Clase -->
        <section class="materiales">
            <h2>Materiales de Clase</h2>
            <?php
            try {
                // Consulta para obtener los materiales de clase
                $query = $pdo->query("SELECT * FROM materiales ORDER BY fecha_subida DESC");
                $materiales = $query->fetchAll(PDO::FETCH_ASSOC);

                if (count($materiales) > 0) {
                    echo "<ul class='materiales-list'>";
                    foreach ($materiales as $material) {
                        echo "<li>";
                        echo "<h3>" . htmlspecialchars($material['titulo']) . "</h3>";
                        // Elimina o comenta esta línea si no tienes una columna 'descripcion'
                        // echo "<p>" . htmlspecialchars($material['descripcion']) . "</p>"; 
                        echo "<small>Subido el: " . htmlspecialchars($material['fecha_subida']) . "</small>";
                        echo "<a href='" . htmlspecialchars($material['archivo']) . "' download>Descargar</a>";
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
        </section>

        <!-- Sección de Enlaces Útiles -->
        <section class="enlaces-utiles">
            <h2>Enlaces Útiles</h2>
            <ul class="enlaces-list">
                <li><a href="https://educacion.gob.es" target="_blank">Ministerio de Educación</a></li>
                <li><a href="https://moodle.org" target="_blank">Plataforma Moodle</a></li>
                <li><a href="https://khanacademy.org" target="_blank">Khan Academy</a></li>
                <li><a href="https://biblioteca.org" target="_blank">Biblioteca Virtual</a></li>
            </ul>
        </section>
    </div>

    <?php
    // Incluimos el pie de página común
    require __DIR__ . '/../../templates/footer.php';
    ?>

</body>

</html>