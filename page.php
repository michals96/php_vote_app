<?php
	$tab = explode("#", $_POST['aktual']);
	$i = 0;
	while($tab[$i])
	{
		$info = explode(":", $tab[$i]);
		$db = new SQLite3('baza.db');
		$db->exec("INSERT INTO president VALUES('$info[0]', NULL, NULL, '$info[1]', '$info[2]')");
		$i++;
	}
	header('Location: offline.php');
?>