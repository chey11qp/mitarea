<?php
require_once __DIR__ . '/includes/functions.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$pedido = obtenerpedidoPorId($_GET['id']);

if (!$pedido) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    // Verificar que todas las variables estén definidas 
    if (isset($_POST['nombreCientifico'], $_POST['nombreComercial'], $_POST['descripcion'], $_POST['fechaEntrega'], $_POST['completada'])) { 
        $count = actualizarpedido($_GET['_id'], $_POST['nombreCientifico'], $_POST['nombreComercial'], $_POST['descripcion'], $_POST['fechaEntrega'], $_POST['completada']); 
        if ($count > 0) { 
            header("Location: index.php?mensaje=Proceso actualizada con éxito"); 
            exit; 
        } else { 
            $error = "No se pudo actualizar el proceso."; 
        } 
    } else { 
        $error = "Faltan datos requeridos."; 
    } 
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar pedido</title>
</head>
<body>
    <h1>Editar pedido</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nombre Cientifico: <input type="text" name="nombreCientifico" value="<?php echo htmlspecialchars($pedido['nombreCientifico']); ?>" required></label><br>
        <label>nombre Comercial: <input type="text" name="nombreComercial" value="<?php echo htmlspecialchars($pedido['nombreComercial']); ?>" required></label><br>
        <label>Descripción: <texpedido name="descripcion" required><?php echo htmlspecialchars($pedido['descripcion']); ?></texpedido></label><br>
        <label>Fecha de Entrega: <input type="date" name="fechaEntrega" value="<?php echo formatDate($pedido['fechaEntrega']); ?>" required></label><br>
        <label>Completada: <input type="checkbox" name="completada" <?php echo $pedido['completada'] ? 'checked' : ''; ?>></label><br>
        <input type="submit" value="Actualizar pedido">
    </form>

    <a href="index.php">Volver a la lista de pedidos</a>
</body>
</html>


