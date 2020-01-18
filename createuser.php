<?php
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
		include 'Register.php';
		
		$user = new Register;
		session_start();
	
		if ((!isset($_POST['login'])) || 
		(!isset($_POST['password'])) || (!isset($_POST['name'])) 
		|| (!isset($_POST['age'])))
		{
			header('Location: online.php');
			exit();
		}
		else
		{
			$message = "wrong answer";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
		
		$user->reg();

?>