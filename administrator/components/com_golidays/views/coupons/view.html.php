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
* HTML View class for the Golidays component
*
* @package	Golidays
* @subpackage	coupons
*/
class GolidaysViewCoupons extends GolidaysClassView
{
	/**
	* List of the reachables layouts. Fill this array in every view file.
	*
	* @var array
	*/
	protected $layouts = array('default');

	/**
	* Execute and display a template : coupons
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
		$state->set('context', 'coupons.default');
		$this->items		= $items	= $this->get('Items');
		$this->canDo		= $canDo	= GolidaysHelper::getActions();
		$this->pagination	= $this->get('Pagination');
		$this->filters = $filters = $model->getForm('default.filters');
		$this->menu = GolidaysHelper::addSubmenu('coupons', 'default');
		$lists = array();
		$this->lists = &$lists;

		// Define the title
		$this->_prepareDocument(JText::_('GOLIDAYS_LAYOUT_couponS'));
		

		// FILTERs
		// Sort by
		$filters['sortTable']->jdomOptions = array(
			'list' => $this->getSortFields('default')
		);

		// Limit
		$filters['limit']->jdomOptions = array(
			'pagination' => $this->pagination
		);

		// Toolbar
		JToolBarHelper::title(JText::_('GOLIDAYS_LAYOUT_couponS'), 'list');

		// New
		if ($model->canCreate())
			JToolBarHelper::addNew('coupon.add', "GOLIDAYS_JTOOLBAR_NEW");

		// Edit
		if ($model->canEdit())
			JToolBarHelper::editList('coupon.edit', "GOLIDAYS_JTOOLBAR_EDIT");

		// Delete
		if ($model->canDelete())
			JToolBarHelper::deleteList(JText::_('GOLIDAYS_JTOOLBAR_ARE_YOU_SURE_TO_DELETE'), 'coupon.delete', "GOLIDAYS_JTOOLBAR_DELETE");

		// Publish
		if ($model->canEditState())
			JToolBarHelper::publishList('coupons.publish', "GOLIDAYS_JTOOLBAR_PUBLISH");

		// Unpublish
		if ($model->canEditState())
			JToolBarHelper::unpublishList('coupons.unpublish', "GOLIDAYS_JTOOLBAR_UNPUBLISH");

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
			'a.name' => JText::_('GOLIDAYS_FIELD_NAME'),
			'a.value' => JText::_('GOLIDAYS_FIELD_VALUE')
		);
	}


}



