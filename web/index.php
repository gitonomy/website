<?php
require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
    'twig.options' => array(
        'cache' => __DIR__.'/../cache/twig'
    )
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->get('/', function() use($app) {
    return $app['twig']->render('pages/homepage.html.twig');
})
->bind('homepage');

$app->get('/features', function() use($app) {
    return $app['twig']->render('pages/features.html.twig');
})
->bind('features');

$app->run();
