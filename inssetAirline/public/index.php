<?php
defined('APPLICATION_PATH') || define('APPLICATION_PATH',
		realpath(dirname(__FILE__) . '/../application'));

defined('LIBRARY_PATH') || define('LIBRARY_PATH',
		realpath(dirname(__FILE__) . '/../library'));

defined('APPLICATION_ENV') || define('APPLICATION_ENV',
		(getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));


//on modifie l'include path de php
set_include_path(implode(PATH_SEPARATOR, array(realpath(LIBRARY_PATH), get_include_path())));

// on a besoin de zend app pour lancer l'application
require_once 'Zend/Application.php';

//on lance la session
require_once 'Zend/Session.php';
Zend_Session::start();




//on créee l'application, on lance le bootstrap et l'application
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');


//on modifie l'include path de php
set_include_path(implode(PATH_SEPARATOR, array(realpath(APPLICATION_PATH), get_include_path())));

//on a besoin des models
require_once 'models/class_aeroport.php';
require_once 'models/class_vol.php';

require_once 'models/class_jour.php';
require_once 'models/class_liaisonvoljour.php';
require_once 'models/class_datevolalacarte.php';

//on a besoin des fonctions
require_once 'fonction/fonctionConvertirHeure.php';
require_once 'fonction/fonctionFormulaireChoixAeroport.php';

require_once 'models/class_avion.php';
require_once 'models/class_aeroport.php';
require_once 'models/class_brevet.php';
require_once 'models/class_commentaireVol.php';
require_once 'models/class_dateVolALaCarte.php';
require_once 'models/class_modele.php';
require_once 'models/class_jour.php';
require_once 'models/class_journalDeBord.php';
require_once 'models/class_liaisonBrevetModele.php';
require_once 'models/class_liaisonVolJour.php';
require_once 'models/class_messageModifVol.php';
require_once 'models/class_liaisonPiloteBrevet.php';
require_once 'models/class_liaisonVolJour.php';
require_once 'models/class_modele.php';
require_once 'models/class_pays.php';
require_once 'models/class_pilote.php';
require_once 'models/class_reservation.php';
require_once 'models/class_revision.php';
require_once 'models/class_user.php';
require_once 'models/class_ville.php';

$application->bootstrap()->run();
?>
