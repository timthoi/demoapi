<?php
/**
* @version		
* @package		Golidays
* @subpackage	coupons
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
class GolidaysModelCoupon extends GolidaysClassModelItem
{
	/**
	* View list alias
	*
	* @var string
	*/
	protected $view_item = 'coupon';

	/**
	* View list alias
	*
	* @var string
	*/
	protected $view_list = 'coupons';

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
	* Method to delete item(s).
	*
	* @access	public
	* @param	array	&$pks	Ids of the items to delete.
	*
	* @return	boolean	True on success.
	*/
	public function delete(&$pks)
	{
		if (!count( $pks ))
		{
			return true;
		}


		if (!parent::delete($pks))
		{
		return false;
		}



		return true;
	}

	/**
	* Method to get the layout (including default).
	*
	* @access	public
	*
	* @return	string	The layout alias.
	*/
	public function getLayout()
	{
		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', 'coupon', 'STRING');
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
	public function getTable($type = 'coupon', $prefix = 'GolidaysTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	* Method to increment hits (check session and layout)
	*
	* @access	public
	* @param	array	$layouts	List of authorized layouts for hitting the object.
	*
	*
	* @since	11.1
	*
	* @return	boolean	Null if skipped. True when incremented. False if error.
	*/
	public function hit($layouts = null)
	{
		return parent::hit(array());
	}

	/**
	* Method to get the data that should be injected in the form.
	*
	* @access	protected
	*
	* @return	mixed	The data for the form.
	*/
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_golidays.edit.coupon.data', array());

		if (empty($data)) {
			//Default values shown in the form for new item creation
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('coupon.id') == 0)
			{
				$jinput = JFactory::getApplication()->input;

				$data->id = 0;
				$data->token = null;
				$data->quantity = null;
				$data->description = null;
				$data->ordering = null;
				$data->published = null;

				$data->expired_date = null;
				$data->modification_date = null;
				$data->creation_date = null;
				$data->created_by = null;
				$data->modified_by = null;
			}
		}
		return $data;
	}

	/**
	* Method to auto-populate the model state.
	* 
	* This method should only be called once per instantiation and is designed to
	* be called on the first call to the getState() method unless the model
	* configuration flag to ignore the request is set.
	* 
	* Note. Calling getState in this method will result in recursion.
	*
	* @access	protected
	*
	*
	* @since	11.1
	*
	* @return	void
	*/
	protected function populateState()
	{
		$app = JFactory::getApplication();
		$session = JFactory::getSession();
		$acl = GolidaysHelper::getActions();



		parent::populateState();

		// Only show the published items
		if (!$acl->get('core.admin') && !$acl->get('core.edit.state'))
		{
			$this->setState('filter.published', 1);
		}
	}

	/**
	* Preparation of the query.
	*
	* @access	protected
	* @param	object	&$query	returns a filled query object.
	* @param	integer	$pk	The primary id key of the coupon
	*
	* @return	void
	*/
	protected function prepareQuery(&$query, $pk)
	{

		$acl = GolidaysHelper::getActions();

		// FROM : Main table
		$query->from('#__demo_coupons AS a');

		// IMPORTANT REQUIRED FIELDS
		$this->addSelect(	'a.id,'
			.	'a.token,'
			.	'a.quantity,'
			.	'a.description,'
			.	'a.expired_date,'
			.	'a.creation_date,'
			.	'a.modification_date,'
			.	'a.ordering,'
			.	'a.published');

		// SELECT
		$this->addSelect('_created_by_.name AS `_created_by_name`');
		$this->addSelect('_modified_by_.name AS `_modified_by_name`');

		// JOIN
		$this->addJoin('`#__users` AS _created_by_ ON _created_by_.id = a.created_by', 'LEFT');
		$this->addJoin('`#__users` AS _modified_by_ ON _modified_by_.id = a.modified_by', 'LEFT');

		switch($this->getState('context', 'all'))
		{
			case 'coupon.coupon':

				// BASE FIELDS

				break;
			case 'all':
				// SELECT : raw complete query without joins
				$query->select('a.*');
				break;
		}

		// WHERE : Item layout (based on $pk)
		$query->where('a.id = ' . (int) $pk);		//TABLE KEY

		// FILTER - Access for : Root table
		$wherePublished = true;
		$whereAccess = $allowAuthor = false;
		$this->prepareQueryAccess('a', $whereAccess, $wherePublished, $allowAuthor);
		$query->where("$wherePublished");

		// Apply all SQL directives to the query
		$this->applySqlStates($query);

	}

	/**
	* Prepare and sanitise the table prior to saving.
	*
	* @access	protected
	* @param	JTable	$table	A JTable object.
	*
	*
	* @since	1.6
	*
	* @return	void
	*/
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();


		if (empty($table->id))
		{
			// Set ordering to the last item if not set
			$conditions = $this->getReorderConditions($table);
			$conditions = (count($conditions)?implode(" AND ", $conditions):'');
			$table->ordering = $table->getNextOrder($conditions);
		}
		else
		{

		}

	}

	/**
	* Save an item.
	*
	* @access	public
	* @param	array	$data	The post values.
	*
	* @return	boolean	True on success.
	*/
	public function save($data)
	{

		//Some security checks
		$acl = GolidaysHelper::getActions();

		//Secure the published tag if not allowed to change
		if (isset($data['published']) && !$acl->get('core.edit.state'))
			unset($data['published']);

		if (parent::save($data)) {
			return true;
		}
		return false;


	}


}



