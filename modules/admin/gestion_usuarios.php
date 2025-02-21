<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión y tiene el rol de administrador
if (!isset($_SESSION['username'])) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: /modules/auth/login.php");
    exit();
} elseif ($_SESSION['role'] !== 'admin') {
    // Si el rol no es "admin", mostrar un alert y redirigir
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
    <title>Gestión de Usuarios - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        /* Estilos específicos para la gestión de usuarios */

        /* Contenedor principal */
        .container {
            max-width: 1200px;
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

        /* Lista de usuarios */
        .usuarios-list {
            list-style: none;
            padding: 0;
        }

        .usuarios-list li {
            background: rgba(255, 255, 255, 0.8);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .usuarios-list li:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .usuarios-list h3 {
            color: #333;
            margin: 0 0 10px;
            font-size: 1.2rem;
        }

        .usuarios-list p {
            color: #555;
            margin: 5px 0;
            font-size: 1rem;
        }

        .usuarios-list a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background: #2575fc;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .usuarios-list a:hover {
            background: #6a11cb;
        }

        /* Botón de crear usuario */
        .btn-crear {
            display: inline-block;
            padding: 10px 20px;
            background: #28a745;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .btn-crear:hover {
            background: #218838;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Gestión de Usuarios</h1>

        <!-- Botón para crear un nuevo usuario -->
        <a href="crear_usuario.php" class="btn-crear">Crear Nuevo Usuario</a>

        <!-- Lista de usuarios -->
        <section class="usuarios">
            <h2>Lista de Usuarios</h2>
            <?php
            try {
                $query = $pdo->query("SELECT * FROM usuarios ORDER BY id_usuario DESC");
                $usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

                if (count($usuarios) > 0) {
                    echo "<ul class='usuarios-list'>";
                    foreach ($usuarios as $usuario) {
                        echo "<li>";
                        echo "<h3>" . htmlspecialchars($usuario['nombre']) . " " . htmlspecialchars($usuario['apellido']) . "</h3>";
                        echo "<p>Email: " . htmlspecialchars($usuario['email']) . "</p>";
                        echo "<p>Rol: " . htmlspecialchars($usuario['rol']) . "</p>";
                        echo "<a href='editar_usuario.php?id=" . $usuario['id_usuario'] . "'>Editar</a>";
                        echo "<a href='eliminar_usuario.php?id=" . $usuario['id_usuario'] . "' style='margin-left: 10px; background: #dc3545;'>Eliminar</a>";
                        echo "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No hay usuarios registrados.</p>";
                }
            } catch (PDOException $e) {
                echo "<p>Error al cargar los usuarios: " . $e->getMessage() . "</p>";
            }
            ?>
        </section>
    </div>

    <?php
    // Incluimos el pie de página común
    require __DIR__ . '/../../templates/footer.php';
    ?>

</body>

</html>