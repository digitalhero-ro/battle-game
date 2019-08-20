<?php require_once( 'CharacterStats.php');

Abstract class Character implements CharacterStats
{
    public function getProperty( $property )
    {
        if (!isset($this->$property)) {
            throw new Exception("This character doesn't have such skills.");
        }
        return $this->$property;
    }

    public function setHealth( $health )
    {
        $this->health = $health;
    }

    public function chanceRatio( $chance )
    {
        $nrOfRounds = $chance * Game::MAX_ROUNDS / 100;
        return $nrOfRounds;
    }

    public function attack( $round )
    {
        return $this->strength;
    } 

    public function getDamage( $attack )
    {
        $defense = $this->defense;
        echo "Checking damage...($attack - $defense)";
        return $attack - $this->defense;
    }

    public function defend( $attack, $round )
    {
        echo "Health of the defender before the attack is: $this->health <br />";
        $damage = $this->getDamage($attack);
        echo "<br />The damage is $damage<br />";
        $health = $this->health - $damage;
        $this->setHealth($health);
        return $health;
    }
}