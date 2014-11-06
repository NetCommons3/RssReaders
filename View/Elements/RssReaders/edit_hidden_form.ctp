<?php
echo $this->Form->input(
	'Block.id',
	array(
		'type' => 'hidden',
		'value' => h($blockId)
	)
);
echo $this->Form->input(
	'Block.room_id',
	array(
		'type' => 'hidden',
		'value' => h($roomId)
	)
);
echo $this->Form->input(
	'Block.language_id',
	array(
		'type' => 'hidden',
		'value' => h($languageId)
	)
);
echo $this->Form->input(
	'Frame.id',
	array(
		'type' => 'hidden',
		'value' => h($frameId)
	)
);
