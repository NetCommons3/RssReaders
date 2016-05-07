<?php
/**
 * ブロック一覧view
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<article class="block-setting-body">
	<?php echo $this->BlockTabs->main(BlockTabsHelper::MAIN_TAB_BLOCK_INDEX); ?>

	<?php echo $this->BlockIndex->description(); ?>

	<div class="tab-content">
		<?php echo $this->BlockIndex->create(); ?>
			<?php echo $this->BlockIndex->addLink(); ?>

			<?php echo $this->BlockIndex->startTable(); ?>
				<thead>
					<tr>
						<?php echo $this->BlockIndex->tableHeader(
								'Frame.block_id'
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'RssReader.title', __d('rss_readers', 'Site Title'),
								array('sort' => true)
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'TrackableCreator.handlename', __d('net_commons', 'Created user'),
								array('sort' => true, 'type' => 'handle')
							); ?>
						<?php echo $this->BlockIndex->tableHeader(
								'Block.modified', __d('net_commons', 'Modified datetime'),
								array('sort' => true, 'type' => 'datetime')
							); ?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($rssReaders as $rssReader) : ?>
						<?php echo $this->BlockIndex->startTableRow($rssReader['Block']['id']); ?>
							<?php echo $this->BlockIndex->tableData(
									'Frame.block_id', $rssReader['Block']['id']
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'RssReader.title', $rssReader['RssReader']['title'],
									array('editUrl' => array('block_id' => $rssReader['Block']['id']))
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'TrackableCreator', $rssReader,
									array('type' => 'handle')
								); ?>
							<?php echo $this->BlockIndex->tableData(
									'Block.modified', $rssReader['Block']['modified'],
									array('type' => 'datetime')
								); ?>
						<?php echo $this->BlockIndex->endTableRow(); ?>
					<?php endforeach; ?>
				</tbody>
			<?php echo $this->BlockIndex->endTable(); ?>

		<?php echo $this->BlockIndex->end(); ?>

		<?php echo $this->element('NetCommons.paginator'); ?>
	</div>
</article>
