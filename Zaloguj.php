<?php
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		include 'Register.php';
		
		$user = new Register;
		session_start();
	
		if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
		{
			header('Location: online.php');
			exit();
		}
		
		$user->login();

?>