<?php
/**
 *
 * New User PM Email Notification. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2021, Neverlands, https://online-werkstatt.at
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace neverlands\pmnotification\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * New User PM Email Notification Event listener.
 */
class main_listener implements EventSubscriberInterface
{
public static function getSubscribedEvents()
	{
		return [
			'core.user_add_after'			 => 'user_add_enable_pm_email_notifications'
		];
	}
	
	/* @var \phpbb\db\driver\factory */
	protected $db;
	
	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language $language  Language object
	 */
	public function __construct(\phpbb\db\driver\factory $db)
	{
		$this->db	  = $db;
	}

public function user_add_enable_pm_email_notifications($vars)
	{
		$user_id = $vars['user_id'];
		$sql = 'INSERT INTO ' . USER_NOTIFICATIONS_TABLE . "(item_type, item_id, user_id, method, notify)
				VALUES ('notification.type.pm', 0, " . (int) $user_id . ", 'notification.method.email', 1)";
		$this->db->sql_query($sql);
	}
}
