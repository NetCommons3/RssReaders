<?php echo $this->Html->script('/rss_readers/js/rss_readers.js'); ?>

<div id="nc-rss-readers-container-<?php echo h($frameId); ?>"
	ng-controller="RssReaders"
	ng-init="initialize(
		<?php echo h(json_encode($rssReaderData)); ?>,
		<?php echo h(json_encode($rssReaderFrameSettingData)); ?>,
		<?php echo h($frameId); ?>
	)">

	<div>
		<?php echo $this->element('RssReaders/header_button'); ?>
	</div>

	<?php if (!empty($rssReaderData)): ?>
	<div id="nc-rss-readers-body-<?php echo h($frameId); ?>">
		<div>
			<?php
			if ($rssReaderFrameSettingData['RssReaderFrameSetting']['display_site_info']) {
				echo $this->element('RssReaders/view_site_info');
			}
			?>
			<?php if (!empty($rssXmlData)): ?>
			<div class="panel panel-default" id ="nc-rss-readers-item-<?php echo h($frameId); ?>">
				<?php
				$pageLimit = $rssReaderFrameSettingData['RssReaderFrameSetting']['display_number_per_page'];
				$displaySummary = $rssReaderFrameSettingData['RssReaderFrameSetting']['display_summary'];
				$this->RssReader->showItem($rssXmlData, $pageLimit, $displaySummary);
				?>
			</div>
			<?php endif; ?>
	</div>
	<?php endif; ?>
</div>
