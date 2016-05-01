<?php
/**
 * RssReaders view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article>
	<div class="clearfix">
		<?php if (isset($rssReader['link'])) : ?>
			<div class="pull-left">
				<a class="btn btn-default" href="#site-info<?php echo Current::read('Frame.id'); ?>"
						aria-controls="site-info<?php echo Current::read('Frame.id'); ?>"
						tooltip="<?php echo __d('rss_readers', 'Site Info'); ?>"
						data-toggle="collapse" aria-expanded="false">

					<span class="glyphicon glyphicon-info-sign"> </span>
				</a>

				<?php echo $this->Workflow->label($rssReader['status']); ?>

				<?php echo $this->element('RssReaders/view_site_info'); ?>
			</div>
		<?php endif; ?>

		<?php if (Current::permission('content_editable')) : ?>
			<div class="pull-right">
				<?php echo $this->Button->editLink(); ?>
			</div>
		<?php endif; ?>
	</div>

	<?php echo $this->element('RssReaders/view_items'); ?>
</article>

