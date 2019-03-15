<?php
/**
* @version		
* @package		Golidays
* @subpackage	Users
* @copyright	
* @author		 Harvey - timthoi
*/

// no direct access
defined('_JEXEC') or die('Restricted access');



/**
* Golidays User Controller
*
* @package	Golidays
* @subpackage	User
*/
class GolidaysControllerUser extends GolidaysClassControllerItem
{
	/**
	* The context for storing internal data, e.g. record.
	*
	* @var string
	*/
	protected $context = 'user';

	/**
	* The URL view item variable.
	*
	* @var string
	*/
	protected $view_item = 'user';

	/**
	* The URL view list variable.
	*
	* @var string
	*/
	protected $view_list = 'users';

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
					'com_golidays.user.user'
				), array(
			
				));
				break;

			case 'modal.add':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.user.user'
				), array(
			
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.user.user'
				));
				break;
		}
	}

    /**
     * Method to choose user an element.
     *
     * @access	public
     *
     * @return	void
     */
    public function chooseuser($key = null, $urlVar = null)
    {
        $jinput = JFactory::getApplication()->input;
        $cid = $jinput->get('cid', array(), 'ARRAY');

        $model = $this->getModel();

        if (!empty($cid)) {
            $cid = $cid[0];

            //Define the redirections
            switch($this->getLayout() .'.'. $this->getTask())
            {

                default:
                    $this->applyRedirection($result, array(
                        'stay',
                        'com_golidays.prescription.prescription'
                    ), array(
                        'user_id' => $cid,
                        'cid[]' => null
                    ));

                    break;
            }
        }
        else {
            //Define the redirections
            switch($this->getLayout() .'.'. $this->getTask())
            {
                default:
                    $this->applyRedirection($result, array(
                        'stay',
                        'com_golidays.users.quicksearch'
                    ));
                    break;
            }
        }
    }

	/**
	* Override method when the author allowed to delete own.
	*
	* @access	protected
	* @param	array	$data	An array of input data.
	* @param	string	$key	The name of the key for the primary key; default is id..
	*
	* @return	boolean	True on success
	*/
	protected function allowDelete($data = array(), $key = id)
	{
		return parent::allowDelete($data, $key, array(
		'key_author' => 'created_by'
		));
	}

	/**
	* Override method when the author allowed to edit own.
	*
	* @access	protected
	* @param	array	$data	An array of input data.
	* @param	string	$key	The name of the key for the primary key; default is id..
	*
	* @return	boolean	True on success
	*/
	protected function allowEdit($data = array(), $key = id)
	{
		return parent::allowEdit($data, $key, array(
		'key_author' => 'created_by'
		));
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
			case 'user.cancel':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.users.default'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.users.default'
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
					'com_golidays.users.default'
				), array(
					'cid[]' => null
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.users.default'
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
					'com_golidays.user.user'
				), array(
			
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.user.user'
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
			return 'user';

		if ($default)
			return 'user';

		$jinput = JFactory::getApplication()->input;
		return $jinput->get('layout', 'user', 'CMD');
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
        $itemIdOld = (isset($item->id)) ? : 0;

        if ($model->canEdit($item, true))
        {
            $result = parent::save();
            //Get the model through postSaveHook()
            if ($this->model)
            {
                $model = $this->model;
                $item = $model->getItem();

                $jinput = JFactory::getApplication()->input;
                $data = $jinput->get('jform', '', 'array');

                $object     = new stdClass();
                $flagUpdate = false;

                if ($item->joomla_user_id) {
	                $flagUpdate = true;

	                $modelThirdUser = CkJModel::getInstance('thirduser', 'GolidaysModel');
	                $itemUser = $modelThirdUser->getItem($item->joomla_user_id);
	                $object->username =  $itemUser->username;
                }


                if ($flagUpdate) {
                    $object->id = $item->id;
                    $model->update($object);
                }
            }
        }
        else
            JError::raiseWarning( 403, JText::sprintf('ACL_UNAUTORIZED_TASK', JText::_('GOLIDAYS_JTOOLBAR_SAVE')) );

		$this->_result = $result;

		//Define the redirections
		switch($this->getLayout() .'.'. $this->getTask())
		{
			case 'user.save':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.users.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'user.apply':
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.user.user'
				), array(
					'cid[]' => $model->getState('user.id')
				));
				break;

			default:
				$this->applyRedirection($result, array(
					'stay',
					'com_golidays.users.default'
				));
				break;
		}
	}

    /**
     * Method to ajax Get User Information
     *
     * @access    public
     *
     * @return    json (ticket_price, ticket_total, discount)
     */
    public function ajaxGetUser()
    {
        JSession::checkToken() or JSession::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));

        $jinput = JFactory::getApplication()->input;
        $userId   = $jinput->get('user_id', '');

        if (empty($userId))
        {
            exit();
        }

        // user
        $modelUser = CkJModel::getInstance('User', 'GolidaysModel');
        $userItem = $modelUser->getItem($userId);

        if ($userItem) {
            $userItem->gender = ($userItem->gender) ? JText::_('GOLIDAYS_FIELD_GENDER_1') : JText::_('GOLIDAYS_FIELD_GENDER_0');

            if ($userItem->birthday) {
                $userItem->birthday = date('d/m/Y', strtotime($userItem->birthday));
            }

            foreach ($userItem as $index=>$item) {
                if (!$item) {
                    $userItem->$index = '-';
                }
            }

        }
        echo json_encode($userItem);

        exit();
    }
}



