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
?>

<?php if ($rssReaderItems) : ?>
	<?php foreach ($rssReaderItems as $item): ?>
		<article>
			<h3 class="clearfix">
				<a href="<?php echo h($item['RssReaderItem']['link']); ?>" target="_blank">
					<?php echo h($item['RssReaderItem']['title']); ?>
				</a>
				<div class="pull-right">
					<?php echo $this->Date->dateFormat($item['RssReaderItem']['last_updated']); ?>
				</div>
			</h3>
			<div class="text-muted rss-reader-summary">
				<?php echo h($item['RssReaderItem']['summary']); ?>
			</div>
		</article>
	<?php endforeach; ?>
<?php else : ?>
		<article>
			<?php echo __d('rss_readers', 'Feed Not Found.'); ?>
		</article>
<?php endif;
