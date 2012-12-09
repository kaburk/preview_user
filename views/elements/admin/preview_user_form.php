<?php
/**
 * [ADMIN] preview_user
 *
 * @copyright		Copyright 2012, materializing.
 * @link			http://www.materializing.net/
 * @author			arata
 * @package			preview_user.views
 * @license			MIT
 */
?>
<?php echo $bcForm->hidden('PreviewUser.id') ?>
<?php echo $bcForm->input('PreviewUser.status', array('type' => 'checkbox', 'label' => 'プレビューしかできないようにする')) ?>
<?php echo $bcForm->error('PreviewUser.status') ?>
