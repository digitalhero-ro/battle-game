<!DOCTYPE html>
<html>
<head>
	<title>Orderus vs Beast</title>
	<h1>Orderus vs Beast</h1>
</head>
<body>
<?php

require_once( 'Game.php');
require_once( 'Orderus.php');
require_once( 'Beast.php');

$orderus = new Orderus();
$beast = new Beast();

$game = new Game( $beast, $orderus );

?>

</body>
</html>