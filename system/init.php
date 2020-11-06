<?php

require_once ('system/App.php');
require_once ('system/Controller.php');
require_once ('system/Model.php');

spl_autoload_register(function($file) {
  
    if (file_exists(MODELSDAO. $file . '.class.php')) {
       
        require_once (MODELSDAO . $file . '.class.php');
        
    } elseif (file_exists(MODELSCLASS. $file . '.php')) {
         
        require_once (MODELSCLASS . $file . '.php');
        
    }  elseif (file_exists(HELPERS . $file . '.php')) {
     
        
        require_once (HELPERS . $file . '.php');
        
    }  else {
        //die("Model ou helper não existe!!!"); 
    }
}
); 
$app = new App();
$app->run();
