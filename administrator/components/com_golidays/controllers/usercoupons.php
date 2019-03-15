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

	function array2csv(array &$array)
	{
		if (count($array) == 0) {
			return null;
		}
		ob_start();
		$df = fopen("php://output", 'w');
		fputcsv($df, array_keys(reset($array)));
		foreach ($array as $row) {
			fputcsv($df, $row);
		}
		fclose($df);
		return ob_get_clean();
	}
	function download_send_headers($filename) {
		header("Content-Disposition: attachment;filename={$filename}");
		header("Content-Transfer-Encoding: binary");
	}
	//export cover note to excel
	public function export_excel(){

		$jinput = JFactory::getApplication()->input;

		$model = CkJModel::getInstance('usercoupons', 'GolidaysModel');
		$model->setState('context', 'usercoupons.default');
		$items = $model->getItems();
		$list =array ();

		foreach ($items as $data){

			//created by
			if ( $data->status == 1 ) $data->state = "Used";
			if ( $data->status == 0 ) $data->state = "Not Used";

			$data = json_decode (json_encode ($data), true);

			//var_dump($data);
			//re-order
			unset($data['id']);
			unset($data['creation_date']);
			unset($data['ordering']);
			unset($data['published']);
			unset($data['params']);
			unset($data['status']);
			unset($data['coupon_id']);
			unset($data['user_id']);

			$tmp = $data['state'];
			unset($data['state']);
			$data = self::array_unshift_assoc($data, 'STATUS', $tmp);

			$tmp = $data['token'];
			unset($data['token']);
			$data = self::array_unshift_assoc($data, 'TOKEN', $tmp);

			$tmp = $data['email'];
			unset($data['email']);
			$data = self::array_unshift_assoc($data, 'EMAIL', $tmp);

			$tmp = $data['phone'];
			unset($data['phone']);
			$data = self::array_unshift_assoc($data, 'PHONE', $tmp);

			$tmp = $data['username'];
			unset($data['username']);
			$data = self::array_unshift_assoc($data, 'USERNAME', $tmp);

			$tmp = $data['first_name'];
			unset($data['first_name']);
			$data = self::array_unshift_assoc($data, 'FIRST NAME', $tmp);

			$tmp = $data['last_name'];
			unset($data['last_name']);
			$data = self::array_unshift_assoc($data, 'LAST NAME', $tmp);

			$tmp = $data['modification_date'];
			unset($data['modification_date']);
			$data = self::array_unshift_assoc($data, 'USED DATE', $tmp);


			array_push($list,$data);
		}

		self::download_send_headers('cover.csv');

		echo self::array2csv($list);
		exit();

	}
	public function array_unshift_assoc(&$arr, $key, $val)
	{
		$arr = array_reverse($arr, true);
		$arr[$key] = $val;
		return array_reverse($arr, true);
	}
}



