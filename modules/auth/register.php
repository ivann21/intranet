<?php
// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la configuración de la base de datos
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/database.php';

// Verificar si el formulario de registro ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $rol = 'usuario'; // Rol por defecto

    // Validar que todos los campos estén completos
    if (empty($nombre) || empty($apellido) || empty($email) || empty($password)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        try {
            // Verificar si el email ya está registrado
            $query = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
            $query->execute([$email]);
            $usuario = $query->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                $error = "El email ya está registrado.";
            } else {
                // Hash de la contraseña
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                // Insertar el nuevo usuario en la base de datos
                $query = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, email, password, rol) VALUES (?, ?, ?, ?, ?)");
                $query->execute([$nombre, $apellido, $email, $password_hash, $rol]);

                // Redirigir al login con un mensaje de éxito
                header('Location: login.php?registro=exitoso');
                exit;
            }
        } catch (PDOException $e) {
            $error = "Error al registrar el usuario: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Intranet IES Matemático Puig Adam</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        /* Estilos específicos para la página de registro */

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

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        /* Botón de registrar */
        .btn-registrar {
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

        .btn-registrar:hover {
            background: #2575fc;
            /* Color azul al hacer hover */
        }

        /* Enlace para iniciar sesión */
        .container p {
            text-align: center;
            margin-top: 15px;
        }

        .container p a {
            color: #6a11cb;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .container p a:hover {
            color: #2575fc;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Registro de Usuario</h1>

        <?php if (!empty($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required class="form-control">
            </div>

            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required class="form-control">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required class="form-control">
            </div>

            <button type="submit" class="btn-registrar">Registrarse</button>
        </form>

        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
    </div>

    <?php
    // Incluimos el pie de página común
    require __DIR__ . '/../../templates/footer.php';
    ?>

</body>

</html>