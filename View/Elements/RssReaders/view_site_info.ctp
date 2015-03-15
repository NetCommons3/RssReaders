<?php
/**
 * view site information element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-8">
				<button class="btn btn-default btn-xs" ng-class="{active:siteInfo}" ng-click="siteInfo = !siteInfo; switchDisplaySiteInfo();">
					<span class="glyphicon glyphicon-info-sign nc-tooltip" tooltip="<?php echo __d('rss_readers', 'Site Info'); ?>"> </span>
				</button >

				<?php echo __d('rss_readers', 'Site Info'); ?>
			</div>

			<div class="col-xs-4 text-right">
				<?php echo $this->element('NetCommons.status_label',
						array('status' => $rssReader['status'])); ?>
			</div>
		</div>
	</div>

	<div class="panel-body rss-site-info hidden">
		<div class="form-group">
			<?php if ($rssReader['link']) : ?>
				<a href="<?php echo h($rssReader['link']); ?>" target="_blank">
			<?php endif; ?>

			<?php echo h($rssReader['title']); ?>

			<?php if ($rssReader['link']) : ?>
				</a>
			<?php endif; ?>
			&nbsp;
			<a class="btn btn-default btn-xs" href="<?php echo h($rssReader['url']); ?>" target="_blank">
				<?php echo __d('rss_readers', 'RDF/RSS'); ?>
			</a>
		</div>

		<?php if ($rssReader['summary']) : ?>
			<div class="form-group">
				<?php echo h($rssReader['summary']); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
