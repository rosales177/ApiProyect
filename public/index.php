<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
require __DIR__ . '/../model/UserModel.php';
require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/ApiOlx/public");

$app->get('/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello" .$name);
    return $response;
});

require __DIR__.'/../routes/products.php';

$app->run();

?>