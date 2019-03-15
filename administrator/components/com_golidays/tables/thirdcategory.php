<?php
/**
* @version		
* @package		Golidays
* @subpackage	Categories
* @copyright	
* @author		 Harvey - timthoi
* @license		
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

// no direct access
defined('_JEXEC') or die('Restricted access');



/**
* Golidays Table class
*
* @package	Golidays
* @subpackage	Category
*/
class GolidaysTableThirdcategory extends GolidaysClassTable
{
	/**
	* Constructor
	*
	* @access	public
	* @param	object	&$db	Database connector object
	* @param	string	$tbl	Table name
	* @param	string	$key	Primary key
	*
	* @return	void
	*/
	public function __construct(&$db, $tbl = '#__categories', $key = 'id')
	{
		parent::__construct($tbl, $key, $db);
	}


}



