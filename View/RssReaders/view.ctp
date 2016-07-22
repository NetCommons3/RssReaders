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

echo $this->NetCommonsHtml->css('/rss_readers/css/style.css');
?>

<article>
	<?php if (Current::permission('content_editable')) : ?>
		<header class="clearfix">
			<div class="pull-left">
				<?php echo $this->Workflow->label($rssReader['status']); ?>
			</div>

			<div class="pull-right">
				<?php echo $this->Button->editLink(); ?>
			</div>
		</header>
	<?php endif; ?>

	<?php if ($rssReader['url']) : ?>
		<div class="clearfix">
			<h1 class="pull-left rss-reader-rss-title">
				<?php if ($rssReader['link']) : ?>
					<a href="<?php echo h($rssReader['link']); ?>" target="_blank">
				<?php endif; ?>

				<?php echo h($rssReader['title']); ?>

				<?php if ($rssReader['link']) : ?>
					</a>
				<?php endif; ?>

				<a class="btn btn-info btn-xs rss-reader-rss-url workflow-label" href="<?php echo h($rssReader['url']); ?>" target="_blank">
					<?php echo __d('rss_readers', 'RDF/RSS'); ?>
				</a>
			</h1>
		</div>

		<?php if ($rssReader['summary']) : ?>
			<div class="well well-sm">
				<?php echo h($rssReader['summary']); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div class="nc-content-list">
		<?php echo $this->element('RssReaders/view_items'); ?>
	</div>
</article>

