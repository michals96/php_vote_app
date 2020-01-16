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
        if (!isset($_SESSION['logged']) && $_SESSION['logged'] == false) {
            echo "<nav>";
            echo "Zaloguj sie";
            echo "<form action='Zaloguj.php' method='post'>
            Login: <input type='text' name='login'><br/>
            Haslo: <input type='password' name='haslo'><br/>
            <input type='submit' value='Zaloguj'>
            </form>";
            if (isset($_SESSION['error'])) {
                echo $_SESSION['error'] . "<br>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'] . "<br>";
                unset($_SESSION['message']);
            }
            echo "
            Nie masz konta? <a href='reg_form.php'>Zarejestruj się</a>
            <br/>Administrator: <br/>
            Login: admin <br/>
            Haslo: admin <br/>
            <a href='dokumentacja.html'>Dokumentacja</a></nav>";
        } else {
            echo "
            <fieldset>
            <form action='online.php' method='post'>
            Pytanie do ankiety
            <br><input type='radio' value='A' id='odpA' name='odp' checked> A
            <br><input type='radio' value='B' id='odpB' name='odp'> B
            <br><input type='radio' value='C' id='odpC' name='odp'> C 
            <br><input type='radio' value='D' id='odpD' name='odp'> D
            <br><input type='submit' value='Wyślij odpowiedź'>
            </form>
            </fieldset>
            <br><form action='online.php' method='post'><input type='hidden' value='w' name='wynik'><input type='submit' value='Wyświetl wyniki'></form>";

            if (isset($_POST['odp'])) {
                $db = new SQLite3('baza.db');
                $db->exec("UPDATE ankieta SET odpowiedz='$_POST[odp]' WHERE login='$_SESSION[login]'");
            }

            if (isset($_POST['wynik'])) {
                $db = new SQLite3('baza.db');
                $result =  $db->query("SELECT * from ankieta WHERE odpowiedz IS NOT NULL");
                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $tab[] = $row;
                }
                echo "<div id='wyniki'><table align='center'>";
                echo "<tr><th>Imie</th><th>Wiek</th><th>Odpowiedz</th></tr>";
                $i = 0;
                while (isset($tab[$i]['imie'])) {
                    $d = $tab[$i]['imie'];
                    $t = $tab[$i]['wiek'];
                    $p = $tab[$i]['odpowiedz'];
                    echo "<tr><td>$d</td><td>$t</td><td>$p</td></tr>";
                    $i = $i + 1;
                }
                echo "</table></div>";
            }
            echo "<nav>";
            echo "Witaj " . $_SESSION['imie'];
            echo "<br><a href='Wyloguj.php'>Wyloguj</a></nav>";
        }
        ?>
        <img src="logo.png">
    </div>

</body>

</html>