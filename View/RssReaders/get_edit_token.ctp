<?php
echo $this->Form->create(null);

echo $this->Form->input(
	'RssReader.url',
	array(
		'type' => 'text',
		'value' => ''
	)
);
echo $this->Form->input(
	'RssReader.title',
	array(
		'type' => 'text',
		'value' => ''
	)
);
echo $this->Form->input(
	'RssReader.summary',
	array(
		'type' => 'text',
		'value' => ''
	)
);
echo $this->Form->input(
	'RssReader.link',
	array(
		'type' => 'text',
		'value' => ''
	)
);
echo $this->Form->input(
	'RssReader.cache_time',
	array(
		'type' => 'text',
		'value' => ''
	)
);
echo $this->Form->input(
	'RssReader.id',
	array(
		'type' => 'hidden',
		'value' => $rssReaderData['RssReader']['id']
	)
);
echo $this->element('RssReaders/edit_hidden_form');

if ($contentPublishable) {
	$options = array(
		NetCommonsBlockComponent::STATUS_PUBLISHED,
		NetCommonsBlockComponent::STATUS_DRAFTED,
		NetCommonsBlockComponent::STATUS_DISAPPROVED,
	);
} else {
	$options = array(
		NetCommonsBlockComponent::STATUS_APPROVED,
		NetCommonsBlockComponent::STATUS_DRAFTED,
	);
}

echo $this->Form->input(
	'RssReader.status',
	array(
		'type' => 'select',
		'options' => array_combine($options, $options)
	)
);

echo $this->Form->end();
