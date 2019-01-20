<?php
require_once('../vendor/autoload.php');

$r = new App\Http\SimpleRouter;

$array = [
    $r->request(null, 'phpinfo', 'App\\Controller\\PhpInfo'),
    $r->get('write', 'App\\Controller\\Datastore', 'writeAction'),
    $r->get('list', 'App\\Controller\\Datastore', 'listAction'),
    $r->all('App\\Controller\\Index')
];
