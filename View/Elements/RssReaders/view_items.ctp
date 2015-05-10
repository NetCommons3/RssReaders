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
		<div class="form-group">
			<div class="row">
				<div class="col-xs-12 col-md-10">
					<a href="<?php echo h($item['link']); ?>" target="_blank">
						<?php echo h($item['title']); ?>
					</a>
				</div>
				<div class="col-xs-12 col-md-2 text-right">
					<?php echo $this->Date->dateFormat($item['lastUpdated']); ?>
				</div>

				<div class="col-xs-12 text-muted">
					<small>
						<?php echo h($item['summary']); ?>
					</small>
				</div>
			</div>
		</div>
	<?php endforeach ?>
<?php endif;
