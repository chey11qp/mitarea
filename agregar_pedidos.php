<?php
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = crearPedido($_POST['nombreCientifico'],$_POST['nombreComercial'], $_POST['descripcion'], $_POST['fechaEntrega']);
    if ($id) {
        header("Location: index.php");
        exit;
    } else {
        $error = "No se pudo crear el pedido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Pedidio</title>
</head>
<body>
    <h1>Agregar Nuevo pedido</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nombre Cientifico: <input type="text" name="nombreCientifico" required></label><br>
        <label>Nombre Comercial: <input type="text" name="nombreComercial" required></label><br>
        <label>Descripción: <textarea name="descripcion" required></textarea></label><br>
        <label>Fecha de Entrega: <input type="date" name="fechaEntrega" required></label><br>
        <input type="submit" value="Crear Tarea">
    </form>

    <a href="index.php">Volver a la lista de pedidos</a>
</body>
</html>