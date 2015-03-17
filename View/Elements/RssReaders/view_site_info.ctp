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

<?php if (isset($rssReader['link'])) : ?>
	<div class="form-group">
		<button class="btn btn-default" ng-class="{active:siteInfo}" ng-click="siteInfo = !siteInfo; switchDisplaySiteInfo();">
			<span class="glyphicon glyphicon-info-sign nc-tooltip" tooltip="<?php echo __d('rss_readers', 'Site Info'); ?>"> </span>
		</button >

		<?php echo $this->element('NetCommons.status_label',
				array('status' => $rssReader['status'])); ?>
	</div>

	<div class="panel panel-default rss-site-info hidden">
		<div class="panel-body">
			<div class="form-group">
				<?php if ($rssReader['link']) : ?>
					<a href="<?php echo h($rssReader['link']); ?>" target="_blank">
				<?php endif; ?>

				<?php echo h($rssReader['title']); ?>

				<?php if ($rssReader['link']) : ?>
					</a>
				<?php endif; ?>
				&nbsp;
				<a class="btn btn-warning btn-xs" href="<?php echo h($rssReader['url']); ?>" target="_blank">
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
<?php endif;
