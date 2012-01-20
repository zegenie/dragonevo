<div class="backdrop_box large" id="login_popup">
	<div id="backdrop_detail_content" class="rounded_top login_content">
		<?php echo $content; ?>
	</div>
	<div class="backdrop_detail_footer">
	<?php if ($mandatory != true): ?>
		<a href="javascript:void(0);" onclick="Devo.Main.Helpers.Backdrop.reset();">Close</a>
	<?php endif; ?>
	</div>
</div>
<?php if (isset($options['error'])): ?>
	<script type="text/javascript">
		Devo.Main.Helpers.Message.error('<?php echo $options['error']; ?>');
	</script>
<?php endif; ?>
<script type="text/javascript">
	$('devo_username').focus();
</script>