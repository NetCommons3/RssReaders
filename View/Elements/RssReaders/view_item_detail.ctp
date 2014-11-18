<div class="list-group">
	<div class="panel-body">
		<a href="<?php echo h($link); ?>" target="_blank" class="text-muted">
			<div class="list-group-item-heading">
				<h4><?php echo h($title); ?></h4>
				<span class="text-info small">
					(
					<?php echo h($date->format('Y/m/d h:i')); ?>
					)
				</span>
			</div>
			<?php if ($displaySummary): ?>
			<p class="list-group-item-text small">
				<?php echo $summary; ?>
			</p>
			<?php endif; ?>
		</a>
	</div>
</div>
<?php if ($key !== ($pageLimit - 1)): ?>
	<hr>
<?php endif;
