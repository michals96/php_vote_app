<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
    <title>ONLINE VOTE</title>
    <style type="text/css">
        html {
            background: url(bck.jpg) no-repeat center center fixed;
            background-size: cover;
            height: 100%;
            overflow: hidden;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            text-align: center;
        }

        body {
            font-family: 'Abel';
            font-size: 22px;
        }

        #container {
            position: absolute;
            top: 120px;
            left: 100px;
            width: 100%;
            height: auto;
        }

        img {
            position: fixed;
            margin-left: 45%;
            margin-top: 8%;
            height: auto;
            width: 700px;
        }

        .button {
            background-color: #4CAF50;
            /* Green */
            border: none;
            color: white;
            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            -webkit-transition-duration: 0.4s;
            /* Safari */
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .button1 {
            background-color: white;
            color: black;
            border: 2px solid #4CAF50;
        }

        .button1:hover {
            background-color: #4CAF50;
            color: white;
        }

        .button2 {
            background-color: white;
            color: black;
            border: 2px solid #008CBA;
        }

        .button2:hover {
            background-color: #008CBA;
            color: white;
        }

        .button3 {
            background-color: white;
            color: black;
            border: 2px solid #f44336;
        }

        .button3:hover {
            background-color: #f44336;
            color: white;
        }

        .button4 {
            background-color: white;
            color: black;
            border: 2px solid #e7e7e7;
        }

        .button4:hover {
            background-color: #e7e7e7;
        }

        .firstItem {
            margin: 10px 0 10px 0;
        }

        .wyniki {
            position: fixed;
            margin-left: 45%;
            margin-top: 8%;
            display: flex;
            flex-direction: column;
        }

        .wyniki>div {
            margin: 10px;

        }
    </style>
</head>

<body>
    <script src='script.js'> </script>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav">

            <li class="nav-item active">
                <?php
                if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
                    echo "<a class='nav-link' href='#'>" .$_SESSION['name']."</a>";
                } else {
                    echo "<a class='nav-link' href='#'> Guest </a>";
                }
                ?>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">Main page</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="documentation.php">Documentation</a>
            </li>
            <?php
            if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
                echo "<a class='nav-link' href='logout.php'>Logout</a>";
            }
            ?>

        </ul>
    </nav>
    <div id='container'>
        <?php
        error_reporting(0);
        if (!isset($_SESSION['logged']) && $_SESSION['logged'] == false) {
            echo "<nav>";
            echo "<h1>Sign in</h1>";
            echo "<form action='login.php' method='post'>
            <input type='text' name='login' value='login'><br/>
            <input type='password' name='password' value='password'><br/>
            <input type='submit' value='' style='visibility: hidden;'><button class='button button4' value='Zaloguj'>Log-in</button>
            </nav>
            </form>";
            echo "<h1 style='margin: 250px 0px 0px 0px;'>Dont have an account?</h1>";
            echo "<a href='reg_form.php'><button class='button button4'>Register</button></a></div>";
            if (isset($_SESSION['error'])) {
                echo $_SESSION['error'] . "<br>";
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'] . "<br>";
                unset($_SESSION['message']);
            }
        } else {
            echo "
            <fieldset>
            <form action='online.php' method='post'>
            <h1>Choose your president</h1>
            <br><input type='radio' value='A' id='odpA' name='odp' checked> Donald Trump
            <br><input type='radio' value='B' id='odpB' name='odp'> Elizabeth Warren
            <br><input type='radio' value='C' id='odpC' name='odp'> Bernie Sanders 
            <br><input type='radio' value='D' id='odpD' name='odp'> Joe Biden
            <br><input type='submit' value='' style='visibility: hidden; margin: 70px 0px 0px 0px;'><button class='button button4' value='addanswer' onclick='removeImg()'>Approve vote</button>
            <input type='hidden' value='w' name='wynik'>
            </form>
            </fieldset>
            <br>
            </div>
            ";
            if (isset($_POST['odp'])) {
                $db = new SQLite3('baza.db');
                $db->exec("UPDATE president SET answer='$_POST[odp]' WHERE login='$_SESSION[login]'");
            }
            if (isset($_POST['wynik'])) {
                $db = new SQLite3('baza.db');
                $result =  $db->query("SELECT * from president WHERE answer IS NOT NULL");
                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $tab[] = $row;
                }
                $i = 0;
                $firstCount = 0;
                $secondCount = 0;
                $thirdCount = 0;
                $fourthCount = 0;
                $count = 0;
                while (isset($tab[$i]['name'])) {
                        switch ($tab[$i]['answer']) {
                            case "A":
                                ++$firstCount;
                                ++$count;
                                break;
                            case "B":
                                ++$secondCount;
                                ++$count;
                                break;
                            case "C":
                                ++$thirdCount;
                                ++$count;
                                break;
                            case "D":
                                ++$fourthCount;
                                ++$count;
                                break;
                        }
                        $i = $i + 1;
                    }
                $trumpPercentage = round((100 * $firstCount) / $count);
                $warrenPercentage = round((100 * $secondCount) / $count);
                $sandersPercentage = round((100 * $thirdCount) / $count);
                $bidenPercentage = round((100 * $fourthCount) / $count);
                $firstCount = $firstCount * 100;
                $secondCount = $secondCount * 100;
                $thirdCount = $thirdCount * 100;
                $fourthCount = $fourthCount * 100;
                echo "<div id='wyniki' class='wyniki'>";
                echo "<div id='trump' class='trump'>Trump $trumpPercentage% <canvas id='myCanvas' width='$firstCount' height='100' style='border:1px solid #c3c3c3; background-color: #3D9970;'></canvas></div>";
                echo "<div id='trump' class='trump'>Warren $warrenPercentage% <canvas id='myCanvas' width='$secondCount' height='100' style='border:1px solid #c3c3c3; background-color: #85144b;'></canvas></div>";
                echo "<div id='trump' class='trump'>Sanders $sandersPercentage% <canvas id='myCanvas' width='$thirdCount' height='100' style='border:1px solid #c3c3c3; background-color: #FF851B;'></canvas></div>";
                echo "<div id='trump' class='trump'>Biden $bidenPercentage% <canvas id='myCanvas' width='$fourthCount' height='100' style='border:1px solid #c3c3c3; background-color: #001f3f;'></canvas></div>";
                echo "</div>";
            }
        }
        ?>
        <?php
        if (!isset($_SESSION['logged']) && $_SESSION['logged'] == false) {
            echo "<img src='flag.png'>";
        }
        ?>
        <div class="footer">
            <p>Techniki Internetowe 2019/2020 Michal Stefaniuk</p>
        </div>
</body>

</html>