<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


$app=AppFactory::create();
$app->setBasePath("/ApiOlx/public");

$app->get('/products/all',function (Request $request,Response $response){

    try{
        $db = new UserModel();
        $products = $db->getProductos();
        $response->getBody()->write(json_encode($products));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
    }catch (Exception $e){
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);
    }
    
});

$app->get('/products/{id}',function (Request $request,Response $response, array $args){
    try{
        $id = $args['id'];
        $db = new UserModel();
        $products = $db->getProductosForId($id);
        $response->getBody()->write(json_encode($products));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
    }catch (Exception $e){
        $error = array(
            "message" => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);
    }
});


?>