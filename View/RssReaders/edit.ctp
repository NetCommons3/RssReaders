<?php
/**
 * RssReaders edit template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script('/rss_readers/js/rss_readers.js');
?>

<article class="block-setting-body"
		ng-controller="RssReaders"
		ng-init="initialize(<?php echo h(json_encode(['frameId' => Current::read('Frame.id')])); ?>)">

	<div class="panel panel-default">
		<?php echo $this->NetCommonsForm->create('RssReader'); ?>
			<div class="panel-body has-feedback">
				<?php echo $this->element('RssReaders.RssReaders/edit_form'); ?>
				<hr />
				<?php echo $this->Workflow->inputComment('RssReader.status', false); ?>
			</div>

			<?php echo $this->Workflow->buttons('RssReader.status', NetCommonsUrl::backToPageUrl()); ?>
		<?php echo $this->NetCommonsForm->end(); ?>

		<?php if ($this->Workflow->canDelete('RssReaders.RssReader', $this->request->data) &&
						Hash::get($this->request->data, 'RssReader.id')) : ?>
			<div class="panel-footer text-right">
				<?php echo $this->element('RssReaders.RssReaders/delete_form', array(
					'url' => $this->NetCommonsHtml->url(array('action' => 'delete', 'key' => $this->data['RssReader']['key']))
				)); ?>
			</div>
		<?php endif; ?>
	</div>

	<?php echo $this->Workflow->comments(); ?>

</article>
