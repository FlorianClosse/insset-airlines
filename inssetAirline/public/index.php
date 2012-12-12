<?php
defined('APPLICATION_PATH') || define('APPLICATION_PATH',
		realpath(dirname(__FILE__) . '/../application'));

defined('LIBRARY_PATH') || define('LIBRARY_PATH',
		realpath(dirname(__FILE__) . '/../library'));

defined('APPLICATION_ENV') || define('APPLICATION_ENV',
		(getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));


//on modifie l'include path de php
set_include_path(implode(PATH_SEPARATOR, array(realpath(LIBRARY_PATH), get_include_path())));

require_once "Zend/Loader.php";
Zend_Loader::registerAutoload();

// on a besoin de zend app pour lancer l'application
require_once 'Zend/Application.php';

//on lance la session
require_once 'Zend/Session.php';
Zend_Session::start();




//on créee l'application, on lance le bootstrap et l'application
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');


//on modifie l'include path de php
set_include_path(implode(PATH_SEPARATOR, array(realpath(APPLICATION_PATH), get_include_path())));

//on a besoin des fonctions
require_once 'fonction/fonctionConvertirHeure.php';
require_once 'fonction/fonctionFormulaireChoixAeroport.php';


$application->bootstrap()->run();
?>
