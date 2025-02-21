
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Intranet</title>
    <link rel="stylesheet" href="../../assets/css/loginStyle.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="POST">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a>.</p>
    </div>
</body>
</html>
<?php
session_start();

// Configuración del servidor LDAP
$ldap_host = "ldap://127.0.0.1"; // Dirección del servidor LDAP
$ldap_dn = "ou=users,dc=matematico-puigadam,dc=local"; // Base DN de los usuarios

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($password)) {
        $error = "Usuario y contraseña son obligatorios.";
    } else {
        // Conectar al servidor LDAP
        $ldap_con = ldap_connect($ldap_host);
        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);

        // Buscar el usuario en LDAP
        $search = ldap_search($ldap_con, $ldap_dn, "(uid=$username)");
        $entries = ldap_get_entries($ldap_con, $search);

        if ($entries["count"] > 0) {
            $user_dn = $entries[0]["dn"]; // Obtener el DN del usuario

            // Comparar contraseña ingresada con la almacenada en LDAP
            if (@ldap_compare($ldap_con, $user_dn, "userPassword", $password)) {
                $_SESSION["username"] = $username;
                $_SESSION["role"] = obtenerRol($entries[0]["gidnumber"][0]);

                // Redirigir según el rol
                switch ($_SESSION["role"]) {
                    case "alumno":
                        header("Location: /modules/alumnos/index.php");
                        break;
                    case "profesor":
                        header("Location: /modules/profesorado/index.php");
                        break;
                    case "administrador":
                        header("Location: /modules/direccion/index.php");
                        break;
                    default:
                        header("Location: /index.php"); // Página por defecto
                        break;
                }
                exit();
            } else {
                $error = "Credenciales incorrectas.";
            }
        } else {
            $error = "Usuario no encontrado.";
        }

        ldap_close($ldap_con);
    }
}

// Función para obtener el rol según el GID de LDAP
function obtenerRol($gidNumber) {
    switch ($gidNumber) {
        case "2001":
            return "alumno";
        case "2002":
            return "profesor";
        case "2003":
            return "admin";
        default:
            return "usuario";
    }
}
?>