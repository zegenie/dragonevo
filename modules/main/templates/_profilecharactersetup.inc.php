<div class="fullpage_backdrop dark" id="profile-character-setup" style="display: none;">
	<div class="swirl-dialog profile_setup">
		<img src="/images/swirl_top_right.png" class="swirl top-right">
		<img src="/images/swirl_bottom_right.png" class="swirl bottom-right">
		<img src="/images/swirl_bottom_left.png" class="swirl bottom-left">
		<img src="/images/swirl_top_left.png" class="swirl top-left">
		<h1>Greetings, brave traveler!</h1>
		<p>
			Our great world - once a peaceful land, now torn to pieces by war and bickering - is anxiously looking forward to your heroic presence.
		</p>
		<form action="<?php echo make_url('profile'); ?>" method="post" onsubmit="Devo.Main.Profile.completeCharacterSetup();return false;" id="character-setup-form">
			<input type="hidden" name="character_setup" value="1">
			<input type="hidden" name="step" value="1">
			<input type="hidden" name="race" value="" id="race_input">
			<input type="hidden" name="avatar" value="" id="avatar_input">
			<div id="character-avatar-container" class="character_setup">
				<label>It is too dark to see you. What do you look like?</label><br>
				<?php foreach (range(1, 13) as $avatar): ?>
					<div class="avatar_preview" onclick="Devo.Main.Profile.pickAvatar(<?php echo $avatar; ?>);" id="avatar_preview_<?php echo $avatar; ?>" style="background-image: url('/images/avatars/avatar_<?php echo $avatar; ?>.png');"></div>
				<?php endforeach; ?>
				<br>
				<div style="text-align: right; margin-top: 20px;">
					<button id="character_avatar_button" class="button button-standard" onclick="$('character-avatar-container').addClassName('completed');$('character-name-container').toggle();return false;" style="font-size: 1em; font-weight: normal; padding: 7px 15px !important;" disabled>This is how I look &raquo;</button>
				</div>
			</div>
			<div id="character-name-container" class="character_setup" style="display: none;">
				<label for="character_name_input">Please, tell us your fair name</label><br>
				<input type="text" name="character_name" id="character_name_input" value="<?php echo $csp_user->getCharacterName(); ?>" style="padding: 7px;">
				<button id="character_name_button" class="button button-standard" onclick="$('character_name_display').update($('character_name_input').getValue());$('character-name-container').toggle();$('race-card-picker').toggle();return false;" style="display: inline-block; font-size: 1em; font-weight: normal; padding: 7px 15px !important;">That is my name &raquo;</button>
			</div>
			<div class="character_setup cardpicker" id="race-card-picker" style="display: none;">
				<h6>It's great to see you, <span id="character_name_display"></span></h6>
				<p style="padding-left: 2px;">
					The people of our land have heard many tales about you. I urge you, tell us your race.
				</p>
				<ul class="cards">
					<?php foreach (array(1, 3, 4, 2) as $race): ?>
						<li class="card item" id="race_<?php echo $race; ?>_div" onclick="Devo.Main.Profile.pickRace(<?php echo $race; ?>);" style="">
							<div class="name"><?php

								switch ($race) {
									case \application\entities\User::RACE_HUMAN:
										echo 'Humans';
										break;
									case \application\entities\User::RACE_LIZARD:
										echo 'Lacerta';
										break;
									case \application\entities\User::RACE_BEAST:
										echo 'Yakashdi';
										break;
									case \application\entities\User::RACE_ELF:
										echo 'Kalvarth';
										break;
								}

							?></div>
							<div class="card_image" style="background-image: url('/images/race_<?php echo $race; ?>.png');">
							</div>
							<div class="card_reflection">
								<img src="/images/race_<?php echo $race; ?>.png">
								<div class="cover"></div>
							</div>
							<div class="description" style="font-size: 0.8em; font-weight: normal; text-align: left;">
								<div class="description_content">
									<?php

										switch ($race) {
											case \application\entities\User::RACE_HUMAN:
												?>
												The most common race in Erendor. The humans were the first to rise as a kingdom on the continent and adapted quickly to the shifting situations. Being the first kingdom on the continent, most humans consider themselves the true rules of the land.
												<?php
												break;
											case \application\entities\User::RACE_LIZARD:
												?>
												Long lost scrolls mention the humanoid lizard-like Lacerta as descendants from a time before the gods created Humans and Dragons. After the great war, many Lacerta were hunted down and killed because of their alleged kinship with the Dragons.
												<?php
												break;
											case \application\entities\User::RACE_BEAST:
												?>
												Tall, hairy, troll-like creatures comes from the north areas far beyond the land of Erendor. The Yakashdi of Erendor &ndash; while said to be smaller than their northern ancestors &ndash; rage 2 two 3 heads higher than the average human.
												<?php
												break;
											case \application\entities\User::RACE_ELF:
												?>
												Very little is known about the ancient Kalvarth race, their origins, how they live or how they reproduce. While similar in appearance to humans, they are all very slender, agile and good looking, with long silvery hair and long limbs.
												<?php
												break;
										}

									?>
								</div>
								<div class="tooltip">
									<?php

										switch ($race) {
											case \application\entities\User::RACE_HUMAN:
												?>
												The humans were the founders of &laquo;Tarakona&raquo; &ndash; the largest city of Erendor &ndash; now ruled by the dragon emperor. The humans are capable of evolving basic resistance to all magic types and &ndash; having fought their way in this world &ndash; an improved resistance to melee attacks.
												<?php
												break;
											case \application\entities\User::RACE_LIZARD:
												?>
												The Lacerta - incapable of withstanding their onslaught - ended up fleeing the continent of Erendor, with only the strongest staying behind, fighting back. Eventually, the inhabitans of Erendor &ndash; forced to focusing on pure survival &ndash; left the Lacerta alone. They use their long, strong tails as a &laquo;third hand&raquo; which makes them highly versatile and able. Their spit is venomous &ndash; even among their own species. As such, all Lacerta can develop increased resistance to poison and dark magic.
												<?php
												break;
											case \application\entities\User::RACE_BEAST:
												?>
												Despite their intimidating looks, the Yakashdi are a peaceful people. They're dedicated to farming and form close bonds with nature. Yakashdi people tend to spend decades on learning a skill to the utmost perfection. All Yakashdi are physically intimidating making them capable of doing much harm in melee combat. Their close bonds with nature also increases their nature magic abilities.
												<?php
												break;
											case \application\entities\User::RACE_ELF:
												?>
												After dying, their spiritual form often remain in the shape of their physical being, but almost ethereal. In this form they take less damage and have a limited interaction with the physical world, but they have a strong connection to all magic types. Kalvarth magic do more damage and they take a lot less damage from melee attacks. They do however take more damage from ranged attacks and fire &ndash; and they deal less melee damage to others.
												<?php
												break;
										}

									?>
								</div>
							</div>
							<div class="selection_indicator"><img src="/images/icon_ok.png"></div>
						</li>
					<?php endforeach; ?>
				</ul>
				<br style="clear: both;">
				<div class="card_help">Choose your race by picking one of the race cards</div>
				<input type="submit" value="Collect starter pack" id="character_continue_button" style="display: none;" disabled>
			</div>
		</form>
	</div>
</div>