<?php
define("BASE_URL", "http://intranet.matematico-puigadam.local/");
define("DB_HOST", "127.0.0.1");
define("DB_NAME", "intranet");
define("DB_USER", "admin"); 
define("DB_PASSWORD", "Adminfo900");  

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USER,
        DB_PASSWORD
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
