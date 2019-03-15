<?php
/** 
* @package		Golidays
* @subpackage	Golidays
* @copyright	
* @author		 -  - 
* @license		
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);

//Copy this line to be able to call the application from outside (Module, Plugin, Third component, ...)
require_once(JPATH_ADMINISTRATOR.'/components/com_golidays/helpers/loader.php');


$jinput = JFactory::getApplication()->input;
$controller = CkJController::getInstance('Golidays');

// When this component is called to return a file
if ($jinput->get('task', null, 'CMD') == 'file')
	GolidaysHelperFile::returnFile();



$controller->execute($jinput->get('task', null, 'CMD'));
$controller->redirect();

