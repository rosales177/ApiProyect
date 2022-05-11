<?php
    $container->set('db_settings',function(){
        return (object)[
            "DB_NAME"=>"DB_OLX_V1",
            //"DB_PASS"=>"MIKI1",
            "DB_PASS"=>"",
            "DB_CHAR"=>"utf8",
            "DB_HOST"=>"127.0.0.1:3306",
            "DB_USER"=>"root",
        ];
    });
    $container->set('routes_dir',function(){
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $url = "https://"; 
        }else{
            $url = "http://"; 
        }
        $root = str_replace("\\","/",$_SERVER['DOCUMENT_ROOT']);
        $directory_project = str_replace("\\","/",$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.basename(dirname(dirname(__DIR__))));
        $prod_img = $directory_project.'/Storage/ImageProducts/';
        $user_img = $directory_project.'/Storage/ImageUsers/';
        $url_user_img = $url . $_SERVER['HTTP_HOST'] .'/'.basename(dirname(dirname(__DIR__))).'/Storage/ImageUsers/';
        $url_prod_img = $url . $_SERVER['HTTP_HOST'] .'/'.basename(dirname(dirname(__DIR__))).'/Storage/ImageProducts/';
        return (object)[
            'PATH_ROOT' => $root,
            'PATH_DIRECTORY' => $directory_project,
            'PATH_IMG_PRODT' => $prod_img,
            'PATH_IMG_USER' => $user_img,
            'PATH_URL_DIR_IMAGE_USER' => $url_user_img,
            'PATH_URL_DIR_IMAGE_PROD' => $url_prod_img
        ];
    });
?>