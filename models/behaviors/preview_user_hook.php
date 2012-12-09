<?php
/**
 * [HookBehavior] preview_user
 *
 * @copyright		Copyright 2012, materializing.
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			preview_user.models
 * @license			MIT
 */
class PreviewUserHookBehavior extends ModelBehavior {
/**
 * 登録フック
 *
 * @var array
 * @access public
 */
	var $registerHooks = array(
			'User'	=> array('afterDelete')
	);
/**
 * afterDelete
 * 
 * @param Object $model
 * @return void
 * @access public
 */
	function afterDelete(&$model) {

		// ユーザー削除時、そのユーザーが持つプレビュー情報を削除する
		if($model->alias == 'User') {
			$PreviewUserModel = ClassRegistry::init('PreviewUser.PreviewUser');
			$data = $PreviewUserModel->find('first', array('conditions' => array('PreviewUser.user_id' => $model->id)));
			if($data) {
				if(!$PreviewUserModel->delete($data['PreviewUser']['id'])) {
					$this->log('ID:' . $data['PreviewUser']['id'] . 'のプレビューユーザーの削除に失敗しました。');
				}
			}
		}

	}

}
