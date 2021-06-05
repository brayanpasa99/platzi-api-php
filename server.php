<?php

// Definimos los recursos disponibles
$allowebResourceTypes = [
    'books',
    'authors',
    'genres',
];

// Validamos que el resuso este disponible
$resourceType = $_GET['resource_type'];

if (!in_array($resourceType, $allowebResourceTypes)) {
    die;
}

// Defino los recursos

$books = [
    1 => [
        'titulo' => 'Lo que el viento se llevo',
        'id_autor' => 2,
        'id_genero' => 2,
    ],
    2 => [
        'titulo' => 'La iliada',
        'id_autor' => 1,
        'id_genero' => 1,
    ],
    3 => [
        'titulo' => 'La odisea',
        'id_autor' => 1,
        'id_genero' => 1,
    ],
];

header('Content-Type: application/json');

// Levantamos el id del recurso buscado
$resourceId = array_key_exists('resource_id', $_GET) ? $_GET['resource_id'] : '';

// Generamos la respuesta asumiendo que el pedido es correcto
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (empty($resourceId)) {
            echo json_encode($books);
        } else {
            if (array_key_exists($resourceId, $books)) {
                echo json_encode($books[$resourceId]);
            }
        }

        break;
    case 'POST':
        $json = file_get_contents('php://input');

        $books[] = json_decode($json, true);

        // echo array_keys($books)[count($books) - 1];
        echo json_encode($books);
        break;
    case 'PUT':
        // Validamos que el recurso buscado exista
        if (!empty($resourceId) && array_key_exists($resourceId, $books)) {
            $json = file_get_contents('php://input');

            // Transformamos el json recibido a un nuevo elemento de
            $books[$resourceId] = json_decode($json, true);

            // Retornamos la colección modificada en formato json
            echo json_encode($books);
        }
        break;
    case 'DELETE':
        break;
}
