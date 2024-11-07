<?php
require_once __DIR__ . '/includes/functions.php';

if (isset($_GET['accion']) && isset($_GET['id'])) {
    switch ($_GET['accion']) {
        case 'eliminar':
            $count = eliminarPedido($_GET['id']);
            $mensaje = $count > 0 ? "Tarea eliminada con éxito." : "No se pudo eliminar la pedido.";
            break;
        case 'toggleCompletada':
            $nuevoEstado = togglePedidoCompletado($_GET['id']);
            if ($nuevoEstado !== null) {
                $mensaje = $nuevoEstado ? "Tarea marcada como completada." : "Tarea marcada como no completada.";
            } else {
                $mensaje = "No se pudo cambiar el estado de la pedido.";
            }
            break;
    }
}

$pedido = obtenerPedido();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de ventas "VIVERO MUNAYRIKUY - Hogar Suculentero</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Sistema de ventas "VIVERO MUNAYRIKUY - Hogar Suculentero</h1>

        <?php if (isset($mensaje)): ?>
            <div class="<?php echo strpos($mensaje, 'éxito') !== false ? 'success' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <a href="agregar_pedidos.php" class="button">Agregar Nuevo pedido</a>

        <h2>Lista de Pedidos</h2>
        <table>
            <tr>
                <th>Nombre Cientifico</th>
                <th>Nombre Comercial</th>
                <th>Descripción</th>
                <th>Fecha de Entrega</th>
                <th>Completada</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($pedido as $pedido): ?>
            <tr>
                <td><?php echo htmlspecialchars($pedido['nombreCientifico']); ?></td>
                <td><?php echo htmlspecialchars($pedido['nombreComercial']); ?></td>
                <td><?php echo htmlspecialchars($pedido['descripcion']); ?></td>
                <td><?php echo formatDate($pedido['fechaEntrega']); ?></td>
                <td>
                    <a href="index.php?accion=togglePedidoCompletada&id=<?php echo $pedido['_id']; ?>"
                       class="button <?php echo $pedido['completada'] ? 'completada' : 'no-completada'; ?>">
                        <?php echo $pedido['completada'] ? 'Completada' : 'No Completada'; ?>
                    </a>
                </td>
                <td class="actions">
                    <a href="editar_pedido.php?id=<?php echo $pedido['_id']; ?>" class="button">Editar</a>
                    <a href="index.php?accion=eliminar&id=<?php echo $pedido['_id']; ?>" class="button"
                       onclick="return confirm('¿Estás seguro de que quieres eliminar esta pedido?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
