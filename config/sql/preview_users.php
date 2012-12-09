<?php 
/* SVN FILE: $Id$ */
/* PreviewUsers schema generated on: 2012-12-09 15:12:27 : 1355033307*/
class PreviewUsersSchema extends CakeSchema {
	var $name = 'PreviewUsers';

	var $file = 'preview_users.php';

	var $connection = 'plugin';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $preview_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 8),
		'status' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 2),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>