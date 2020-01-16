<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <title>ANKIETA</title>
    <style type="text/css">
        body {
            background-color: white;
        }

        #container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: auto;
        }

        img {
            position: fixed;
            margin-left: 45%;
            margin-top: 25%;
        }
    </style>
</head>

<body>
    <script src='script.js'> </script>

    <div id='container'>
        <?php
        echo "
		<fieldset>
		Imie <input type='text' id='imie'> <br>
		Wiek <select id='wiek'>";
        for ($i = 1; $i <= 100; $i++) {
                echo "<option value=$i>$i</option>";
            }
        echo "
		</select><br>
		Pytanie do ankiety
		<br><input type='radio' value='A' id='odpA' name='odp' checked> A
		<br><input type='radio' value='B' id='odpB' name='odp'> B
		<br><input type='radio' value='C' id='odpC' name='odp'> C 
		<br><input type='radio' value='D' id='odpD' name='odp'> D
		<br><button id='add'>Wyślij odpowiedź (offline)</button>
		</fieldset>
		<br><button id='getAll'>Wyświetl wyniki (offline)</button>
		<br><button id='deleteAll'>Usuń wszystko (offline)</button>
		<div id='wyniki'></div>";

        echo "<form action='strona.php' method='post' id='akt'><input type='hidden' value='nic' name='aktual' id='hid'></form>";
        echo "<button id='up'>Wyślij wyniki do bazy online</button>";

        ?>
        <img src="logo.png">
    </div>

</body>

</html>