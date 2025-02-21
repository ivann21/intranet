<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la configuración de la base de datos y las plantillas
require_once __DIR__ . '/../../config/config.php';
require __DIR__ . '/../../templates/header.php';
require __DIR__ . '/../../templates/navbar.php';

// Obtener el ID del horario desde la URL
$id_horario = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_horario <= 0) {
    echo "<p>ID de horario no válido.</p>";
    exit();
}

try {
    $query = $pdo->prepare("SELECT horarios.*, usuarios.nombre AS profesor_nombre, usuarios.apellido AS profesor_apellido FROM horarios 
                             JOIN usuarios ON horarios.profesor_id = usuarios.id_usuario 
                             WHERE horarios.id_horario = ?");
    $query->execute([$id_horario]);
    $horario = $query->fetch(PDO::FETCH_ASSOC);

    if (!$horario) {
        echo "<p>No se encontró el horario solicitado.</p>";
        exit();
    }
} catch (PDOException $e) {
    echo "<p>Error al cargar los detalles del horario: " . $e->getMessage() . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Horario - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .info {
            font-size: 1.2rem;
            color: #333;
        }

        .info p {
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Detalle del Horario</h1>
        <div class="info">
            <p><strong>Curso:</strong> <?= htmlspecialchars($horario['curso']) ?></p>
            <p><strong>Asignatura:</strong> <?= htmlspecialchars($horario['asignatura']) ?></p>
            <p><strong>Día:</strong> <?= htmlspecialchars($horario['dia']) ?></p>
            <p><strong>Hora Inicio:</strong> <?= htmlspecialchars($horario['hora_inicio']) ?></p>
            <p><strong>Hora Fin:</strong> <?= htmlspecialchars($horario['hora_fin']) ?></p>
            <p><strong>Profesor:</strong> <?= htmlspecialchars($horario['profesor_nombre'] . ' ' . $horario['profesor_apellido']) ?></p>
        </div>
        <a href="index.php">Volver a horarios</a>
    </div>

    <?php require __DIR__ . '/../../templates/footer.php'; ?>
</body>

</html>
