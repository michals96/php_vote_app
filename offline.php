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
    <title>OFFLINE VOTE</title>
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
    </style>
</head>

<body>
    <script src='script.js'> </script>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav">

            <li class="nav-item active">
                <?php
                if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
                    echo "<a class='nav-link' href='#'> Logged </a>";
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
        </ul>
    </nav>
    <div id='container'>
        <?php
        echo "
		Name <input type='text' id='imie'> <br>
		Your age <select id='wiek' class='required'>";
        for ($i = 1; $i <= 100; $i++) {
            echo "<option value=$i>$i</option>";
        }
        echo "
        </select><br>
        <div class='firstItem'>
		Choose your president
		<br><input type='radio' value='A' id='odpA' name='odp' checked> Donald Trump
		<br><input type='radio' value='B' id='odpB' name='odp'> Bernie Sanders
		<br><input type='radio' value='C' id='odpC' name='odp'> Elizabeth Warren 
        <br><input type='radio' value='D' id='odpD' name='odp'> Joe Biden
        <br><input type='radio' value='E' id='odpE' name='odp'> Michael Bloomberg
        </div>
		<br><button class='button button1' id='add'>Approve vote</button>
		<br><button class='button button2' id='getAll'>Offline votes</button>
		<br><button class='button button3' id='deleteAll'>Clear votes</button>
		<div id='wyniki'></div>";
        echo "<form action='strona.php' method='post' id='akt'><input type='hidden' value='nic' name='aktual' id='hid'></form>";
        echo "<button class='button button4' id='up'>Send votes</button>";

        ?>

    </div>
    <img src="flag.png">
    <div class="footer">
        <p>Techniki Internetowe 2019/2020 Michal Stefaniuk</p>
    </div>
</body>

</html>