<div class="panel panel-default">
	<?php
	$pageLimit = $rssReaderFrameData['RssReaderFrameSetting']['display_number_per_page'];
	foreach ($rssXmlData['RDF']['item'] as $key => $itemData):
	?>
	<?php
	if ($key >= $pageLimit) {
		break;
	}
	?>
	<div class="list-group item-list">
		<div class="panel-body">
			<a href="<?php echo h($itemData['link']); ?>" target="_blank" class="item">
				<div class="list-group-item-heading">
					<h4><?php echo h($itemData['title']); ?></h4>
					<span class="text-info small">
						(
						<?php
						$date = new DateTime($itemData['dc:date']);
						echo h($date->format('Y/m/d h:i'));
						?>
						)
					</span>
				</div>
				<?php if ($rssReaderFrameData['RssReaderFrameSetting']['display_summary']): ?>
				<p class="list-group-item-text small">
					<?php echo h($itemData['description']); ?>
				</p>
				<?php endif; ?>
			</a>
		</div>
	</div>
	<?php if ($key !== ($pageLimit - 1)): ?>
		<hr>
	<?php endif; ?>
	<?php
	endforeach;
	?>
</div>
