<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la configuración de la base de datos y las plantillas
require_once __DIR__ . '/../../config/config.php';
require __DIR__ . '/../../templates/header.php';
require __DIR__ . '/../../templates/navbar.php';

// Obtener el ID de la noticia desde la URL
$id_noticia = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_noticia <= 0) {
    echo "<p>ID de noticia no válido.</p>";
    exit();
}

try {
    $query = $pdo->prepare("SELECT * FROM noticias WHERE id_noticia = ?");
    $query->execute([$id_noticia]);
    $noticia = $query->fetch(PDO::FETCH_ASSOC);

    if (!$noticia) {
        echo "<p>No se encontró la noticia solicitada.</p>";
        exit();
    }
} catch (PDOException $e) {
    echo "<p>Error al cargar la noticia: " . $e->getMessage() . "</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($noticia['titulo']) ?> - Intranet IES Matemático Puig Adam</title>
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

        .contenido {
            font-size: 1.2rem;
            color: #333;
            line-height: 1.6;
        }

        .fecha {
            font-size: 0.9rem;
            color: #777;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1><?= htmlspecialchars($noticia['titulo']) ?></h1>
        <p class="fecha">Publicado el <?= htmlspecialchars($noticia['fecha_publicacion']) ?></p>
        <div class="contenido">
            <?= nl2br(htmlspecialchars($noticia['contenido'])) ?>
        </div>
        <a href="index.php">Volver a noticias</a>
    </div>

    <?php require __DIR__ . '/../../templates/footer.php'; ?>
</body>

</html>
