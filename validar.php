<?php
require_once 'TarifasEnvio.php'; // Incluye la clase TarifasEnvio
require_once 'ZonaEnvio.php'; // Incluye la clase ZonaEnvio
$tarifa = new TarifasEnvio(); // Crea un objeto de la clase TarifasEnvio
$determinarZona = new ZonaEnvio();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['origenCP']) && isset($_POST['destinoCP']) && isset($_POST['peso'])) {

        $origenCP = $_POST['origenCP'];
        $destinoCP = $_POST['destinoCP'];
        $peso = $_POST['peso'];

        // Validar que los campos no estén vacíos
        if (empty($origenCP) || empty($destinoCP) || empty($peso)) {
            echo '<p style="color: red;">Error: Todos los campos son requeridos.</p>';
            exit;
        }

        // Validar que los campos sean numéricos
        if (!is_numeric($origenCP) || !is_numeric($destinoCP) || !is_numeric($peso)) {
            echo '<p style="color: red;">Error: Los campos deben ser numéricos.</p>';
            exit;
        }

        // Validar que el peso sea mayor a 0
        if ($peso <= 0) {
            echo '<p style="color: red;">Error: El peso debe ser mayor a 0.</p>';
            exit;
        }

        // Obtener la zona de origen y destino
        $zonaEnvio = $determinarZona->determinarZonaEnvio($origenCP, $destinoCP);

        // Obtener la tarifa correspondiente para Paquete Estándar
        $tarifaEstandar = $tarifa->obtenerTarifaPaqEstandar($_POST['peso'], $zonaEnvio);

        // Obtener la tarifa correspondiente para Paquete Premium
        $tarifaPremium = $tarifa->obtenerTarifaPaqPremium($_POST['peso'], $zonaEnvio);

        // Obtener la tarifa correspondiente para Paquete Ligero (solo si el peso está dentro del rango)
        $tarifaLigero = null;
        if ($_POST['peso'] <= 2 && $_POST['peso'] >= 0.05) {
            $tarifaLigero = $tarifa->obtenerTarifaPaqLigero($_POST['peso'], $zonaEnvio);
        }

        // Especificar el tipo de contenido como HTML
        header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
 <html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="styles.css">
<title>Resultados de Tarifas de Envío</title>

</head>
  <body>

 <h2>Resultados de Tarifas de Envío</h2>
   <p><strong>Zona de Envío:</strong> <?php echo  $zonaEnvio ?> </p>
<?php
        // Mostrar tarifa estándar
        if ($tarifaEstandar) {
            echo '<div>';
            echo '<h3>Tarifa Paquete Estándar</h3>';
            echo '<p><strong>Tarifa: </strong>' . $tarifaEstandar . ' EUR</p>';
            echo '</div>';
        } else {
            echo '<div>';
            echo '<h3>Tarifa Paquete Estándar</h3>';
            echo '<p class="error">Error: No se encontró una tarifa para los datos proporcionados.</p>';
            echo '</div>';
        }

        // Mostrar tarifa premium
        if ($tarifaPremium) {
            echo '<div>';
            echo '<h3>Tarifa Paquete Premium</h3>';
            echo '<p><strong>Tarifa: </strong>' . $tarifaPremium . ' EUR</p>';
            echo '</div>';
        } else {
            echo '<div>';
            echo '<h3>Tarifa Paquete Premium</h3>';
            echo '<p class="error">Error: No se encontró una tarifa para los datos proporcionados.</p>';
            echo '</div>';
        }

        // Mostrar tarifa ligero (si corresponde)
        if ($tarifaLigero) {
            echo '<div>';
            echo '<h3>Tarifa Paquete Ligero</h3>';
            echo '<p><strong>Tarifa: </strong>' . $tarifaLigero . ' EUR</p>';
            echo '</div>';
        } else {
            echo '<div>';
            echo '<h3>Tarifa Paquete Ligero</h3>';
            echo '<p class="error">Error: No se encontró una tarifa para los datos proporcionados o el peso no es adecuado.</p>';
            echo '</div>';
        }
        // Cerrar HTML
       echo'</body>';
       echo'</html>';
    }
}
?>