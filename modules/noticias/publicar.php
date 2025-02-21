<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la configuración de la base de datos y las plantillas
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';
require __DIR__ . '/../../templates/header.php';
require __DIR__ . '/../../templates/navbar.php';


// Procesar el formulario de publicación de noticias
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $autor_id = $_SESSION['usuario']['id_usuario'];

    if (!empty($titulo) && !empty($contenido)) {
        try {
            // Insertar la noticia en la base de datos
            $query = $pdo->prepare("INSERT INTO noticias (titulo, contenido, autor_id) VALUES (?, ?, ?)");
            $query->execute([$titulo, $contenido, $autor_id]);

            // Redirigir a la página de noticias con un mensaje de éxito
            header('Location: index.php?publicado=1');
            exit;
        } catch (PDOException $e) {
            echo "<p>Error al publicar la noticia: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Por favor, complete todos los campos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Noticia - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        /* Estilos específicos para la página de publicar noticia */

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

        /* Formulario */
        form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-size: 1rem;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        /* Botón de publicar */
        .btn-publicar {
            display: inline-block;
            padding: 10px 20px;
            background: #6a11cb;
            /* Color morado */
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-publicar:hover {
            background: #2575fc;
            /* Color azul al hacer hover */
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Publicar Noticia</h1>

        <form action="publicar.php" method="POST">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required class="form-control">
            </div>

            <div class="form-group">
                <label for="contenido">Contenido:</label>
                <textarea id="contenido" name="contenido" rows="10" required class="form-control"></textarea>
            </div>

            <button type="submit" class="btn-publicar">Publicar Noticia</button>
        </form>
        <a href="index.php" class="boton">volver a noticias</a>
    </div>
      
    <?php
    // Incluimos el pie de página común
    require __DIR__ . '/../../templates/footer.php';
    ?>

</body>

</html>