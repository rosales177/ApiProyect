<?php
namespace App\Services;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use \Exception;

class Upload_Image {

    protected $container;

    public function __construct(ContainerInterface $c){
        $this->container = $c;
    }

    public function uploadUser($request,$response,$args){
        $cfg = $this->container->get('routes');
        $directory = $cfg->PATH_IMG_USER;
        $uri = $cfg->PATH_URL_DIR_IMAGE_USER;
        try{
            $uploadedFiles = $request->getUploadedFiles();

            // handle single input with single file upload
            $uploadedFile = $uploadedFiles['file'];
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = $this->moveUploadedFile($directory, $uploadedFile);
                $response->getBody()->write(json_encode((array('Uploaded' => $uri.$filename ))));
                #$response->getBody()->write(json_encode($result));
                return $response
                ->withHeader('Content-Type','application/json')
                ->withStatus(200);
            }
        }
        catch(Exception $e){
            $result = array($e->getMessage());
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('Content-Type','application/json')
                ->withStatus(400);
        }
    }
    public function uploadProduct($request,$response,$args){
        $cfg = $this->container->get('routes');
        $directory = $cfg->PATH_IMG_PRODT;
        $uri = $cfg->PATH_URL_DIR_IMAGE_PROD;
        try{
            $uploadedFiles = $request->getUploadedFiles();

            // handle single input with single file upload
            $uploadedFile = $uploadedFiles['file'];
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = $this->moveUploadedFile($directory, $uploadedFile);
                $response->getBody()->write(json_encode((array('Uploaded' =>  $uri.$filename ))));
                #$response->getBody()->write(json_encode($result));
                return $response
                ->withHeader('Content-Type','application/json')
                ->withStatus(200);
            }
        }
        catch(Exception $e){
            $result = array($e->getMessage());
            $response->getBody()->write(json_encode($result));
            return $response
                ->withHeader('Content-Type','application/json')
                ->withStatus(400);
        }
    }
    public function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        // see http://php.net/manual/en/function.random-bytes.php
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
       
        
        return $filename;
    }

}


?>