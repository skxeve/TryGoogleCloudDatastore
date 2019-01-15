<?php
require_once('../vendor/autoload.php');

$r = new App\Http\SimpleRouter;

$array = [
    $r->request(null, 'phpinfo', 'App\\Controller\\PhpInfo'),
    $r->all('App\\Controller\\Index')
];
