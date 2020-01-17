<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Register
{
	function login()
	{
		$db = new SQLite3('baza.db');
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		if($query = $db->query("SELECT * from ankieta WHERE login='$login' AND haslo='$haslo'"))
		{
				$rows = $db->query("SELECT COUNT(*) as count from ankieta WHERE login='$login' AND haslo='$haslo'");
				$row = $rows->fetchArray();
				$numRows = $row['count'];
				if($numRows > 0)
				{
					$row = $query->fetchArray(SQLITE3_ASSOC);
					$_SESSION['login'] = $row['login'];
					$_SESSION['imie'] = $row['imie'];
					$_SESSION['wiek'] = $row['wiek'];
					$_SESSION['logged'] = true;
					header('Location: online.php');
				}
				else
				{
					$_SESSION['error'] = "User dont exist";
					header('Location: online.php');
				}
		}
		else 
		{
			$_SESSION['error'] = "User dont exist";
			header('Location: online.php');
		}
	}
	
	function reg()
	{
		$db = new SQLite3('baza.db');
		$login = $_POST['login'];
		$haslo = $_POST['haslo'];
		$imie = $_POST['imie'];
		$wiek = $_POST['wiek'];
		if($login == '' || $haslo == '' || $imie == '')
		{
			
			$_SESSION['message'] = "Registration failed, empty fields given";
			header('Location: online.php');
			exit();
		}
		$rows = $db->query("SELECT COUNT(*) as count from ankieta WHERE login='$login'");
		$row = $rows->fetchArray();
		$numRows = $row['count'];
		if($numRows > 0)
		{
			$_SESSION['message'] = "User already exists";
			header('Location: online.php');
			exit();
		}
		if($wiek < 18)
		{
			$_SESSION['message'] = "Not old enough to vote";
			header('Location: online.php');
			exit();
		}
		$db->exec("INSERT INTO ankieta VALUES('$imie', '$login', '$haslo', '$wiek', NULL)");
		$_SESSION['message'] = "User ".$login." has been registered";
		header('Location: online.php');
	}
	
}


?>