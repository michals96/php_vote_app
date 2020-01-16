<!DOCTYPE HTML>
<html>

<head>
	<meta charset="utf-8" />
	<title>ANKIETA</title>
	<style type="text/css">
		body {
			background-color: #50e29c;
		}
	</style>
</head>

<body>
	<form action='Zarejestruj.php' method='post'>
		<br>Imie<input type='text' name='imie'>
		<br>Login<input type='text' name='login'>
		<br>Haslo<input type='text' name='haslo'>
		<br>
		<?php
		echo "Wiek <select name='wiek'>";
		for ($i = 1; $i <= 100; $i++) {
				echo "<option value=$i>$i</option>";
			}
		?>
		<br>
		<input type='submit' value='Zarejestruj się'>
	</form>
</body>

</html>