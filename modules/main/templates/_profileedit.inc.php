<div class="backdrop_box large" id="editprofile_popup">
	<div id="backdrop_detail_content" class="rounded_top login_content">
		<form method="post" accept-charset="utf-8" id="profile_form" onsubmit="Devo.Main.Profile.save(this);return false;">
			<h1>Update your profile details</h1>
			<div style="font-size: 1.2em; margin-top: 15px;">
				<div style="margin: 5px 0;">
					<label for="profile_edit_charactername">Character name</label><input type="text" id="profile_edit_charactername" name="charactername" value="<?php echo $csp_user->getCharactername(); ?>" style="width: 200px;">
				</div>
				<div style="margin: 5px 0;">
					<label for="profile_edit_age">Age</label><input type="text" id="profile_edit_age" name="age" value="<?php echo $csp_user->getAge(); ?>" style="width: 30px;">
					<input type="checkbox" id="profile_edit_age_show_only_friends" name="age_show_only_friends" <?php if ($csp_user->getAgeShowOnlyFriends()) echo ' checked'; ?>><label for="profile_edit_age_show_only_friends" style="font-weight: normal; display: inline-block; width: auto; float: none;">Only visible to friends</label>
				</div>
				<div style="margin: 5px 0;">
					<label for="profile_edit_location">Location</label><input type="text" id="profile_edit_location" name="location" value="<?php echo $csp_user->getLocation(); ?>" style="width: 150px;">
					<input type="checkbox" id="profile_edit_location_show_only_friends" name="location_show_only_friends" <?php if ($csp_user->getLocationShowOnlyFriends()) echo ' checked'; ?>><label for="profile_edit_location_show_only_friends" style="font-weight: normal; display: inline-block; width: auto; float: none;">Only visible to friends</label>
				</div>
				<div style="margin: 5px 0;">
					<label for="profile_edit_bio" style="margin-bottom: 20px;">Bio</label>
					<textarea name="bio" id="profile_edit_bio" style="width: 400px; height: 60px;"><?php echo $csp_user->getBio(); ?></textarea><br>
					<input type="checkbox" id="profile_edit_bio_show_only_friends" name="bio_show_only_friends" style="margin-left: 140px;" <?php if ($csp_user->getBioShowOnlyFriends()) echo ' checked'; ?>><label for="profile_edit_bio_show_only_friends" style="font-weight: normal; display: inline-block; width: auto; float: none;">Only visible to friends</label><br>
				</div>
			</div>
			<br style="clear: both;">
			<div style="clear: both; text-align: right; padding: 10px; margin-top: 10px; background-color: rgba(80, 54, 32, 0.4); border: 1px dotted rgba(72, 48, 28, 0.8); border-left: none; border-right: none;">
				<img src="/images/spinning_20.gif" id="save_profile_indicator" style="display: none; margin: 2px 5px -6px 0;">
				<a href="javascript:void(0);" onclick="Devo.Main.Helpers.Backdrop.reset();$('fullpage_backdrop_content').update('');" style="font-size: 0.9em; font-weight: normal;">Cancel</a> or <button class="ui_button" style="font-size: 0.9em; line-height: 14px !important;">Update profile</button>
			</div>
		</form>
	</div>
</div>
