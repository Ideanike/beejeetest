<?php

use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ResponseInterface;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';
require_once 'src/bootstrap/db.php';
require_once 'src/bootstrap/session.php';
require_once 'src/bootstrap/routes.php';
require_once 'src/bootstrap/template.php';

$routerMatcher = $routerContainer->getMatcher();
$request = ServerRequestFactory::fromGlobals();
$route = $routerMatcher->match($request);
if (!$route) {
    echo "No route found for the request.";
    exit;
}

foreach ($route->attributes as $key => $val) {
    $request = $request->withAttribute($key, $val);
}

$handler = new $route->handler($twig, $entityManager, $sessionManager);
/** @var ResponseInterface $response */
$response = $handler->handle($request);

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
http_response_code($response->getStatusCode());
echo $response->getBody();

