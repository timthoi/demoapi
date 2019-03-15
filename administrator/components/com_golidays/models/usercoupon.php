<?php
/**
* @version		
* @package		Golidays
* @subpackage	Usercoupons
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
class GolidaysModelUsercoupon extends GolidaysClassModelItem
{
	/**
	* View list alias
	*
	* @var string
	*/
	protected $view_item = 'usercoupon';

	/**
	* View list alias
	*
	* @var string
	*/
	protected $view_list = 'usercoupons';

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
		return $jinput->get('layout', 'usercoupon', 'STRING');
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
	public function getTable($type = 'usercoupon', $prefix = 'GolidaysTable', $config = array())
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
		$data = JFactory::getApplication()->getUserState('com_golidays.edit.usercoupon.data', array());

		if (empty($data)) {
			//Default values shown in the form for new item creation
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('usercoupon.id') == 0)
			{
				$jinput = JFactory::getApplication()->input;

				$data->id = 0;
				$data->status = null;
				$data->coupon_id = $jinput->get('filter_coupon_id', $this->getState('filter.coupon_id'), 'INT');
				$data->user_id = $jinput->get('filter_user_id', $this->getState('filter.user_id'), 'INT');

				$data->modification_date = null;
				$data->ordering = null;
				$data->published = 1;

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
	* @param	integer	$pk	The primary id key of the usercoupon
	*
	* @return	void
	*/
	protected function prepareQuery(&$query, $pk)
	{

		$acl = GolidaysHelper::getActions();

// FROM : Main table
		$query->from('#__demo_user_coupon AS a');

		// IMPORTANT REQUIRED FIELDS
		$this->addSelect(	'a.id,'
			.	'a.published');

		// BASE FIELDS
		$this->addSelect(	'a.user_id,'
			.	'a.coupon_id,'
			.	'a.status,'
			.	'a.creation_date,'
			.	'a.modification_date');

		// SELECT
		$this->addSelect('_demo_users_.username AS `username`');
		$this->addSelect('_demo_users_.first_name AS `first_name`');
		$this->addSelect('_demo_users_.last_name AS `last_name`');
		// SELECT
		$this->addSelect('_demo_coupons_.token AS `token`');

		// JOIN

		$this->addJoin('`#__demo_users` AS _demo_users_ ON _demo_users_.id = a.user_id', 'LEFT');
		$this->addJoin('`#__demo_coupons` AS _demo_coupons_ ON _demo_coupons_.id = a.coupon_id', 'LEFT');


		switch($this->getState('context', 'all'))
		{
			case 'usercoupon.usercoupon':

				
				break;
			case 'all':
				// SELECT : raw complete query without joins
				$query->select('a.*');
				break;
		}

		// WHERE : Item layout (based on $pk)
		$query->where('a.id = ' . (int) $pk);		//TABLE KEY

		// FILTER - Access for : Root table
		$wherePublished = $allowAuthor = true;
		$whereAccess = false;
		//$this->prepareQueryAccess('a', $whereAccess, $wherePublished, $allowAuthor);
		//$query->where("($allowAuthor OR $wherePublished)");

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
			//Defines automatically the author of this element


			// Set ordering to the last item if not set
			$conditions = $this->getReorderConditions($table);
			$conditions = (count($conditions)?implode(" AND ", $conditions):'');
			$table->ordering = $table->getNextOrder($conditions);
		}
		else
		{
			//Modification date
			$table->modification_date = JFactory::getDate()->toSql();
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
		//Convert from a non-SQL formated date (departure_date)
		$data['departure_date'] = GolidaysHelperDates::getSqlDate($data['departure_date'], array('Y-m-d'), true, 'USER_UTC');

		//Convert from a non-SQL formated date (arrival_date)
		$data['arrival_date'] = GolidaysHelperDates::getSqlDate($data['arrival_date'], array('Y-m-d'), true, 'USER_UTC');

		//Convert from a non-SQL formated date (birthday)
		$data['birthday'] = GolidaysHelperDates::getSqlDate($data['birthday'], array('Y-m-d'), true, 'USER_UTC');

		//Convert from a non-SQL formated date (creation_date)
		$data['creation_date'] = GolidaysHelperDates::getSqlDate($data['creation_date'], array('Y-m-d H:i'), true, 'USER_UTC');

		//Convert from a non-SQL formated date (modification_date)
		$data['modification_date'] = GolidaysHelperDates::getSqlDate($data['modification_date'], array('Y-m-d H:i'), true, 'USER_UTC');
		//Some security checks
		$acl = GolidaysHelper::getActions();

		//Secure the author key if not allowed to change
		if (isset($data['created_by']) && !$acl->get('core.edit'))
			unset($data['created_by']);

		//Secure the published tag if not allowed to change
		if (isset($data['published']) && !$acl->get('core.edit.state'))
			unset($data['published']);

		if (parent::save($data)) {
			return true;
		}
		return false;
	}

	/**
	 * Method to upate an element.
	 *
	 * @access	public
	 * @param	object	$object Object booking update
	 *
	 * @return	void
	 */
	public function update($object)
	{
		$result = JFactory::getDbo()->updateObject('#__demo_user_coupon', $object, 'id');
	}

	public function insert($object) {
		// Create and populate an object.
		$result = JFactory::getDbo()->insertObject('#__demo_user_coupon', $object);

		return $result;
	}
}



