<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CitasController{
    public static function getAll($request,$response,$arg){
        $response->getBody()->write("Hello world");
        return $response;
    }
}
?>