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
    <title>Panel de Control - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        /* Estilos específicos para el panel de control */

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

        h2 {
            color: #2575fc;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        /* Tarjetas de resumen */
        .cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 30%;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }

        .card p {
            color: #555;
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Botón de gestión de usuarios */
        .btn-gestion {
            display: inline-block;
            padding: 10px 20px;
            background: #2575fc;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .btn-gestion:hover {
            background: #6a11cb;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Panel de Control - Administrador</h1>

        <!-- Tarjetas de resumen -->
        <section class="cards">
            <div class="card">
                <h3>Usuarios Registrados</h3>
                <?php
                try {
                    $query = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    echo "<p>" . $result['total'] . "</p>";
                } catch (PDOException $e) {
                    echo "<p>Error: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
            <div class="card">
                <h3>Materiales Subidos</h3>
                <?php
                try {
                    $query = $pdo->query("SELECT COUNT(*) as total FROM materiales");
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    echo "<p>" . $result['total'] . "</p>";
                } catch (PDOException $e) {
                    echo "<p>Error: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
            <div class="card">
                <h3>Noticias Publicadas</h3>
                <?php
                try {
                    $query = $pdo->query("SELECT COUNT(*) as total FROM noticias");
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                    echo "<p>" . $result['total'] . "</p>";
                } catch (PDOException $e) {
                    echo "<p>Error: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
        </section>

        <!-- Enlace a la gestión de usuarios -->
        <section class="gestion-usuarios">
            <h2>Gestión de Usuarios</h2>
            <a href="gestion_usuarios.php" class="btn-gestion">Gestionar Usuarios</a>
        </section>
    </div>

    <?php
    // Incluimos el pie de página común
    require __DIR__ . '/../../templates/footer.php';
    ?>

</body>

</html>