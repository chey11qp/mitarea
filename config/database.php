<?php
    require_once __DIR__.'/../vendor/autoload.php';
    $mongoClient = new MongoDB\Client("mongodb+srv://joseluispz:11223344@cluster0.27dbi.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");
    $database = $mongoClient->selectDataBase('Viveromunayrikuy');
    $pedidosCollection = $database->pedidos;
?>


