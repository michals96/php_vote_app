<?php
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		include 'Register.php';
		
		$user = new Register;
		session_start();
	
		if ((!isset($_POST['login'])) || 
		(!isset($_POST['haslo'])) || (!isset($_POST['imie'])) 
		|| (!isset($_POST['wiek'])))
		{
			header('Location: index.php');
			exit();
		}
		
		$user->reg();

?>