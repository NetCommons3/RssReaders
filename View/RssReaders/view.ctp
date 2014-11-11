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
			if (!empty($rssXmlData)) {
				echo $this->element('RssReaders/view_item');
			}
			?>
		</div>
	</div>
	<?php endif; ?>
</div>
