<?php
/**
 * [HookComponent] preview_user
 *
 * @copyright		Copyright 2012, materializing.
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			preview_user.views
 * @license			MIT
 */
class PreviewUserHookComponent extends Object {
	var $registerHooks = array('beforeRender', 'beforeRedirect', 'shutdown');
/**
 * PreviewUser情報
 * 
 * @var Object
 * @access public
 */
	var $PreviewUserModel = null;
/**
 * constructer
 * 
 * @return void
 * @access private
 */
	function __construct() {
		parent::__construct();
		// PreviewUserヘルパーの追加
		$controller->helpers[] = 'PreviewUser.PreviewUser';
		$this->PreviewUserModel = ClassRegistry::init('PreviewUser.PreviewUser');
	}
/**
 * beforeRender
 * 
 * @param Object $controller 
 * @return void
 * @access public
 */
	function beforeRender(&$controller) {

		if($controller->name == 'Users') {
			// ユーザー情報編集画面で実行
			if($controller->action == 'admin_edit') {
				$conditions = array(
					'PreviewUser.user_id' => $controller->data['User']['id']
				);
				$data = $this->PreviewUserModel->find('first', array('conditions' => $conditions));
				if($data) {
					$controller->data['PreviewUser'] = $data['PreviewUser'];
				}
			}
		}

	}
/**
 * beforeRedirect
 * 
 * @param Object $controller 
 * @return void
 * @access public
 */
	function beforeRedirect(&$controller) {

		if($controller->name == 'Users') {

			if($controller->action == 'admin_add') {
				$controller->data['PreviewUser']['user_id'] = $controller->User->getLastInsertId();
			} else {
				$controller->data['PreviewUser']['user_id'] = $controller->User->id;
			}

			if($controller->action == 'admin_add' || $controller->action == 'admin_edit') {
				if(empty($controller->data['PreviewUser']['id'])) {
					$this->PreviewUserModel->create($controller->data['PreviewUser']);
				} else {
					$this->PreviewUserModel->set($controller->data['PreviewUser']);
				}
				if(!$this->PreviewUserModel->save()) {
					$this->log('プレビューユーザーの保存に失敗しました。user_id：' . $controller->data['PreviewUser']['user_id']);
				}
			}

		}

	}
/**
 * shutdown
 * 
 * @param Object $controller 
 * @return void
 * @access public
 */
	function shutdown($controller) {

		if($controller->name == 'BlogPosts' || $controller->name == 'Pages') {
			// ブログ記事編集、固定ページ編集画面で実行
			if($controller->action == 'admin_edit') {
				$user = $controller->BcAuth->user();
				$conditions = array(
					'PreviewUser.user_id' => $user['User']['id']
				);
				$data = $this->PreviewUserModel->find('first', array('conditions' => $conditions));
				if($data) {
					if($data['PreviewUser']['status']) {
						$controller->output = preg_replace('/id=\"btnSave\"/', 'id="btnSave" style="display:none;"', $controller->output);
						$controller->output = preg_replace('/class=\"btn-gray button\"/', 'class="btn-gray button" style="display:none;"', $controller->output);

						// ブログ記事編集画面
						$controller->output = preg_replace('/id=\"BtnAddBlogTag\"/', 'id="BtnAddBlogTag" style="display:none;"', $controller->output);
						$controller->output = preg_replace('/id=\"FormTable\"/', 'id="FormTable" style="display:none;"', $controller->output);

						// 固定ページ編集画面
						$controller->output = preg_replace('/class=\"form-table\"/', 'class="form-table" style="display:none;"', $controller->output);

						// プラグイン
						$controller->output = preg_replace('/id=\"TwitterUpdateBox\"/', 'id="TwitterUpdateBox" style="display:none;"', $controller->output);
					}
				}
			}
		}

	}

}
