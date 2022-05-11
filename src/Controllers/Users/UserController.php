<?php namespace App\Controllers\Users;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
USE App\Controllers\BaseController;
use \Exception;

class UserController extends BaseController {
    public function getUser($request,$response,$args){
        try{
            $conn = $this->container->get('db');
            $stm = $conn->prepare("SELECT * FROM user_");
            $stm->execute();
            $result = $stm->fetchAll();
            return $this->jsonResponse($response,'success',$result,200);
        }
        catch(Exception $e){
            $result = array($e->getMessage());
            return $this->jsonResponse($response,'error',$result,400);
        }
    }
    public function addUser($request,$response,$args){
        try{
            $body = json_decode($request->getBody(), true);
            $id_Cliente =intval($body['id_Cliente']);
            $id_Roll = intval($body['id_Roll']);
            $_Username = $body['_Username'];
            $_Password = password_hash(base64_decode($body['_Password']),PASSWORD_DEFAULT,['cost'=>10]);
            $_Status = intval($body['_Status']);
            $conn = $this->container->get('db');
            $sql = "CALL sp_InsertUser(:idCliente,:idRoll,:Username,:Password,:Status)";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':idCliente',$id_Cliente);
            $stm->bindParam(':idRoll',$id_Roll);
            $stm->bindParam(':Username',$_Username);
            $stm->bindParam(':Password',$_Password);
            $stm->bindParam(':Status',$_Status);
            $stm->execute();
            $result = $stm->fetchAll();
            return $this->jsonResponse($response,'success',$result,200);
        }
        catch(Exception $e){
            $result = array($e->getMessage());
            return $this->jsonResponse($response,'error',$result,400);
        }
    }
    public function modifyUser($request,$response,$args){
        try{
            $params =intval($args['id']);
            $body = json_decode($request->getBody(), true);
            $_Password = password_hash(base64_decode($body['_Password']),PASSWORD_DEFAULT,['cost'=>10]);
            $conn = $this->container->get('db');
            $sql = "CALL sp_UpdateUser(:idCliente,:Password)";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':idCliente',$params);
            $stm->bindParam(':Password',$_Password);
            $stm->execute();
            $result = $stm->fetchAll();
            return $this->jsonResponse($response,'success',$result,200);
        }
        catch(Exception $e){
            $result = array($e->getMessage());
            return $this->jsonResponse($response,'error',$result,400);
        }
    }
    public function deleteUser($request,$response,$args){
        try{
            $params =intval($args['id']);
            $conn = $this->container->get('db');
            $sql = "CALL sp_DeleteUser(:idCliente)";
            $stm = $conn->prepare($sql);
            $stm->bindParam(':idCliente',$params);
            $stm->execute();
            $result = $stm->fetchAll();
            return $this->jsonResponse($response,'success',$result,200);
        }catch(Exception $e){
            $result = array($e->getMessage());
            return $this->jsonResponse($response,'error',$result,400);
        }
    }
    public function getUserById($request,$response,$args){
        try{
            $params = array($args['id']);
            $conn = $this->container->get('db');
            $sql = "CALL sp_SelectUserId(?)";
            $stm = $conn->prepare($sql);
            $stm->execute($params);
            $result = $stm->fetchAll();
            return $this->jsonResponse($response,'success',$result,200);
        }catch(Exception $e){
            $result = array($e->getMessage());
            return $this->jsonResponse($response,'error',$result,400);
        }
    }
    public function getCountUser($request,$response,$args){
        try{
            $conn = $this->container->get('db');
            $stm = $conn->prepare( "SELECT * FROM v_sCantidadUser");
            $stm->execute();
            $result = $stm->fetchAll();
            return $this->jsonResponse($response,'success',$result,200);
        }catch(Exception $e){
            $result = array($e->getMessage());
            return $this->jsonResponse($response,'error',$result,400);
        }
    }

    public function oauth($request,$response,$args){
        $body = json_decode($request->getBody(), true);
        $pass = base64_decode($body['password']);
        $params = array( base64_decode($body['username']));
        $conn = $this->container->get('db');
        $sql1 = "SELECT * FROM user_ WHERE _Username = ? AND _Status = 1";
        $stm = $conn->prepare($sql1);
        $stm->execute($params);
        if($stm->rowCount() > 0){
            $result = $stm->fetchAll();
            foreach($result as $rs){
                $hash = $rs->{'_Password'};
            }
            if(password_verify($pass, $hash ))
            {
                $params2 = array(base64_decode($body['username']),$hash);
                $sql2 = "CALL sp_GetDataUser(?,?)";
                // $sql2 = "SELECT * FROM cliente AS C JOIN user_ AS U ON C.id_Cliente = U.id_Cliente WHERE _Username = ? AND _Password = ? ";
                $stmt = $conn->prepare($sql2);
                $stmt->execute($params2);
                $resultOffice = $stmt->fetchAll();
                return $this->jsonResponse($response,'success',$resultOffice,200);
            }else
            {
                $result = array("Error"=>"Error en la autenticacion.");
                return $this->jsonResponse($response,'Bad Request',$result,400);
            }        
        }else{
            $result = array("Error"=>"El usuario no a sido encontrado o la cuenta ha sido deshabilidata.");
            return $this->jsonResponse($response,'Bad Request',$result,400);
        }
    }

}

?>