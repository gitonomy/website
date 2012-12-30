<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Gitonomy\ChangeLog\ChangeLogFactory;
use Gitonomy\ChangeLog\Filter\FilterFactory;
use Gitonomy\Documentation\Documentation;

$app = new Silex\Application();
$app['debug'] = true;

$app['gitlib.documentation'] = function ($app) {
    return new Documentation(array(
        'master' => __DIR__.'/../cache/doc/gitlib/json/master'
    ));
};
$app['gitonomy.documentation'] = function ($app) {
    return new Documentation(array(
        'master' => __DIR__.'/../cache/doc/gitonomy/json/master'
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

$app->get('/download', function() use($app) {
    return $app['twig']->render('pages/download.html.twig');
})
->bind('download');

$app->get('/features', function() use($app) {
    return $app['twig']->render('pages/features.html.twig');
})
->bind('features');


$app->get('/doc/{project}/{version}/{path}', function ($project, $version, $path) use ($app) {
        if (!in_array($project, array('gitlib', 'gitonomy'))) {
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

$app->get('/version.json', function () {
    $changeLog      = ChangeLogFactory::getCache();
    $currentVersion = $changeLog->getLastStableVersion();

    return json_encode(array(
        'version' => $currentVersion->getVersion(),
        'date'    => $currentVersion->getDate(),
    ));
});


$app->get('/changelog.json', function (Request $request) {
    $filter    = FilterFactory::createFromRequest($request);
    $changeLog = ChangeLogFactory::getCache($filter);

    return json_encode(ChangeLogFactory::toArray($changeLog));
});

$app->run();
