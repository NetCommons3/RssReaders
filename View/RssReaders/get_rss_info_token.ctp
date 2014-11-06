<?php
echo $this->Form->create(null);

echo $this->Form->input(
	'RssReader.url',
	array(
		'type' => 'text',
		'value' => ''
	)
);

echo $this->Form->end();
