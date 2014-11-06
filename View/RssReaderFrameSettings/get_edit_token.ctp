<?php
echo $this->Form->create(null);

echo $this->Form->input(
	'RssReaderFrameSetting.display_number_per_page',
	array(
		'type' => 'text',
		'value' => ''
	)
);
echo $this->Form->input(
	'RssReaderFrameSetting.display_site_info',
	array(
		'type' => 'text',
		'value' => ''
	)
);
echo $this->Form->input(
	'RssReaderFrameSetting.display_summary',
	array(
		'type' => 'text',
		'value' => ''
	)
);
echo $this->Form->input(
	'RssReaderFrameSetting.id',
	array(
		'type' => 'hidden',
		'value' => $rssReaderFrameData['RssReaderFrameSetting']['id']
	)
);
echo $this->Form->input(
	'RssReaderFrameSetting.frame_key',
	array(
		'type' => 'hidden',
		'value' => $rssReaderFrameData['RssReaderFrameSetting']['frame_key']
	)
);

echo $this->Form->end();
