<?php
session_cache_expire(10); // Duração da Sessão 10 minutos
session_start();
header("Content-type: text/html; charset=utf-8");
define('DEVELOPMENT_ENVIRONMENT', true);
define('APP_NAME', 'intercolegial');
//define('APP_NAME', '/intercolegialtinatune.co.ao');
define('COPYRIGHT', '© 2020 Todos direitos reservados.');
define('DEVELOPERS', 'Júlio Manuel #UNSTOPPABLEMIND');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('CONTROLLERS', ROOT . DS . 'app' . DS . 'controllers' . DS);
define('VIEWS', ROOT . DS . 'app' . DS . 'views' . DS);
define('MODELS', ROOT . DS . 'app' . DS . 'models' . DS);
define('MODELSDAO', ROOT . DS . 'app' . DS . 'models' . DS. 'dao'.DS);
define('MODELSCLASS', ROOT . DS . 'app' . DS . 'models' . DS. 'class'.DS);

define('HELPERS', ROOT . DS . 'system' . DS . 'helpers' . DS);
define('TCPDF', ROOT . DS . 'system' . DS . 'helpers' . DS. 'TCPDF' . DS);
define('PHPMailer', ROOT . DS . 'system' . DS . 'helpers' . DS. 'PHPMailer' . DS);
require_once 'system/config.php';

setReporting(); 

require_once 'system/init.php';

