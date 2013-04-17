<?php

	use application\entities\User;

?>
<li class="card item" id="race_<?php echo $race; ?>_div" onclick="Devo.Main.Profile.pickRace(<?php echo $race; ?>);" style="">
	<div class="name"><?php echo $racename; ?></div>
	<div class="card_image" style="background-image: url('/images/race_<?php echo strtolower($racename); ?>.png'); background-size: cover; background-position: 0 -40px;">
	</div>
	<div class="card_reflection">
		<img src="/images/race_<?php echo strtolower($racename); ?>.png">
		<div class="cover"></div>
	</div>
	<div class="description">
		<div class="description_content">
			<?php

				switch ($race) {
					case User::RACE_HUMAN:
						?>
						<strong>Weaknesses:</strong><br>
						Dark magic<br>
						<br>
						<strong>Strengths:</strong><br>
						Melee and ranged attacks
						<?php
						break;
					case User::RACE_LIZARD:
						?>
						<strong>Weaknesses:</strong><br>
						Ranged attacks<br>
						<br>
						<strong>Strengths:</strong><br>
						Fire resistance, Poison resistance
						<?php
						break;
					case User::RACE_BEAST:
						?>
						<strong>Weaknesses:</strong><br>
						Fire attacks, Poison attacks, Ice attacks, Ranged attacks<br>
						<br>
						<strong>Strengths:</strong><br>
						Nature attacks, Melee attacks, Nature resistance, Melee defense
						<?php
						break;
					case User::RACE_ELF:
						?>
						<strong>Weaknesses:</strong><br>
						Melee attacks<br>
						<br>
						<strong>Strengths:</strong><br>
						Ranged Attacks, Defense, Magic
						<?php
						break;
				}

			?>
		</div>
	</div>
	<div class="selection_indicator"><img src="/images/icon_ok.png"></div>
</li>