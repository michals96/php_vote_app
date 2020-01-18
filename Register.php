<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Register
{
	function login()
	{
		$db = new SQLite3('baza.db');
		$login = $_POST['login'];
		$password = $_POST['password'];
		if($query = $db->query("SELECT * from president WHERE login='$login' AND password='$password'"))
		{
				$rows = $db->query("SELECT COUNT(*) as count from president WHERE login='$login' AND password='$password'");
				$row = $rows->fetchArray();
				$numRows = $row['count'];
				if($numRows > 0)
				{
					$row = $query->fetchArray(SQLITE3_ASSOC);
					$_SESSION['login'] = $row['login'];
					$_SESSION['name'] = $row['name'];
					$_SESSION['age'] = $row['age'];
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
		$password = $_POST['password'];
		$name = $_POST['name'];
		$age = $_POST['age'];
		if($login == '' || $password == '' || $name == '')
		{
			
			$_SESSION['message'] = "Registration failed, empty fields given";
			header('Location: online.php');
			exit();
		}
		$rows = $db->query("SELECT COUNT(*) as count from president WHERE login='$login'");
		$row = $rows->fetchArray();
		$numRows = $row['count'];
		if($numRows > 0)
		{
			$_SESSION['message'] = "User already exists";
			header('Location: online.php');
			exit();
		}
		if($age < 18)
		{
			$_SESSION['message'] = "Not old enough to vote";
			header('Location: online.php');
			exit();
		}
		$db->exec("INSERT INTO president VALUES('$name', '$login', '$password', '$age', NULL)");
		$_SESSION['message'] = "User ".$login." has been registered";
		header('Location: online.php');
	}
}
?>