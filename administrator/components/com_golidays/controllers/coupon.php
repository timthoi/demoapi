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
* Golidays coupon Controller
*
* @package	Golidays
* @subpackage	coupon
*/
class GolidaysControllerCoupon extends GolidaysClassControllerItem
{
	/**
	* The context for storing internal data, e.g. record.
	*
	* @var string
	*/
	protected $context = 'coupon';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'coupon';

	/**
	* The URL view list variable.
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
		parent::__construct($config);
		$app = JFactory::getApplication();

	}

	/**
	* Method to add an element.
	*
	* @access	public
	*
	* @return	void
	*/
	public function add()
	{
		JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		$this->_result = $result = parent::add();
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'default.add':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				), array(
			
				));
				break;

			case 'modal.add':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				), array(
			
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				));
				break;
		}
	}

	public function applyCoupon()
	{
		JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		$model = $this->getModel();
		$item = $model->getItem();

		$data = JRequest::getVar('jform');

		$modelUsers = CkJModel::getInstance('users', 'GolidaysModel');
		$modelUsers->set('context', $model->get('context'));
		$users = $modelUsers->getItems();

		$modelUserCoupon = CkJModel::getInstance('usercoupon', 'GolidaysModel');

		$db = JFactory::getDbo();
		foreach ($users as $user) {
			$query = $db->getQuery(true)
				->select('*')
				->from($db->qn('#__demo_user_coupon', 'a'))
				->where($db->qn('a.coupon_id') . " = " . $item->id . " AND a.user_id = " . $user->id);

			$result = $db->setQuery($query)->loadAssocList();

			if (empty($result)) {
				$object = new stdClass();
				$object->coupon_id =  $item->id;
				$object->user_id =  $user->id;
				$object->status =  0;
				$object->creation_date = date("Y-m-d H:i:s");

				for ($i=0;$i<$item->quantity;$i++) {
					$modelUserCoupon->insert($object);
				}
			}
		}

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'default.add':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				), array(

				));
				break;

			case 'modal.add':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				), array(

				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				));
				break;
		}
	}

	/**
	* Method to cancel an element.
	*
	* @access	public
	* @param	string	$key	The name of the primary key of the URL variable.
	*
	* @return	void
	*/
	public function cancel($key = null)
	{
		$this->_result = $result = parent::cancel();
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'coupon.cancel':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupons.default'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupons.default'
				));
				break;
		}
	}

	/**
	* Method to delete an element.
	*
	* @access	public
	*
	* @return	void
	*/
	public function delete()
	{
		JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		$this->_result = $result = parent::delete();
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'default.delete':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupons.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'modal.delete':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupons.default'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupons.default'
				));
				break;
		}
	}

	/**
	* Method to edit an element.
	*
	* @access	public
	* @param	string	$key	The name of the primary key of the URL variable.
	* @param	string	$urlVar	The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	*
	* @return	void
	*/
	public function edit($key = null, $urlVar = null)
	{
		JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		$this->_result = $result = parent::edit();
		$model = $this->getModel();

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'default.edit':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				), array(
			
				));
				break;

			case 'modal.edit':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				), array(
			
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				));
				break;
		}
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
		if ($default === 'edit')
			return 'coupon';

		if ($default)
			return 'coupon';

		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', 'coupon', 'CMD');
	}

	/**
	* Method to save an element.
	*
	* @access	public
	* @param	string	$key	The name of the primary key of the URL variable.
	* @param	string	$urlVar	The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	*
	* @return	void
	*/
	public function save($key = null, $urlVar = null)
	{
		JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
		//Check the ACLs
		$model = $this->getModel();
		$item = $model->getItem();
		$result = false;
		if ($model->canEdit($item, true))
		{
			$result = parent::save();
			//Get the model through postSaveHook()
			if ($this->model)
			{
				$model = $this->model;
				$item = $model->getItem();	
			}
		}
		else
			JError::raiseWarning( 403, JText::sprintf('ACL_UNAUTORIZED_TASK', JText::_('GOLIDAYS_JTOOLBAR_SAVE')) );

		$this->_result = $result;

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'coupon.save':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupons.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'coupon.apply':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				), array(
					'cid[]' => $model->getState('coupon.id')
				));
				break;

			case 'coupon.save2copy':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				), array(
					'cid[]' => $model->getState('coupon.id')
				));
				break;

			case 'coupon.save2new':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupon.coupon'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.coupons.default'
				));
				break;
		}
	}


}



