<?php
require_once __DIR__ . '/../config/database.php';
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}
function formatDate($date) {
    return $date->toDateTime()->format('Y-m-d');
}
function crearPedido($nombreCientifico,$nombreComercial, $descripcion, $fechaEntrega) {
    global $pedidosCollection;
    $resultado = $pedidosCollection->insertOne([
        'nombreCientifico' => sanitizeInput($nombreCientifico),
        'nombreComercial' => sanitizeInput($nombreComercial),
        'descripcion' => sanitizeInput($descripcion),
        'fechaEntrega' => new MongoDB\BSON\UTCDateTime(strtotime($fechaEntrega) * 1000),
        'completada' => false
    ]);
    return $resultado->getInsertedId();
}


function obtenerPedido() {
    global $pedidosCollection;
    return $pedidosCollection->find();
}
function obtenerPedidoPorId($id) {
    global $pedidosCollection;
    return $pedidosCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}

function actualizarPedido($id, $nombreCientifico, $nombreComercial, $descripcion, $fechaEntrega, $completada) {
    global $pedidosCollection;
    $resultado = $pedidosCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($id)],
        ['$set' => [
            'nombreCientifico' => sanitizeInput($nombreCientifico),
            'nombreComercial' => sanitizeInput($nombreComercial),
            'descripcion' => sanitizeInput($descripcion),
            'fechaEntrega' => new MongoDB\BSON\UTCDateTime(strtotime($fechaEntrega) * 1000),
            'completada' => $completada
        ]]
    );
    return $resultado->getModifiedCount();
}


    function togglePedidoCompletada($id) {
        global $pedidosCollection;
        $pedido = $pedidosCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($_id)]);
        if ($pedido) {
            $nuevoEstado = !$pedido['completada'];
            $resultado = $pedidosCollection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($_id)],
                ['$set' => ['completada' => $nuevoEstado]]
            );
            return $resultado->getModifiedCount() > 0 ? $nuevoEstado : null;
        }
        return null;
    }
    
function eliminarPedido($id) {
    global $pedidosCollection;
    $resultado = $pedidosCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    return $resultado->getDeletedCount();
}
