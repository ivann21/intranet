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
    <title>Noticias - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <style>
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

        .noticia {
            background: rgba(255, 255, 255, 0.8);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .noticia:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .noticia a {
            text-decoration: none;
            color: #333;
            display: block;
            font-weight: bold;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .noticia a:hover {
            color: #6a11cb;
        }

        .noticia p {
            color: #555;
            margin-top: 5px;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Últimas Noticias</h1>

        <?php
        // Consulta para obtener las noticias más recientes
        try {
            $query = $pdo->query("SELECT * FROM noticias ORDER BY fecha_publicacion DESC LIMIT 10");
            $noticias = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($noticias) > 0) {
                foreach ($noticias as $noticia) {
                    echo "<div class='noticia'>";
                    echo "<a href='detalle.php?id=" . $noticia['id_noticia'] . "'>" . htmlspecialchars($noticia['titulo']) . "</a>";
                    echo "<p>" . substr(htmlspecialchars($noticia['contenido']), 0, 150) . "...</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay noticias disponibles.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error al cargar las noticias: " . $e->getMessage() . "</p>";
        }
        ?>
        <a href="publicar.php" class="boton">Publicar noticia</a>
    </div>
        
    <?php require __DIR__ . '/../../templates/footer.php'; ?>
</body>

</html>
