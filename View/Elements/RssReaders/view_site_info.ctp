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
	<div class="rss-site-info hidden">
		<h1>
			<small>
				<?php if ($rssReader['link']) : ?>
					<a href="<?php echo h($rssReader['link']); ?>" target="_blank">
				<?php endif; ?>

				<?php echo h($rssReader['title']); ?>

				<?php if ($rssReader['link']) : ?>
					</a>
				<?php endif; ?>

				<a class="btn btn-warning btn-xs" href="<?php echo h($rssReader['url']); ?>" target="_blank">
					<?php echo __d('rss_readers', 'RDF/RSS'); ?>
				</a>
			</small>
		</h1>

		<div>
			<?php if ($rssReader['summary']) : ?>
				<?php echo h($rssReader['summary']); ?>
			<?php endif; ?>
		</div>

		<hr>
	</div>
<?php endif;
