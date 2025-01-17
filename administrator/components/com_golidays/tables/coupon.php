<?php
/**
* @version		
* @package		Golidays
* @subpackage	Cities
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
* @subpackage	Coupon
*/
class GolidaysTableCoupon extends GolidaysClassTable
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
	public function __construct(&$db, $tbl = '#__demo_coupons', $key = 'id')
	{
		parent::__construct($tbl, $key, $db);
	}


}



