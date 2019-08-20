<?php

Class Beast extends Character
{
    protected $strength;
    protected $defense;
    protected $speed;
    protected $luck;
    protected $health;
    protected $name;

    public function __construct()
    {
        $this->skillAttack = false;
        $this->skillDefend = false;
        $this->health = rand(60, 90);
        $this->strength = rand(60, 90);
        $this->defense = rand(40, 60);
        $this->speed = rand(40,60);
        $this->luck = rand(25, 40);
        $this->name = "Wild Beast";
    }
}
?>