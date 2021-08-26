<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

ini_set('display_errors', '1');
require __DIR__ . '/vendor/autoload.php';

define ('TEMPLATES', __DIR__ . '/templates/');


$loader = new YamlFileLoader(new FileLocator(__DIR__ . '/config'));
$routes = $loader->load('routes.yaml');

$matcher = new UrlMatcher($routes, new RequestContext('', $_SERVER['REQUEST_METHOD']));
$generator = new UrlGenerator($routes, new RequestContext());

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';

try {
    $currentRoute = $matcher->match($pathInfo);
    // dd($currentRoute);
    $controller = $currentRoute['_controller'];

    $currentRoute['generator'] = $generator;

    $classname = substr($controller, 0, strpos($controller, '@'));

    $method = substr($controller, strpos($controller, '@') + 1);

    $instance = new $classname();

    call_user_func_array([$instance, $method], $currentRoute);
} catch (ResourceNotFoundException $e) {
    header('HTTP/1.0 404 Not Found');
    return;
}