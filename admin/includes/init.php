<?php
// Defining directory paths
// DIRECTORY_SEPARATOR = a predefined character definition -> /
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'] . DS . 'gallery');

defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin' . DS . 'includes');


// require_once more secure so it wont be includes anywhere else
// include will give warning and not a failure

require_once(INCLUDES_PATH.DS."functions.php");
require_once(INCLUDES_PATH.DS."new_config.php");
require_once(INCLUDES_PATH.DS."database.php");
require_once(INCLUDES_PATH.DS."db_object.php");

require_once(INCLUDES_PATH.DS."photo.php");
require_once(INCLUDES_PATH.DS."user.php");
require_once(INCLUDES_PATH.DS."session.php");
require_once(INCLUDES_PATH.DS."comment.php");

require_once(INCLUDES_PATH.DS."paginate.php");


?>