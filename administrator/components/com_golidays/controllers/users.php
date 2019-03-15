<?php
/**
* @version		
* @package		Golidays
* @subpackage	Users
* @copyright	
* @author		 Harvey - timthoi
* @license
*/

// no direct access
defined('_JEXEC') or die('Restricted access');



/**
* Golidays Users Controller
*
* @package	Golidays
* @subpackage	Users
*/
class GolidaysControllerUsers extends GolidaysClassControllerList
{
	/**
	* The context for storing internal data, e.g. record.
	*
	* @var string
	*/
	protected $context = 'users';

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
					'com_golidays.users.default'
				), array(
					'cid[]' => null
				));
				break;

			case 'default.unpublish':
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
					'stay'
				));
				break;
		}
	}

    public function ajaxGetUsers()
    {
        $result = array();

        $modelUsers = CkJModel::getInstance('Users', 'GolidaysModel');
        $userItems = $modelUsers->getItems();

        $result['rows'] = $userItems;

        $result['total'] = sizeof($result['rows']);

        echo json_encode($result);
        die();
    }
}



