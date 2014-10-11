<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/juuh', function () use ($app) {
    return 'Juuh elikkäs';
});

$app->run();


// vim: set filetype=php expandtab tabstop=2 shiftwidth=2 autoindent smartindent:
