<?php

define('DB_SERVER','mysql:host=localhost;port=3306;dbname=tellnova');
define('DB_USER','root');
define('DB_PASSWORD','');


class DBModel{

    private $conn;

    public function __construct(){
        try{
            $this->conn = new PDO(DB_SERVER,DB_USER,DB_PASSWORD);
            if(!$this->conn){
                throw new Exception("No se pudo establecer la conexión, intente más tarde.");
            }
        }
        catch(Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    protected function getProduct()
    {
        try{
            $stmt = $this->conn->prepare("SELECT * FROM product");
            $stmt->execute();
            $result = $stmt->fetchAll();

    
            return $result;

        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }
    protected function getProductForId($param)
    {
        try{
            $stmt = $this->conn->prepare('SELECT * FROM product WHERE id_Product = ? ');
            $stmt->execute(array($param));
            $result = $stmt->fetchAll();

            return $result;
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

}

?>