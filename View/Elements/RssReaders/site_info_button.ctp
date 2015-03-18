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
	<button class="btn btn-default" ng-class="{active:siteInfo}" ng-click="siteInfo = !siteInfo; switchDisplaySiteInfo();">
		<span class="glyphicon glyphicon-info-sign nc-tooltip" tooltip="<?php echo __d('rss_readers', 'Site Info'); ?>"> </span>
	</button >

	<?php echo $this->element('NetCommons.status_label',
			array('status' => $rssReader['status'])); ?>
<?php endif;
