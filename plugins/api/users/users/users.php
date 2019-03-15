<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_trading
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.user.user');
jimport('joomla.plugin.plugin');
jimport('joomla.user.helper');
jimport('joomla.application.component.helper');
jimport('joomla.application.component.model');
jimport('joomla.database.table.user');

// Load com_users language file
$language = JFactory::getLanguage();
$language->load('com_users');
$language->load('com_users', JPATH_SITE, 'en-GB', true);
$language->load('com_users', JPATH_ADMINISTRATOR, 'en-GB', true);

require_once JPATH_ROOT . '/administrator/components/com_users/models/users.php';

require_once JPATH_SITE . '/components/com_api/libraries/authentication.php';
require_once JPATH_SITE . '/components/com_api/libraries/authentication/user.php';
require_once JPATH_SITE . '/components/com_api/libraries/authentication/login.php';

require_once JPATH_ADMINISTRATOR . '/components/com_api/models/key.php';
require_once JPATH_ADMINISTRATOR . '/components/com_api/models/keys.php';

JLoader::register('APIAuthenticationKey', JPATH_SITE . '/components/com_api/libraries/authentication/key.php');

/**
 * User Api.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_api
 *
 * @since       1.0
 */
class UsersApiResourceUsers extends ApiResource
{

	/**
		* Function for edit user record.
		*
		* @return void
		*/
	public function put()
	{
		$app              = JFactory::getApplication();
		$db 			  = JFactory::getDbo();
		$data             = array();
		$obj             = new stdClass;
		$obj->status     = false;
		$obj->id         = 0;

		// Get values paased by put in the url
		$data = $app->input->getArray(array());

		parse_str(file_get_contents("php://input"), $data);

		foreach ($data as $key => $value) {
			$item[$key] = $value;
		}

		if (!isset($item['token'])) {
			$result       = new \stdClass;
			$result->msg  = 'Missing param token';
			$result->code = '1010';

			$this->plugin->setResponse($result);
			return ;
		}

		if (!isset($item['coupon'])) {
			$result       = new \stdClass;
			$result->msg  = 'Missing param coupon';
			$result->code = '1011';

			$this->plugin->setResponse($result);
			return ;
		}

		$_GET['key'] = $item['token'];

		$params = JFactory::getConfig();
		$params->set('domain_checking', 0);
		$modelKey = new ApiAuthenticationKey($params);
		$userId = $modelKey->authenticate();

		if (!$userId) {
			ApiError::raiseError(11001, "Not authorised", 'APIUnauthorisedException');
			return ;
		}

		$couponToken = $item['coupon'];

		$db = JFactory::getDbo();

		$sql = 'SELECT a.id 
		FROM #__demo_user_coupon as a
		INNER JOIN  #__demo_coupons as b
			ON b.id = a.coupon_id
		INNER JOIN  #__demo_users as c
			ON c.id = a.user_id
		WHERE c.joomla_user_id = ' . $userId . ' AND a.published=1 AND b.expired_date >= CURDATE() AND a.status = 0 ' . ' AND b.token = "' . $couponToken . '"';

		$db->setQuery($sql);

		$userCoupon = $db->loadResult();

		// Update
		if ($userCoupon) {
			$object = new \stdClass;
			$object->id = $userCoupon;
			$object->status = 1;
			$resultUpdate = JFactory::getDbo()->updateObject('#__demo_user_coupon', $object, 'id');

			if ($resultUpdate) {
				$result       = new \stdClass;
				$result->msg  = 'used successful';
				$result->code = '200';

				$this->plugin->setResponse($result);
				return ;
			}
		}

		$result       = new \stdClass;
		$result->msg  = 'Coupon is wrong or expired or you do not have coupon';
		$result->code = '1009';

		$this->plugin->setResponse($result);
		return ;
	}
}
