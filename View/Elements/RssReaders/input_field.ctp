<?php
/**
 * input field element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$underscoreField = Inflector::underscore($field);
$modelVariable = Inflector::variable($model);
if (! isset($attributes)) {
	$attributes = array();
}
$colSize = isset($colSize) ? $colSize : 'col-xs-12';
?>

<div class="row form-group">
	<div class="<?php echo $colSize; ?>">
		<?php echo $this->Form->input(
				$model . '.' . $underscoreField,
				Hash::merge(
					array(
						'type' => 'text',
						'label' => $label,
						'error' => false,
						'class' => 'form-control',
						'value' => (isset(${$modelVariable}[$field]) ? ${$modelVariable}[$field] : '')
					),
					$attributes
				)
			); ?>
	</div>

	<div class="col-xs-12">
		<?php echo $this->element(
			'RssReaders.errors', [
				'errors' => $this->validationErrors,
				'model' => 'RssReader',
				'field' => $underscoreField,
			]); ?>
	</div>
</div>