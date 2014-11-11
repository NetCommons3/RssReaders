<?php
echo $this->Form->create(null);

echo $this->Form->input(
	'RssReader.id',
	array(
		'type' => 'text',
		'value' => ''
	)
);
echo $this->Form->input(
	'RssReader.status',
	array(
		'type' => 'text',
		'value' => ''
	)
);

echo $this->Form->end();
