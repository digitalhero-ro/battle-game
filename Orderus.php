<?php require_once( 'Character.php');

Class Orderus extends Character
{
	protected $strength;
	protected $defense;
	protected $speed;
	protected $luck;
	protected $health;
	protected $name;
	public $skillAttack ;
	public $skillDefend ;
	const SKILL_ATTACK_CHANCE = 10;
	const SKILL_DEFEND_CHANCE = 20;

	
		public function __construct()
		{
			$this->health = rand(70, 100);
			$this->strength = rand(70, 80);
			$this->defense = rand(45, 55);
			$this->speed = rand(40, 50);
			$this->luck = rand(10, 30);
			$this->skillAttack = true;
			$this->skillDefend = true;
			$this->name = "Orderus";
		}
	
		final protected function rapidStrike()
		{
			return $this->strength * 2;
		}

		final protected function magicShield($damage)
		{
			return $damage / 2;
		}

		private function isSkillAttackRound( $round )
		{
			$isSkillAttackRound = false;
			$chance = $this->chanceRatio( Orderus::SKILL_ATTACK_CHANCE )	;
			if ($round >=$chance) {
				$isSkillAttackRound = ( $round % $chance == 0 )? true :false;
			}
			return $isSkillAttackRound;
		}

		private function isSkillDefendRound( $round )
		{
			$isSkillDefendRound = false;
			$chance = $this->chanceRatio( Orderus::SKILL_ATTACK_CHANCE );
			if ($round >= $chance) {
				$isSkillDefendRound = ( $round % $chance == 0)? true :false ;
			}
			return $isSkillDefendRound;
		}

		public function defend( $attack, $round )
		{
			echo "Health of the defender before the attack is: $this->health.<br />";
				$defense = $this->defense;
			echo "Damage is ($attack - $defense)<br />";
			$damage = $attack - $this->defense;
			
			$skillRound = $this->isSkillDefendRound($round);

			if ( $skillRound ) {
				echo "<b>Magic Shield was used.</b><br />";
				$damage = $this->magicShield($damage);
			}

			echo "<br />The damage made is $damage. <br/>";
			$health = $this->health - $damage;
			$this->setHealth($health);
			return $health;
		}

		public function attack($round = null)
		{
		$skillRound = $this->isSkillAttackRound($round);
		$strength = $this->strength;

		if ( $skillRound ) {
			echo "<b>Rapid Strike was used</b><br />";
			$strength = $this->rapidStrike();
		}
		
		return $strength;
	}

}