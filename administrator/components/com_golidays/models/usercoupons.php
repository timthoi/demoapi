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
* Golidays List Model
*
* @package	Golidays
* @subpackage	Classes
*/
class GolidaysModelUsercoupons extends GolidaysClassModelList
{
	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'usercoupon';

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
		// Define the sortables fields (in lists)
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
				'ordering', 'a.ordering',
				'modification_date', 'a.modification_date'
			);
		}

		//Define the filterable fields
		$this->set('filter_vars', array(
			'published' => 'cmd',
			'sortTable' => 'cmd',
			'directionTable' => 'cmd',
			'limit' => 'cmd',
			'coupon_id' => 'cmd',
			'user_id' => 'cmd',
			'modification_date_from' => 'varchar',
			'modification_date_to' => 'varchar',
			'creation_date_from' => 'varchar',
			'creation_date_to' => 'varchar'
				));

		//Define the searchable fields
		$this->set('search_vars', array(
			'search' => 'string'
				));


		parent::__construct($config);


	}

	/**
	* Method to get a list of items.
	*
	* @access	public
	*
	*
	* @since	11.1
	*
	* @return	mixed	An array of data items on success, false on failure.
	*/
	public function getItems()
	{

		$items	= parent::getItems();
		$app	= JFactory::getApplication();


		$this->populateParams($items);

		//Create linked objects
		$this->populateObjects($items);

		return $items;
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
		return $jinput->get('layout', 'default', 'STRING');
	}

	/**
	* Method to get a store id based on model configuration state.
	* 
	* This is necessary because the model is used by the component and different
	* modules that might need different sets of data or differen ordering
	* requirements.
	*
	* @access	protected
	* @param	string	$id	A prefix for the store id.
	*
	*
	* @since	1.6
	*
	* @return	void
	*/
	protected function getStoreId($id = '')
	{
		// Compile the store id.

		$id	.= ':'.$this->getState('sortTable');
		$id	.= ':'.$this->getState('directionTable');
		$id	.= ':'.$this->getState('limit');
		$id	.= ':'.$this->getState('filter.published');
		$id	.= ':'.$this->getState('filter.modification_date');
		$id	.= ':'.$this->getState('filter.creation_date');
		$id	.= ':'.$this->getState('filter.coupon_id');
		$id	.= ':'.$this->getState('filter.user_id');
		$id	.= ':'.$this->getState('search.search');
		return parent::getStoreId($id);
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
	* @param	string	$ordering	
	* @param	string	$direction	
	*
	*
	* @since	11.1
	*
	* @return	void
	*/
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication();
		$session = JFactory::getSession();
		$acl = GolidaysHelper::getActions();


		parent::populateState(
			($ordering?$ordering:'a.creation_date'),
			($direction?$direction:'desc')
		);

		// Only show the published items
		if (!$acl->get('core.admin') && !$acl->get('core.edit.state'))
		{
			$this->setState('filter.published', 1);
		}
	}

	/**
	* Preparation of the list query.
	*
	* @access	protected
	* @param	object	&$query	returns a filled query object.
	*
	* @return	void
	*/
	protected function prepareQuery(&$query)
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
		$this->addSelect('_demo_users_.phone AS `phone`');
		$this->addSelect('_demo_users_.email AS `email`');
		// SELECT
		$this->addSelect('_demo_coupons_.token AS `token`');

		// JOIN

		$this->addJoin('`#__demo_users` AS _demo_users_ ON _demo_users_.id = a.user_id', 'LEFT');
		$this->addJoin('`#__demo_coupons` AS _demo_coupons_ ON _demo_coupons_.id = a.coupon_id', 'LEFT');


		switch($this->getState('context', 'all'))
		{
			case 'usercoupons.default':

				
				break;

			case 'usercoupons.modal':

				// BASE FIELDS
				$this->addSelect(	'a.departure_date');


				break;
			case 'all':
				// SELECT : raw complete query without joins
				$this->addSelect('a.*');

				// Disable the pagination
				$this->setState('list.limit', null);
				$this->setState('list.start', null);
				break;
		}

		// FILTER - Access for : Root table
		$wherePublished = $allowAuthor = true;
		$whereAccess = false;
		//$this->prepareQueryAccess('a', $whereAccess, $wherePublished, $allowAuthor);
		//$query->where("($allowAuthor OR $wherePublished)");

		// WHERE - FILTER : Publish state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$allowAuthor = '';
			if (($published == 1) && !$acl->get('core.edit.state')) //ACL Limit to publish = 1
			{
				//Allow the author to see its own unpublished/archived/trashed items
				if ($acl->get('core.edit.own') || $acl->get('core.view.own')){
					//$allowAuthor = ' OR a.created_by = ' . (int)JFactory::getUser()->get('id');
				}

			}
			$query->where('(a.published = ' . (int) $published . $allowAuthor . ')');
		}
		elseif (!$published)
		{
			$query->where('(a.published = 0 OR a.published = 1 OR a.published IS NULL)');
		}


		if ($filter_coupon_id = $this->getState('filter.coupon_id'))
		{
			if ($filter_coupon_id !== null){
				$this->addWhere("a.coupon_id = " . $this->_db->Quote($filter_coupon_id));
			}
		}

		if ($filter_user_id = $this->getState('filter.user_id'))
		{
			if ($filter_user_id !== null){
				$this->addWhere("a.user_id = " . $this->_db->Quote($filter_user_id));
			}
		}

		if ($filter_modification_date_to = $this->getState('filter.modification_date_to'))
		{
		if ($filter_modification_date_to !== null){
				$this->addWhere("a.modification_date <= " . $this->_db->Quote($filter_modification_date_to));
		}
		}

		if ($filterCreationDateFrom = $this->getState('filter.creation_date_from'))
		{
		if ($filterCreationDateFrom !== null){
				$this->addWhere("a.creation_date >= " . $this->_db->Quote($filterCreationDateFrom));
		}
		}

		if ($filterCreationDateTo = $this->getState('filter.creation_date_to'))
		{
		if ($filterCreationDateTo !== null){
				$this->addWhere("a.creation_date <= " . $this->_db->Quote($filterCreationDateTo));
		}
		}

		// WHERE - SEARCH : search_search : search on Number Adult Ticket + Number Childrent Ticket 1 + Number Childrent Ticket 2 + Information Adult + Information Child 1 + Information Child 2 + Name + Surname + Phone + Address + Zip Code + City + Email + Ticket Price + Ticket Total
		$search_search = $this->getState('search.search');
		$this->addSearch('search', '_demo_users_.username', 'like');
		$this->addSearch('search', '_demo_users_.first_name', 'like');
		$this->addSearch('search', '_demo_users_.last_name', 'like');
		$this->addSearch('search', '_demo_coupons_.token', 'like');
		if (($search_search != '') && ($search_search_val = $this->buildSearch('search', $search_search)))
			$this->addWhere($search_search_val);

		// Apply all SQL directives to the query
		$this->applySqlStates($query);
	}


}



