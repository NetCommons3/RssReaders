<?php
if ($rssReaderFrameData['RssReaderFrameSetting']['display_site_info']) {
	echo $this->element('RssReaders/view_site_info');
}
?>
<div>
	<?php echo $this->element('RssReaders/view_item'); ?>
</div>
