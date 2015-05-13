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
			<h2 class="clearfix">
				<a href="<?php echo h($item['link']); ?>" target="_blank">
					<?php echo h($item['title']); ?>
				</a>
				&nbsp;
				<div class="pull-right">
					<?php echo $this->Date->dateFormat($item['lastUpdated']); ?>
				</div>
			</h2>
			<div class="text-muted">
				<?php echo h($item['summary']); ?>
			</div>
		</article>
	<?php endforeach ?>
<?php endif;
