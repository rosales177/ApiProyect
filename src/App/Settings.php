<?php
define('PATH_ROOT',str_replace("\\","/",$_SERVER['DOCUMENT_ROOT']));
define('PATH_DIRECTORY',str_replace("\\","/",$_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.basename(dirname(dirname(__DIR__)))));
define('PATH_IMG_PRODT',PATH_DIRECTORY.'/Storage/ImageProducts/');
define('PATH_IMG_USER',PATH_DIRECTORY.'/Storage/ImageUsers/');
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $url = "https://"; 
}else{
    $url = "http://"; 
}
define('PATH_URL_DIR_IMAGE_USER', $url . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'].'Storage/ImageUsers/');
define('PATH_URL_DIR_IMAGE_PROD', $url . $_SERVER['HTTP_HOST'] .  $_SERVER['REQUEST_URI'].'Storage/ImageProducts/');
?>