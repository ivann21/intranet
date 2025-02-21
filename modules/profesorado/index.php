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
} elseif ($_SESSION['role'] !== 'profesor') {
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
    <title>Profesorado - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        /* Estilos específicos para la página de profesorado */

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

        /* Lista de profesores */
        .profesores-list {
            list-style: none;
            padding: 0;
        }

        .profesores-list li {
            background: rgba(255, 255, 255, 0.8);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profesores-list li:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .profesores-list h2 {
            color: #2575fc;
            /* Color azul */
            margin: 0 0 10px;
            font-size: 1.5rem;
        }

        .profesores-list p {
            color: #555;
            margin: 5px 0;
            font-size: 1rem;
        }

        /* Botón de ver detalles */
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
        <h1>Profesorado</h1>

        <?php
        // Consulta para obtener la lista de profesores
        try {
            $query = $pdo->query("SELECT * FROM usuarios WHERE rol = 'profesor' ORDER BY apellido ASC");
            $profesores = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($profesores) > 0) {
                echo "<ul class='profesores-list'>";
                foreach ($profesores as $profesor) {
                    echo "<li>";
                    echo "<h2>" . htmlspecialchars($profesor['nombre']) . " " . htmlspecialchars($profesor['apellido']) . "</h2>";
                    echo "<p><strong>Email:</strong> " . htmlspecialchars($profesor['email']) . "</p>";
                    echo "<a href='detalle.php?id=" . htmlspecialchars($profesor['id_usuario']) . "' class='btn-ver-detalle'>Ver detalles</a>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No hay profesores disponibles.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error al cargar el listado de profesores: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <?php
    // Incluimos el pie de página común
    require __DIR__ . '/../../templates/footer.php';
    ?>

</body>

</html>