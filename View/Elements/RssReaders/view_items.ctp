<?php
/**
 * view rss items element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$i = 0;
?>

<?php if ($rssReaderItems) : ?>
	<?php foreach ($rssReaderItems as $item): ?>
		<div class="form-group">
			<div class="row">
				<?php $summaryKey = 'rssSummary' . $item['id']; ?>

				<div class="col-xs-12 col-md-10">
					<a href="<?php echo h($item['link']); ?>"
					   ng-click="<?php echo $summaryKey . ' = ! ' . $summaryKey . '; switchDisplaySummary(\'#' . $summaryKey . '\')'; ?>;"
					   onclick="return false;">

						<span class="glyphicon glyphicon-menu-right" ng-class="{'glyphicon-menu-down':<?php echo $summaryKey; ?>}"> </span>
						<?php echo h($item['title']); ?>
					</a>
				</div>
				<div class="col-xs-12 col-md-2 text-right">
					<?php echo $this->Date->dateFormat($item['lastUpdated']); ?>
				</div>

				<div class="col-xs-12 text-muted hidden" id="<?php echo $summaryKey ?>">
					<small>
						<em><?php echo h($item['summary']); ?></em>

						<a href="<?php echo h($item['link']); ?>" target="_blank"
						   class="btn btn-info btn-xs glyphicon glyphicon-new-window">
						</a>
					</small>
				</div>
			</div>
		</div>

		<?php $i++; ?>
	<?php endforeach ?>
<?php endif;