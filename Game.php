<?php

class Game
{

    const MAX_ROUNDS = 20;
    private static $round ;
    private $battleLog = [];
    private $nrOfPlayers ;
    private $players;
    private $hero;
    private $firstPlayerIndex;
    private $attacker;
    private $defender;
    private static $gameStatus ;

    public function __construct( $players = null )
    {
        self::$gameStatus = 1;
        self::$round = 1;
        $this->players = func_get_args();
        $this->nrOfPlayers = func_num_args();
        $isCharacter = $this->isCharacter( $this->players );

        if ( $isCharacter ) {
            $this->play();
        }
        
    }

    public static function getRound()
    {
        return Game::$round;
    }

    private function setFirstPlayerIndex ( $property, $value)
    {
        $players = $this->players;
        $nrOfPlayers = $this->nrOfPlayers;

        for ($i=0; $i < $nrOfPlayers; $i++ ) {
            $propertyValue = $players[$i]->getProperty($property);
            if ($propertyValue === $value) {
                $firstPlayerIndex = $i;
            }
        }
        return $firstPlayerIndex;
    }

    private function isMoreThanOnce($property, $valueToCheck)
    {
        $count = 0;
        $players = $this->players;
        foreach ($players as $player) {
            if ($player->getProperty($property) == $valueToCheck) {
                $count++;
            }
            if ($count > 1) {
                return true;
            }
        }
        return false;
    }

    private function getMaxProperty( $property ) {
        $nrOfPlayers = $this->nrOfPlayers;
        $players = $this->players;
        $max = 0;

        foreach ($players as $player) {
            $value = $player->getProperty($property);
            $max = ($max < $value) ? $value : $max;
        }
        return $max;
    }

    private function setNrOfPlayers( $nrOfArguments )
    {
        $this->nrOfPlayers = $nrOfArguments;
    }

    private function getNrOfPlayers()
    {
        return $this->nrOfPlayers;
    }

    private function isCharacter($players)
    {
        foreach ($players as $player) {
            try {
                $isCharacter = is_subclass_of( $player , 'Character' );

                if ($isCharacter === false) {
                    throw new Exception('Invalid player');
                }
            } catch (Exception $e) {
                echo 'Exception caught' , $e->getMessage( );
                return false;
            }
        }
        return true;
    }

    public function play( )
    {
        do {
            echo "<br />Checking players... <br /> ";
            $roundNr = self::$round;
            echo "Round number is $roundNr <br />";

            $nrOfPlayers = count($this->players);
            echo '<pre>';
            print_r($this->players);

            if ( $nrOfPlayers > 1) {
                if (self::$round == 20) {
                    echo "There is a tie."; die();
                }

                echo "We have $nrOfPlayers warriors in the ever-green forests of Emagia <br />";

                $this->setPlayers();
                $attackerIndex = $this->getAttacker();
                $attacker = $this->players[$attackerIndex];
                echo "Attacker is $attackerIndex <br />";

                $defenderIndex = $this->getDefender();
                $defender = $this->players[$defenderIndex];
                echo "Defender is $defenderIndex <br />";
                $attackerStrength = $attacker->attack( self::$round );
                $healthLeft = $defender->defend( $attackerStrength, self::$round );
                echo "Health of the defender after the attack is $healthLeft <br />";

                if ($healthLeft <= 0 ) {
                    $this->removePlayer($defenderIndex);
                }
            } else {
                echo "The battle is now over!";
                die();
            }

            self::$round++;
            $this->setGameStatus();
            
        } while ( self::$gameStatus == 1 );
        echo "<br />The winner of the Battle is: <br />";
        echo '<pre>'. print_r($this->players);
    }

    private function setGameStatus()
    {
        if ( (self::$round == self::MAX_ROUNDS ) || ($this->nrOfPlayers == 1)){
            self::$gameStatus = 0;
        }
    }

    private function removePlayer( $playerIndex)
    {
        echo "This warrior is dead <br />";
        $players =$this->players;
        unset($players[$playerIndex]);
        $newPlayers =array_values( $players);
        $this->players = $newPlayers;
        $this->getNrOfPlayers = count($this->players);
    }

    private function setPlayers()
    {
        $this->setAttacker();
        $this->setDefender();
    }

    private function setAttacker( )
    {
        if (self::$round == 1) {
            $this->attacker = $this->getFirstStrikePlayerIndex();

        } else {
            $attacker = $this->defender;
            if ($attacker >= $this->nrOfPlayers)
            {
                $attacker = 0;
            }

            $this->attacker = $attacker;
        }
    }

    private function getFirstStrikePlayerIndex(){
        $firstPlayerIndex = null;
        $maxSpeed = $this->getMaxProperty( "speed" );
        $sameSpeed = $this->isMoreThanOnce( "speed", $maxSpeed );

        if ( $sameSpeed == true ) {
            $maxLuck = $this->getMaxProperty( "luck" );
            $checkLuck = $this->isMoreThanOnce( "luck", $maxLuck );
            $firstPlayerIndex = $this->setFirstPlayerIndex("luck", $maxLuck);
            echo "Warrior with the best luck of $maxLuck hits first";
        } else {
            $firstPlayerIndex = $this->setFirstPlayerIndex("speed", $maxSpeed);
            echo "Warrior with the best speed of $maxSpeed hits first";
        }
        echo "<br />FirstPlayerIndex is:" . $firstPlayerIndex ." <br />" ;
        return $firstPlayerIndex;
    }

    private function setDefender()
    {
        $defender = $this->attacker +1 ;
        if ($defender >= $this->nrOfPlayers) {
            $defender = 0;
        }
        $this->defender = $defender;
    }

    private function getAttacker()
    {
        return $this->attacker;
    }

    private function getDefender()
    {
        return $this->defender;
    }
}