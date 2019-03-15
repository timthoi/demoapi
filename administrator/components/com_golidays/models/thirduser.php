<?php
/**
* @version		
* @package		Golidays
* @subpackage	Users
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
* Golidays Item Model
*
* @package	Golidays
* @subpackage	Classes
*/
class GolidaysModelThirduser extends GolidaysClassModelItem
{
	/**
	* View list alias
	*
	* @var string
	*/
	protected $view_item = 'thirduser';

	/**
	* View list alias
	*
	* @var string
	*/
	protected $view_list = 'thirdusers';

	/**
	* Constructor
	*
	* @access	public
	* @param	array	$config	An optional associative array of configuration settings.
	*
	* @return	void
	*/
	public function __construct($config = array())
	{
		parent::__construct();
	}

	/**
	* Returns a Table object, always creating it.
	*
	* @access	public
	* @param	string	$type	The table type to instantiate.
	* @param	string	$prefix	A prefix for the table class name. Optional.
	* @param	array	$config	Configuration array for model. Optional.
	*
	*
	* @since	1.6
	*
	* @return	JTable	A database object
	*/
	public function getTable($type = 'thirduser', $prefix = 'GolidaysTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	* Preparation of the query.
	*
	* @access	protected
	* @param	object	&$query	returns a filled query object.
	* @param	integer	$pk	The primary id key of the user
	*
	* @return	void
	*/
	protected function prepareQuery(&$query, $pk)
	{

		$acl = GolidaysHelper::getActions();

		// FROM : Main table
		$query->from('#__users AS a');



		// IMPORTANT REQUIRED FIELDS
		$this->addSelect(	'a.id');


		switch($this->getState('context', 'all'))
		{

			case 'all':
				// SELECT : raw complete query without joins
				$query->select('a.*');
				break;
		}

		// WHERE : Item layout (based on $pk)
		$query->where('a.id = ' . (int) $pk);		//TABLE KEY

		// FILTER - Access for : Root table


		// Apply all SQL directives to the query
		$this->applySqlStates($query);

	}


}



