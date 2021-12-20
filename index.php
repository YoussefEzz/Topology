
<?php
	include_once 'API.php';
	header('Content-type: text/javascript');

	$filename = "topology.json";
	$topology = readJSON($filename) ;
	//echo($topology);
	
	//var_dump($topology);
	writeSON($topology);
?>
