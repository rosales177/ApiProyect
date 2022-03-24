<?php
    require_once "DBModel.php";
    //include('../include/Config.php');

    class UserModel extends DBModel
    {
        public function getProductos(){
            try{
                $result = $this->getProduct();
                $Product = array();
                foreach($result as $rs):
                    $Product[] = array(
                        "Id_Product" => $rs['id_Product'],
                        "Cod_unid_venta" => $rs['cod_unidad_venta'],
                        "Des_categoria" => $rs['cod_categoria'],
                        "Des_linea_producto" => $rs['cod_linea_producto'],
                        "Des_marca" => $rs['cod_marca'],
                        "Cod_moneda_venta" => $rs['cod_moneda_venta'],
                        "Des_producto" => $rs['des_producto'],
                        "Imagenes_web" => array(
                            "Imagen_web1" => $rs['imagen_web'],
                            "Imagen_web2" => $rs['imagen_web2'],
                            "Imagen_web3" => $rs['imagen_web3'],
                            "Imagen_web4" => $rs['imagen_web4'],
                            "Imagen_web5" => $rs['imagen_web5'],
                        )
                    );
                endforeach;

                return $Product;
            }
            catch (Exception $e)
            {
                throw new Exception($e->getMessage());
            }
        }
        public function getProductosForId($param)
        {
            try{
                $result = $this->getProductForId($param);
                $Product = array();
                foreach ($result as $rs):
                    $Product[] = array(
                        "Id_Product" => $rs['id_Product'],
                        "Cod_unid_venta" => $rs['cod_unidad_venta'],
                        "Des_categoria" => $rs['cod_categoria'],
                        "Des_linea_producto" => $rs['cod_linea_producto'],
                        "Des_marca" => $rs['cod_marca'],
                        "Cod_moneda_venta" => $rs['cod_moneda_venta'],
                        "Des_producto" => $rs['des_producto'],
                        "Imagenes_web" => array(
                            "Imagen_web1" => $rs['imagen_web'],
                            "Imagen_web2" => $rs['imagen_web2'],
                            "Imagen_web3" => $rs['imagen_web3'],
                            "Imagen_web4" => $rs['imagen_web4'],
                            "Imagen_web5" => $rs['imagen_web5'],
                        )
                    );
                endforeach;

                return $Product;
            }catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        private function data_uri($file,$mine)
        {
            $contents = file_get_contents($file);
            $base64 = base64_encode($contents);
            return('data:'.$mine.';base64,'.$base64);
        }

    

    }

?>