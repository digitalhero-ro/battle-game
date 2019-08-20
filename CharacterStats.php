<?php

interface CharacterStats
{
    public function setHealth( $health );
    public function getProperty( $property );
    public function chanceRatio( $chance );
    public function attack( $round );
    public function defend ( $attack, $round );
    public function getDamage( $attack );
}