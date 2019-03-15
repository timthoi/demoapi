<?php
/**
* @version		v0.0.1
* @package		Golidays
* @subpackage	Email Templates
* @copyright	harvey
* @author		harvey - redweb.com
* @license		
*/

// no direct access
defined('_JEXEC') or die('Restricted access');



/**
* HTML View class for the Golidays component
*
* @package	Golidays
* @subpackage	Users
*/
class GolidaysViewUsers extends GolidaysClassView
{
	/**
	* List of the reachables layouts. Fill this array in every view file.
	*
	* @var array
	*/
	protected $layouts = array('default');

	/**
	* Execute and display a template : Email Templates
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
		$state->set('context', 'users.default');
		$this->items		= $items	= $this->get('Items');

		$this->canDo		= $canDo	= GolidaysHelper::getActions();
		$this->pagination	= $this->get('Pagination');
        $this->filters = $filters = $model->getForm('default.filters');
		$this->menu = GolidaysHelper::addSubmenu('users', 'default');
		$lists = array();
		$this->lists = &$lists;

		// Define the title
		$this->_prepareDocument(JText::_('GOLIDAYS_LAYOUT_USERS'));

		

		//Filters
		// Sort by
		$filters['sortTable']->jdomOptions = array(
			'list' => $this->getSortFields('default')
		);

		// Limit
		$filters['limit']->jdomOptions = array(
			'pagination' => $this->pagination
		);

		// Toolbar
		JToolBarHelper::title(JText::_('GOLIDAYS_LAYOUT_USERS'), 'list');

		// New
		if ($model->canCreate())
			JToolBarHelper::addNew('user.add', "GOLIDAYS_JTOOLBAR_NEW");

		// Edit
		if ($model->canEdit())
			JToolBarHelper::editList('user.edit', "GOLIDAYS_JTOOLBAR_EDIT");

		// Delete
		if ($model->canDelete())
			JToolBarHelper::deleteList(JText::_('GOLIDAYS_JTOOLBAR_ARE_YOU_SURE_TO_DELETE'), 'user.delete', "GOLIDAYS_JTOOLBAR_DELETE");
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
			'a.code' => JText::_('GOLIDAYS_FIELD_CODE_USER'),
			'a.id' => JText::_('GOLIDAYS_FIELD_ID')
		);
	}


}


