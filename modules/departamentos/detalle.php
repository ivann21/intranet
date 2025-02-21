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

// Verificar si se ha proporcionado un ID de departamento
if (isset($_GET['id'])) {
    $id_departamento = $_GET['id'];

    try {
        // Consulta para obtener los detalles del departamento
        $query = $pdo->prepare("SELECT * FROM departamentos WHERE id_departamento = ?");
        $query->execute([$id_departamento]);
        $departamento = $query->fetch(PDO::FETCH_ASSOC);

        if ($departamento) {
?>
            <style>
                /* Estilos específicos para la página de detalles del departamento */

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

                /* Detalles del departamento */
                .departamento-detalle {
                    background: rgba(255, 255, 255, 0.8);
                    padding: 15px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .departamento-detalle p {
                    color: #555;
                    margin: 5px 0;
                    font-size: 1rem;
                }

                /* Botón de volver */
                .btn-volver {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 20px;
                    background: #6a11cb;
                    /* Color morado */
                    color: #fff;
                    border-radius: 5px;
                    text-decoration: none;
                    transition: background 0.3s ease;
                }

                .btn-volver:hover {
                    background: #2575fc;
                    /* Color azul al hacer hover */
                }
            </style>
            <div class="container">
                <h1>Detalles del Departamento</h1>
                <div class="departamento-detalle">
                    <h2><?= htmlspecialchars($departamento['nombre']) ?></h2>
                    <p><?= htmlspecialchars($departamento['descripcion']) ?></p>

                    <!-- Botón para volver a la lista de departamentos -->
                    <a href="index.php" class="btn-volver">Volver a la lista de departamentos</a>
                </div>
            </div>
<?php
        } else {
            echo "<p>Departamento no encontrado.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error al cargar los detalles del departamento: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>ID de departamento no especificado.</p>";
}

// Incluimos el pie de página común
require __DIR__ . '/../../templates/footer.php';
?>