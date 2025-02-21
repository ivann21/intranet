<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intranet - IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="/intranet/assets/css/styles.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>

<body>
    <?php
    session_start();
    require_once 'config/config.php';
    require "/opt/lampp/htdocs/intranet/templates/header.php";
    require "/opt/lampp/htdocs/intranet/templates/navbar.php";
    if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
        header('Location: modules/auth/login.php');
        exit();
    }
    ?>

    <!-- Contenido principal -->
    <main>
        <section class="welcome-section">
            <h1>Bienvenido al IES Matemático Puig Adam</h1>
            <p>
                El IES Matemático Puig Adam es un centro educativo comprometido con la excelencia académica y el desarrollo integral de nuestros estudiantes.
                Ofrecemos una amplia variedad de programas educativos, desde la educación secundaria hasta ciclos formativos, siempre con un enfoque en la innovación
                y la calidad docente.
            </p>
            <p>
                Nuestro centro cuenta con instalaciones modernas, un equipo de profesores altamente cualificados y un ambiente que fomenta el aprendizaje y la creatividad.
                Estamos dedicados a formar a los líderes del mañana, proporcionando las herramientas necesarias para que nuestros alumnos alcancen sus metas.
            </p>
            <p>
                ¡Explora nuestra intranet para acceder a recursos, noticias y servicios diseñados para apoyar tu experiencia educativa!
            </p>
        </section>
    </main>

    <?php
    require "/opt/lampp/htdocs/intranet/templates/footer.php";
    ?>
</body>

</html>