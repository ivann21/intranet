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
    <title>Horarios - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <style>
        /* Estilos específicos para la página de horarios */
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

        h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #2575fc;
            color: white;
        }

        tr:hover {
            background: rgba(106, 17, 203, 0.1);
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Horarios de Clase</h1>

        <?php
        // Consulta para obtener los horarios de la base de datos
        try {
            $query = $pdo->query("SELECT horarios.*, usuarios.nombre AS profesor_nombre, usuarios.apellido AS profesor_apellido FROM horarios 
                                  JOIN usuarios ON horarios.profesor_id = usuarios.id_usuario ORDER BY curso, dia, hora_inicio");
            $horarios = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($horarios) > 0) {
                echo "<table>";
                echo "<tr><th>Curso</th><th>Asignatura</th><th>Día</th><th>Hora Inicio</th><th>Hora Fin</th><th>Profesor</th></tr>";
                foreach ($horarios as $horario) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($horario['curso']) . "</td>";
                    echo "<td>" . htmlspecialchars($horario['asignatura']) . "</td>";
                    echo "<td>" . htmlspecialchars($horario['dia']) . "</td>";
                    echo "<td>" . htmlspecialchars($horario['hora_inicio']) . "</td>";
                    echo "<td>" . htmlspecialchars($horario['hora_fin']) . "</td>";
                    echo "<td>" . htmlspecialchars($horario['profesor_nombre'] . " " . $horario['profesor_apellido']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No hay horarios disponibles.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error al cargar los horarios: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <?php
    // Incluimos el pie de página común
    require __DIR__ . '/../../templates/footer.php';
    ?>

</body>

</html>
