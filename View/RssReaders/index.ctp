<?php
echo $this->Html->script('/rss_readers/js/rss_readers.js');
echo $this->Html->css('/rss_readers/css/rss_readers.css');
?>

<div id="nc-rss-readers-container-<?php echo (int)$frameId; ?>"
	ng-controller="RssReaders"
	ng-init="initialize(
		<?php echo h(json_encode($rssReaderData)); ?>,
		<?php echo (int)$frameId; ?>
	)">

	<div ng-show="visibleHeaderBtn">
		<?php echo $this->element('RssReaders/header_button'); ?>
	</div>

	<div id="nc-rss-readers-container-<?php echo (int)$frameId; ?>"
		 ng-show="visibleContainer">
		<div>
			<?php echo $this->element('RssReaders/view'); ?>
		</div>
	</div>
</div>
