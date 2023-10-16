<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Społecznościowy</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <div class="baner-lewy">
        <h2>Nasze osiedle</h2>
    </div>
    <div class="baner-prawy">
        <!-- SCRIPT -->
        <?php 
            $con = mysqli_connect("localhost","root","","portal") or die ("Błąd połączenia");
            $zapytanie = "SELECT count(id) FROM dane";
            $odpowiedz = mysqli_query($con, $zapytanie);
            $res = mysqli_fetch_row($odpowiedz);
            echo "<h5>Liczba użytkowników portalu: $res[0]</h5>";
        ?>
    </div>
    <div class="blok-lewy">
        <h3>Logowanie</h3>
        <form action="" method="POST">
            <label for="login">Login</label>
            <input type="text" id="login" name="login"><br><br>
            <label for="haslo">Hasło</label>
            <input type="password" id="haslo" name="haslo"><br><br>
            <button type="submit">Zaloguj</button>
        </form>
    </div>
    <div class="blok-prawy">
        <h3>Wizytówka</h3>
        <!-- SCRIPT -->
        <div class="wizytowka">
        <?php 
            if (isset($_POST["login"]) && isset($_POST["haslo"])) {
                $login = $_POST["login"];
                $haslo = SHA1($_POST["haslo"]);
                if ($login != "" && $haslo != "") {
                    $con = mysqli_connect("localhost","root","","portal") or die ("Błąd połączenia");
                    $zapytanie1 = "SELECT * FROM `uzytkownicy` WHERE `login` = '$login';";
                    $dane = mysqli_query($con, $zapytanie1);
                    $reslogin = mysqli_num_rows($dane);
                    if ($reslogin == false) {
                        echo "login nie istnieje";
                    } 
                    else {
                        $checkhaslo = mysqli_fetch_assoc($dane);
                        if ($checkhaslo["haslo"] == $haslo) {
                            $zapytanie2 = "SELECT `login`, `rok_urodz`, `przyjaciol`, `hobby`, `zdjecie` FROM uzytkownicy JOIN dane ON dane.id=uzytkownicy.id WHERE uzytkownicy.login='$login';";
                            $wizytowka = mysqli_query($con,$zapytanie2);
                            while ($result2 = mysqli_fetch_row($wizytowka)){
                                $wiek = 2023 - $result2[1];
                                echo "<img src='$result2[4]' alt='osoba'><br><br>";
                                echo "<h3>$result2[0] ($wiek)</h3><br>";
                                echo "<p>hobby: $result2[3]</p><br>";
                                echo "<h1><img src='icon-on.png' alt='przyjaciele'> $result2[2]</h1><br>";
                                    echo "'<a href='dane.html' target='blank' class='wizytowka-button'>Wiecej informacji</a>";
    
                            }
                        }
                    }
                }
            }
        ?>
    </div>
    </div>
    <div class="footer">
        <p>Stronę wykonał: Paweł Lewandowski</p>
    </div>

</body>
</html>