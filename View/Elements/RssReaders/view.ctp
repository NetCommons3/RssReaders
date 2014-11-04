<?php
if ($rssReaderFrameSettingData['RssReaderFrameSetting']['display_site_info']) {
	echo $this->element('RssReaders/view_site_info');
}

if (!empty($rssXmlData)) {
	echo $this->element('RssReaders/view_item');
}
