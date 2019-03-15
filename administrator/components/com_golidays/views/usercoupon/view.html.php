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
* @subpackage	Usercoupon
*/
class GolidaysViewUsercoupon extends GolidaysClassView
{
	/**
	* List of the reachables layouts. Fill this array in every view file.
	*
	* @var array
	*/
	protected $layouts = array('usercoupon');

	/**
	* Execute and display a template : Usercoupon
	*
	* @access	protected
	* @param	string	$tpl	The name of the template file to parse; automatically searches through the template paths.
	*
	*
	* @since	11.1
	*
	* @return	mixed	A string if successful, otherwise a JError object.
	*/
	protected function displayUsercoupon($tpl = null)
	{
		// Initialiase variables.
		$this->model	= $model	= $this->getModel();
		$this->state	= $state	= $this->get('State');
		$this->params 	= $state->get('params');
		$state->set('context', 'usercoupon.usercoupon');
		$this->item		= $item		= $this->get('Item');

		$this->form		= $form		= $this->get('Form');
		$this->canDo	= $canDo	= GolidaysHelper::getActions($model->getId());
		$lists = array();
		$this->lists = &$lists;

		// Define the title
		$this->_prepareDocument(JText::_('GOLIDAYS_LAYOUT_RESERVATION'), $this->item, 'departure_date');

		$user		= JFactory::getUser();
		$isNew		= ($model->getId() == 0);

		//Check ACL before opening the form (prevent from direct access)
		if (!$model->canEdit($item, true))
			$model->setError(JText::_('JERROR_ALERTNOAUTHOR'));

		// Check for errors.
		if (count($errors = $model->getErrors()))
		{
			JError::raiseError(500, implode(BR, array_unique($errors)));
			return false;
		}
		//Toolbar
		JToolBarHelper::title(JText::_('GOLIDAYS_LAYOUT_RESERVATION'), 'pencil-2');

		// Save & Close
		if (($isNew && $model->canCreate()) || (!$isNew && $item->params->get('access-edit')))
			JToolBarHelper::save('usercoupon.save', "GOLIDAYS_JTOOLBAR_SAVE_CLOSE");
		// Save
		if (($isNew && $model->canCreate()) || (!$isNew && $item->params->get('access-edit')))
			JToolBarHelper::apply('usercoupon.apply', "GOLIDAYS_JTOOLBAR_SAVE");
		// Cancel
		JToolBarHelper::cancel('usercoupon.cancel', "GOLIDAYS_JTOOLBAR_CANCEL");

		$modelCreatedBy = CkJModel::getInstance('users', 'GolidaysModel');
		$modelCreatedBy->set('context', $model->get('context'));
		$lists['fk']['user_id'] = $modelCreatedBy->getItems();

		$modelCoupons = CkJModel::getInstance('coupons', 'GolidaysModel');
		$modelCoupons->set('context', $model->get('context'));
		$lists['fk']['coupon_id'] = $modelCoupons->getItems();
	}


}



