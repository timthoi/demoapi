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
* HTML View class for the Golidays component
*
* @package	Golidays
* @subpackage	Usercoupons
*/
class GolidaysViewUsercoupons extends GolidaysClassView
{
	/**
	* List of the reachables layouts. Fill this array in every view file.
	*
	* @var array
	*/
	protected $layouts = array('default', 'modal');

	/**
	* Execute and display a template : Usercoupons
	*
	* @access	protected
	* @param	string	$tpl	The name of the template file to parse; automatically searches through the template paths.
	*
	*
	* @since	11.1
	*
	* @return	mixed	A string if successful, otherwise a JError object.
	*/
	protected function displayDefault($tpl = null)
	{
		$this->model		= $model	= $this->getModel();
		$this->state		= $state	= $this->get('State');
		$this->params 		= JComponentHelper::getParams('com_golidays', true);
		$state->set('context', 'usercoupons.default');
		$this->items		= $items	= $this->get('Items');
		$this->canDo		= $canDo	= GolidaysHelper::getActions();
		$this->pagination	= $this->get('Pagination');
		$this->filters = $filters = $model->getForm('default.filters');
		$this->menu = GolidaysHelper::addSubmenu('usercoupons', 'default');
		$lists = array();
		$this->lists = &$lists;

		// Define the title
		$this->_prepareDocument(JText::_('GOLIDAYS_LAYOUT_RESERVATIONS'));


		// FILTERs
		// User By > Name
		$modelCreatedBy = CkJModel::getInstance('users', 'GolidaysModel');
		$modelCreatedBy->set('context', $model->get('context'));
		$filters['filter_user_id']->jdomOptions = array(
			'list' => $modelCreatedBy->getItems()
		);

		$modelCoupons = CkJModel::getInstance('coupons', 'GolidaysModel');
		$modelCoupons->set('context', $model->get('context'));
		$filters['filter_coupon_id']->jdomOptions = array(
			'list' => $modelCoupons->getItems()
		);


		// Sort by
		$filters['sortTable']->jdomOptions = array(
			'list' => $this->getSortFields('default')
		);

		// Limit
		$filters['limit']->jdomOptions = array(
			'pagination' => $this->pagination
		);

		// Toolbar
		JToolBarHelper::title(JText::_('GOLIDAYS_LAYOUT_RESERVATIONS'), 'list');

		// New
		if ($model->canCreate())
			JToolBarHelper::addNew('usercoupon.add', "GOLIDAYS_JTOOLBAR_NEW");

		// Edit
		if ($model->canEdit())
			JToolBarHelper::editList('usercoupon.edit', "GOLIDAYS_JTOOLBAR_EDIT");

		// Delete
		if ($model->canDelete())
			JToolBarHelper::deleteList(JText::_('GOLIDAYS_JTOOLBAR_ARE_YOU_SURE_TO_DELETE'), 'usercoupon.delete', "GOLIDAYS_JTOOLBAR_DELETE");

		// Publish
		if ($model->canEditState())
			JToolBarHelper::publishList('usercoupons.publish', "GOLIDAYS_JTOOLBAR_PUBLISH");

		// Unpublish
		if ($model->canEditState())
			JToolBarHelper::unpublishList('usercoupons.unpublish', "GOLIDAYS_JTOOLBAR_UNPUBLISH");

		JToolBarHelper::apply('usercoupons.export_excel', 'Export');
	}


	/**
	* Returns an array of fields the table can be sorted by.
	*
	* @access	protected
	* @param	string	$layout	The name of the called layout. Not used yet
	*
	*
	* @since	3.0
	*
	* @return	array	Array containing the field name to sort by as the key and display text as value.
	*/
	protected function getSortFields($layout = null)
	{
		return array(
			'a.ordering' => JText::_('GOLIDAYS_FIELD_ORDERING'),
			'a.modification_date' => JText::_('GOLIDAYS_FIELD_MODIFICATION_DATE')
		);
	}


}



