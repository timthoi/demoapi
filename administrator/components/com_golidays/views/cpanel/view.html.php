<?php
/**
* @version		
* @package		Golidays
* @subpackage	Golidays
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
* @subpackage	Cpanel
*/
class GolidaysViewCpanel extends GolidaysClassView
{
	/**
	* List of the reachables layouts. Fill this array in every view file.
	*
	* @var array
	*/
	protected $layouts = array('default', 'modal');

	/**
	* Execute and display a template : Control Panel
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
		$this->menu = GolidaysHelper::addSubmenu('cpanel', 'default', 'cpanel');
		$this->params = new JRegistry();

		// Define the title
		$this->_prepareDocument(JText::_('GOLIDAYS_LAYOUT_CONTROL_PANEL'));

		// Deprecated var : use $this->params->get('page_heading')
		$this->title = $this->params->get('page_heading');
		// Toolbar
		JToolBarHelper::title(JText::_('GOLIDAYS_LAYOUT_CONTROL_PANEL'), 'generic');


	}

	/**
	* Execute and display a template : Control Panel
	*
	* @access	protected
	* @param	string	$tpl	The name of the template file to parse; automatically searches through the template paths.
	*
	*
	* @since	11.1
	*
	* @return	mixed	A string if successful, otherwise a JError object.
	*/
	protected function displayModal($tpl = null)
	{
		$this->menu = GolidaysHelper::addSubmenu('cpanel', 'modal', 'cpanel');
		$this->params = new JRegistry();

		// Define the title
		$this->_prepareDocument(JText::_('GOLIDAYS_LAYOUT_CONTROL_PANEL'));

		// Deprecated var : use $this->params->get('page_heading')
		$this->title = $this->params->get('page_heading');
		// Toolbar
		JToolBarHelper::title(JText::_('GOLIDAYS_LAYOUT_CONTROL_PANEL'), 'generic');


	}


}



