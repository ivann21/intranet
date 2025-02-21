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

// Verificar si se ha proporcionado un ID de profesor
if (isset($_GET['id'])) {
    $id_profesor = $_GET['id'];

    try {
        // Consulta para obtener los detalles del profesor
        $query = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $query->execute([$id_profesor]);
        $profesor = $query->fetch(PDO::FETCH_ASSOC);

        if ($profesor) {
?>
            <style>
                /* Estilos específicos para la página de detalles del profesor */

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

                h3 {
                    color: #333;
                    font-size: 1.3rem;
                    margin-top: 20px;
                    margin-bottom: 10px;
                }

                /* Detalles del profesor */
                .profesor-detalle {
                    background: rgba(255, 255, 255, 0.8);
                    padding: 15px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .profesor-detalle p {
                    color: #555;
                    margin: 5px 0;
                    font-size: 1rem;
                }

                /* Lista de materiales */
                .materiales-list {
                    list-style: none;
                    padding: 0;
                }

                .materiales-list li {
                    background: rgba(255, 255, 255, 0.8);
                    padding: 15px;
                    margin-bottom: 10px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }

                .materiales-list li:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
                }

                .materiales-list h4 {
                    color: #2575fc;
                    /* Color azul */
                    margin: 0 0 10px;
                    font-size: 1.2rem;
                }

                .materiales-list p {
                    color: #555;
                    margin: 5px 0;
                    font-size: 1rem;
                }

                .materiales-list small {
                    color: #888;
                    font-size: 0.9rem;
                    display: block;
                    margin-top: 10px;
                }

                /* Botón de descarga */
                .btn-descargar {
                    display: inline-block;
                    margin-top: 10px;
                    padding: 8px 15px;
                    background: #2575fc;
                    color: #fff;
                    border-radius: 5px;
                    text-decoration: none;
                    transition: background 0.3s ease;
                }

                .btn-descargar:hover {
                    background: #6a11cb;
                }
            </style>
            <div class="container">
                <h1>Detalles del Profesor</h1>
                <div class="profesor-detalle">
                    <h2><?= htmlspecialchars($profesor['nombre']) . " " . htmlspecialchars($profesor['apellido']) ?></h2>
                    <p><strong>Email:</strong> <?= htmlspecialchars($profesor['email']) ?></p>
                    <p><strong>Rol:</strong> <?= htmlspecialchars($profesor['rol']) ?></p>

                    <!-- Sección de materiales subidos por el profesor -->
                    <h3>Materiales Subidos</h3>
                    <?php
                    // Consulta para obtener los materiales subidos por el profesor
                    $queryMateriales = $pdo->prepare("SELECT * FROM materiales WHERE profesor_id = ? ORDER BY fecha_subida DESC");
                    $queryMateriales->execute([$id_profesor]);
                    $materiales = $queryMateriales->fetchAll(PDO::FETCH_ASSOC);

                    if (count($materiales) > 0) {
                        echo "<ul class='materiales-list'>";
                        foreach ($materiales as $material) {
                            echo "<li>";
                            echo "<h4>" . htmlspecialchars($material['titulo']) . "</h4>";
                            echo "<p>" . htmlspecialchars($material['descripcion'] ?? 'Sin descripción') . "</p>";
                            echo "<small>Subido el: " . htmlspecialchars($material['fecha_subida']) . "</small>";
                            echo "<a href='" . htmlspecialchars($material['archivo']) . "' download class='btn-descargar'>Descargar</a>";
                            echo "</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No hay materiales subidos por este profesor.</p>";
                    }
                    ?>
                </div>
            </div>
<?php
        } else {
            echo "<p>Profesor no encontrado.</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error al cargar los detalles del profesor: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>ID de profesor no especificado.</p>";
}

// Incluimos el pie de página común
require __DIR__ . '/../../templates/footer.php';
?>