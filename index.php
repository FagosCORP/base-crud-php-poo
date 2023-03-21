<?php
require_once('config.php');

use Usuario\Usuario;

$usuario = new Usuario();
echo '<pre>';
print_r($usuario->delete([
    'conditions' => 'where id = :id',
    'delete' => [
        ':id' => 130
    ]
]));
die;
