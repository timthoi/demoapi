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
* Golidays Usercoupons Controller
*
* @package	Golidays
* @subpackage	Usercoupons
*/
class GolidaysControllerUsercoupons extends GolidaysClassControllerList
{
	/**
	* The context for storing internal data, e.g. record.
	*
	* @var string
	*/
	protected $context = 'usercoupons';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'usercoupon';

	/**
	* The URL view list variable.
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
		parent::__construct($config);
		$app = JFactory::getApplication();

	}

	/**
	* Return the current layout.
	*
	* @access	protected
	* @param	bool	$default	If true, return the default layout.
	*
	* @return	string	Requested layout or default layout
	*/
	protected function getLayout($default = null)
	{
		if ($default)
			return 'default';

		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', 'default', 'CMD');
	}

	/**
	* Method to publish an element.
	*
	* @access	public
	*
	* @return	void
	*/
	public function publish()
	{
		JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		$this->_result = $result = parent::publish();
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'default.publish':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.usercoupons.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'default.unpublish':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.usercoupons.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'modal.publish':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.usercoupons.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'modal.unpublish':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.usercoupons.default'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'stay'
				));
				break;
		}
	}

	public function getList()
	{
		JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));

		$jinput = JFactory::getApplication()->input;
		$userId = $jinput->get('user_id', null, null);

		$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.'/models');
		$model = $this->getModel('usercoupons');
		$model->setState('filter.user_id', 1);
		$items = $model->getItems();

		foreach ($items  as $index => $item) {
			$items[$index] = json_decode (json_encode ($item), true);
		}

		$result['rows'] = $items;
		$result['total'] = sizeof($result['rows']);

		echo json_encode($result);
		die();
	}

	public function ajaxApply()
	{
		JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));

		$jinput = JFactory::getApplication()->input;
		$usercoupon_id = $jinput->get('usercoupon_id', null, null);

		$this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.'/models');
		$model = $this->getModel('usercoupon');

		$object     = new stdClass();
		$object->id     = $usercoupon_id;
		$object->status     = 1;
		$item = $model->update($object);

		echo json_encode($item);
		die();
	}
}



