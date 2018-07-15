<?php
define('URL','http://'.$_SERVER['SERVER_NAME'].'/tasklist/');
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'].'/tasklist/');
define('TITULO','Tasklist');
define('QTDE_REGISTROS', 10);   
define('RANGE_PAGINAS', 10); 

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ini_set("display_errors", 1);
ini_set("date.timezone", "America/Sao_Paulo");