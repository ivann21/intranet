<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verificar si el usuario ha iniciado sesión y tiene el rol de alumno
if (!isset($_SESSION['username'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /modules/auth/login.php");
    exit();
} elseif ($_SESSION['role'] !== 'profesor' || $_SESSION['role'] !== 'admin') {
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
    <title>Dirección - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        /* Estilos específicos para la página de dirección */

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
            margin-bottom: 10px;
        }

        /* Contenedor de mensajes */
        .mensajes-directivos {
            margin-top: 20px;
        }

        /* Estilos para cada mensaje */
        .mensaje {
            background: rgba(255, 255, 255, 0.8);
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .mensaje:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Texto del mensaje */
        .mensaje p {
            color: #555;
            margin: 10px 0;
            font-size: 1rem;
            line-height: 1.5;
        }

        /* Fecha de publicación */
        .mensaje small {
            color: #888;
            font-size: 0.9rem;
            display: block;
            margin-top: 10px;
        }

        /* Efecto de hover en el título del mensaje */
        .mensaje h2:hover {
            color: #6a11cb;
            /* Color morado al hacer hover */
            transition: color 0.3s ease;
        }

        /* Enlaces */
        a {
            color: #2575fc;
            /* Color azul */
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #6a11cb;
            /* Color morado al hacer hover */
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Dirección</h1>

        <?php
        // Consulta para obtener los mensajes del equipo directivo
        try {
            $query = $pdo->query("SELECT * FROM noticias WHERE autor_id IN (SELECT id_usuario FROM usuarios WHERE rol = 'admin') ORDER BY fecha_publicacion DESC");
            $mensajes = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($mensajes) > 0) {
                echo "<div class='mensajes-directivos'>";
                foreach ($mensajes as $mensaje) {
                    echo "<div class='mensaje'>";
                    echo "<h2>" . htmlspecialchars($mensaje['titulo']) . "</h2>";
                    echo "<p>" . htmlspecialchars($mensaje['contenido']) . "</p>";
                    echo "<small>Publicado el: " . htmlspecialchars($mensaje['fecha_publicacion']) . "</small>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>No hay mensajes disponibles.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error al cargar los mensajes: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <?php
    // Incluimos el pie de página común
    require __DIR__ . '/../../templates/footer.php'; ?>

</body>

</html>