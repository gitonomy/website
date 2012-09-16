<?php
require_once __DIR__.'/../vendor/autoload.php';

use Gitonomy\Documentation\Documentation;

$app = new Silex\Application();
$app['debug'] = true;

$app['gitlib.documentation'] = function ($app) {
    return new Documentation(array(
        'master' => __DIR__.'/../cache/doc/gitlib/json/master'
    ));
};

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

$app->get('/demo', function() use($app) {
    return $app['twig']->render('pages/demo.html.twig');
})
->bind('demo');

$app->get('/features', function() use($app) {
    return $app['twig']->render('pages/features.html.twig');
})
->bind('features');


$app->get('/doc/{project}/{version}/{path}', function ($project, $version, $path) use ($app) {
        if (!in_array($project, array('gitlib'))) {
            throw new \RuntimeException('Project not found');
        }

        if ($path == '') {
            $path = 'index';
        } elseif (preg_match('#/$#', $path)) {
            $path = substr($path, 0, -1);
        }

        $document = $app[$project.'.documentation']->get($version, $path);

        return $app['twig']->render('pages/documentation.html.twig', array(
            'document' => $document,
            'project'  => $project,
            'version'  => $version,
            'path'     => $path
        ));
    })
    ->assert('path', '.*')
    ->bind('documentation')
;

$app->run();
