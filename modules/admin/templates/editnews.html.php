<?php

	use application\entities\News;

	$csp_response->setTitle($news->getId() ? __('Edit %news_title%', array('%news_title%' => $news->getTitle())) : __('Create new news item'));

?>
<h2 style="margin: 10px 0 0 10px;">
	<?php echo link_tag(make_url('admin_news'), "Manage news"); ?>&nbsp;&rArr;
	<?php echo $news->getId() ? $news->getTitle() : __('New news item'); ?>
</h2>
<?php if (isset($error) && $error): ?>
	<h6 class="error"><?php echo $error; ?></h6>
<?php endif; ?>
<form method="post" accept-charset="utf-8">
	<fieldset>
		<legend>News details</legend>
		<div>
			<label for="news_title">Title</label>
			<input type="text" name="title" id="news_title" value="<?php echo $news->getTitle(); ?>">
		</div>
		<div>
			<label for="created_at_day">Posted at</label>
			<select style="width: 40px;" name="day" id="created_at_day">
			<?php for($cc = 1;$cc <= 31;$cc++): ?>
				<option value=<?php print $cc; ?><?php echo (($news->getDay() == $cc) ? " selected" : "") ?>><?php echo $cc; ?></option>
			<?php endfor; ?>
			</select>
			<select style="width: 85px;" name="month" id="created_at_month">
			<?php for($cc = 1;$cc <= 12;$cc++): ?>
				<option value=<?php print $cc; ?><?php print (($news->getMonth() == $cc) ? " selected" : "") ?>><?php echo strftime('%B', mktime(0, 0, 0, $cc, 1)); ?></option>
			<?php endfor; ?>
			</select>
			<select style="width: 55px;" name="year" id="created_at_year">
			<?php for($cc = 1990;$cc <= (date("Y") + 10);$cc++): ?>
				<option value=<?php print $cc; ?><?php echo (($news->getYear() == $cc) ? " selected" : "") ?>><?php echo $cc; ?></option>
			<?php endfor; ?>
			</select>
			<input type="text" style="width: 20px;" name="hour" id="created_at_hour" value="<?php echo $news->getHour(); ?>">&nbsp;:&nbsp;<input type="text" style="width: 20px;" name="minute" id="created_at_minute" value="<?php echo $news->getMinute(); ?>">
		</div>
		<div>
			<label for="news_url">URL</label>
			<input type="text" name="news_url" id="news_url" value="<?php echo $news->getUrl(); ?>">
			<p style="margin: 10px 0 20px 140px;" class="faded_out">Type an URL if you want this news item to link to an URL</p>
			<p style="margin: 10px 0 20px 140px;"> - OR - </p>
		</div>
		<div>
			<label for="news_content">Content</label>
			<textarea name="content" id="news_content" style="width: 750px; height: 400px;"><?php echo $news->getContent(); ?></textarea><br>
			<p style="margin: 10px 0 0 140px;" class="faded_out">Type news content here if you want this news item to have its own news page</p>
		</div>
	</fieldset>
	<br style="clear: both;">
	<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: rgba(80, 54, 32, 0.4); border: 1px dotted rgba(72, 48, 28, 0.8); border-left: none; border-right: none;">
		<input type="submit" value="Save" style="font-size: 1em; padding: 3px 10px !important;">
	</div>
</form>