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

// Verificar si se ha proporcionado un ID de trámite
if (isset($_GET['id'])) {
    $id_tramite = $_GET['id'];

    try {
        // Consulta para obtener los detalles del trámite
        $query = $pdo->prepare("SELECT * FROM tramites WHERE id_tramite = ?");
        $query->execute([$id_tramite]);
        $tramite = $query->fetch(PDO::FETCH_ASSOC);

        if ($tramite) {
?>
            <style>
                /* Estilos específicos para la página de detalles del trámite */

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

                h2 {
                    color: #2575fc;
                    /* Color azul */
                    font-size: 1.5rem;
                    margin-bottom: 15px;
                }

                /* Detalles del trámite */
                .tramite-detalle {
                    background: rgba(255, 255, 255, 0.8);
                    padding: 15px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .tramite-detalle p {
                    color: #555;
                    margin: 5px 0;
                    font-size: 1rem;
                }

                .tramite-detalle strong {
                    color: #333;
                }
            </style>
            <div class="container">
                <h1>Detalles del Trámite</h1>
                <div class="tramite-detalle">
                    <h2><?= htmlspecialchars($tramite['nombre']) ?></h2>
                    <p><?= htmlspecialchars($tramite['descripcion']) ?></p>
                    <?php if (!empty($tramite['archivo_requerido'])): ?>
                        <p><strong>Documento requerido:</strong> <?= htmlspecialchars($tramite['archivo_requerido']) ?></p>
                        <a href="index.php" class="btn-volver">Volver a la lista de trámites</a>
                    <?php endif; ?>
                </div>
            </div>
<?php
        } else {
            echo "<p>Trámite no encontrado.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error al cargar los detalles del trámite: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>ID de trámite no especificado.</p>";
}

// Incluimos el pie de página común
require __DIR__ . '/../../templates/footer.php';
?>