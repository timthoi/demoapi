<?php
/**
 * @package API plugins
 * @copyright Copyright (C) 2009 2014 Techjoomla, Tekdi Technologies Pvt. Ltd. All rights reserved.
 * @license GNU GPLv2 <http://www.gnu.org/licenses/old-licenses/gpl-2.0.html>
 * @link http://www.techjoomla.com
 */

defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.plugin.plugin');
jimport('joomla.html.html');
jimport('joomla.application.component.controller');
jimport('joomla.application.component.model');
jimport('joomla.user.helper');
jimport('joomla.user.user');
jimport('joomla.application.component.helper');

JModelLegacy::addIncludePath(JPATH_SITE . 'components/com_api/models');
require_once JPATH_SITE . '/components/com_api/libraries/authentication.php';
require_once JPATH_SITE . '/components/com_api/libraries/authentication/user.php';
require_once JPATH_SITE . '/components/com_api/libraries/authentication/login.php';

require_once JPATH_ADMINISTRATOR . '/components/com_api/models/key.php';
require_once JPATH_ADMINISTRATOR . '/components/com_api/models/keys.php';

JLoader::register('APIAuthenticationKey', JPATH_SITE . '/components/com_api/libraries/authentication/key.php');

class UsersApiResourceLogin extends ApiResource
{
	public function put()
	{
		$app              = JFactory::getApplication();
		$db 			  = JFactory::getDbo();
		$data             = array();
		$obj             = new stdClass;

		// Get values paased by put in the url
		$data = $app->input->getArray(array());


		var_dump($data);
		die;

		// Check username or user_id to edit the details of user
		if (isset($data['username']) || isset($data['user_id']))
		{
			if (!$data['user_id'] && isset($data['username']))
			{
				// Get user_id with the help of username
				$query = $db->getQuery(true);
				$query->select('id');
				$query->from('#__users');
				$query->where($db->quoteName('username') . '=' . $db->quote($data['username']));
				$db->setQuery($query);
				$user_id = $db->loadResult();
				$data['user_id'] = $user_id;
			}

			// Given username or user_id not exist
			if (!$data['user_id'])
			{
				$eobj->code = '400';
				$eobj->message = JText::_('COM_USERS_USER_NOT_FOUND');
				$this->plugin->setResponse($eobj);

				return;
			}

			$user = JFactory::getUser($data['user_id']);

			// Bind the data.
			if (!$user->bind($data))
			{
				// User deatils are not updated
				$message = $user->getError();
				$eobj->code = '400';
				$eobj->message = $message;
				$this->plugin->setResponse($eobj);

				return;
			}

			// Save the user data
			if (!$user->save())
			{
				// User deatils are not updated
				$message = $user->getError();
				$eobj->code = '400';
				$eobj->message = $message;
				$this->plugin->setResponse($eobj);

				return;
			}
			else
			{
				// Updated records updated successsfully
				$eobj->status     = true;
				$eobj->id         = $data['user_id'];
				$eobj->code       = '200';
				$eobj->message    = JText::_('PLG_API_USERS_ACCOUNT_EDITED_SUCCESSFULLY_MESSAGE');
				$this->plugin->setResponse($eobj);

				return;
			}
		}
		else
		{
			// Not given username or user_id to edit the details of user
			$eobj->code = '400';
			$eobj->message = JText::_('PLG_API_USERS_REQUIRED_DATA_EMPTY_MESSAGE');
			$this->plugin->setResponse($eobj);

			return;
		}
	}

	public function get()
	{
		$params = JFactory::getConfig();
		$params->set('domain_checking', 0);
		$modelKey = new ApiAuthenticationKey($params);
		$userId = $modelKey->authenticate();

		if (!$userId) {
			ApiError::raiseError(11001, "Not authorised", 'APIUnauthorisedException');
			return ;
		}

		$jinput = JFactory::getApplication()->input;
		$couponToken = $jinput->get('coupon');

		$db = JFactory::getDbo();

		$sql = 'SELECT a.id 
		FROM #__demo_user_coupon as a
		INNER JOIN  #__demo_coupons as b
			ON b.id = a.coupon_id
		INNER JOIN  #__demo_users as c
			ON c.id = a.user_id
		WHERE c.joomla_user_id = ' . $userId . ' AND a.published=1 AND b.expired_date >= CURDATE() AND a.status = 0';

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
		$result->msg  = 'Coupon is wrong';
		$result->code = '1009';

		$this->plugin->setResponse($result);
		return ;
	}

	public function post()
	{
		$this->plugin->setResponse($this->keygen());
	}

	public function keygen()
	{
		//init variable
		$obj = new stdclass;
		$umodel = new JUser;
		$user = $umodel->getInstance();
		$app = JFactory::getApplication();

		$username = $app->input->get('username', 0, 'STRING');
		$user = JFactory::getUser();

		$id = JUserHelper::getUserId($username);
		

		$key = null;
		$kmodel = new ApiModelKey;

		$db = JFactory::getDbo();

		$sql = 'SELECT a.hash 
		FROM #__api_keys as a
		WHERE a.userid = ' . $id . ' AND a.state = 1';

		$db->setQuery($sql);
		$log_hash = $db->loadResult();


		if( !empty($log_hash) )
		{
			$key = $log_hash;
		}
		elseif( $key == null || empty($key) )
		{

			// Create new key for user
			$data = array(
				'userid' => $user->id,
				'domain' => '' ,
				'state' => 1,
				'id' => '',
				'task' => 'save',
				'c' => 'key',
				'ret' => 'index.php?option=com_api&view=keys',
				'option' => 'com_api',
				JSession::getFormToken() => 1
			);
			$result = $kmodel->save($data);

			$key = $result->hash;
		}

		if( !empty($key) )
		{
			$obj->auth = $key;
			$obj->code = '200';
			$obj->id = $id;
		}
		else
		{
			$obj->code = 403;
			$obj->message = JText::_('PLG_API_USERS_BAD_REQUEST_MESSAGE');
		}
		return( $obj );
	}


}
