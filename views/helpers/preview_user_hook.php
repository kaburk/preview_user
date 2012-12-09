<?php
/**
 * [HookHelper] preview_user
 *
 * @copyright		Copyright 2012, materializing.
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			preview_user.views
 * @license			MIT
 */
class PreviewUserHookHelper extends AppHelper {
/**
 * 登録フック
 *
 * @var array
 * @access public
 */
	var $registerHooks = array('afterFormInput');
/**
 * ビュー
 * 
 * @var View 
 */
	var $View = null;
/**
 * Construct 
 * 
 */
	function __construct() {
		parent::__construct();
		$this->View = ClassRegistry::getObject('view');
	}
/**
 * afterFormInput
 * 
 * @param string $form
 * @param string $fieldName
 * @param string $out
 * @return string 
 */
	function afterFormInput(&$form, $fieldName, $out) {

		// ユーザー編集画面にプレビューしかできない指定ができるチェックボックスを追加する
		if($form->params['controller'] == 'users'){
			if($this->action == 'admin_edit' || $this->action == 'admin_add'){
				if($fieldName == 'User.name') {
					$out = $out . $this->View->element('admin/preview_user_form', array('plugin' => 'preview_user'));
				}
			}
		}
		return $out;

	}

}
