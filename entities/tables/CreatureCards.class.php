<?php

	namespace application\entities\tables;

	/**
	 * @Table(name="creature_cards")
	 * @Entity(class="\application\entities\CreatureCard")
	 * @Entities(identifier="card_state")
	 * @SubClasses(template="\application\entities\CreatureCard", owned="\application\entities\UserCreatureCard")
	 */
	class CreatureCards extends \b2db\Table
	{
		
	}