<ul class="nav nav-tabs" role="tablist">
	<li class="small active">
		<a href="#nc-rss-readers-editor-<?php echo (int)$frameId; ?>"
				role="tab" data-toggle="tab">
			<?php echo __d('rss_readers', 'Edit RSS'); ?>
		</a>
	</li>
	<li class="small">
		<a href="#nc-rss-readers-display-style-<?php echo (int)$frameId; ?>"
				role="tab" data-toggle="tab">
			<?php echo __d('rss_readers', 'Change Indication Method'); ?>
		</a>
	</li>
	<li class="small disabled">
		<a href="#" onclick="return false;">
			<?php echo __d('rss_readers', 'Set Up Email'); ?>
		</a>
	</li>
</ul>

<br />

<div class="tab-content">
	<div class="tab-pane active" id="nc-rss-readers-editor-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('RssReaders/edit_rss_reader'); ?>
	</div>
	<div class="tab-pane" id="nc-rss-readers-display-style-<?php echo (int)$frameId; ?>">
		<?php echo $this->element('RssReaders/edit_rss_reader_frame_setting'); ?>
	</div>
</div>
