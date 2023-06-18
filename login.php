<?php

require './db.php';
$db = new Db();
$message = "";
session_start();
if (isset($_GET['logovanje'])) {
    $res = $db->logovanje($_GET['user'], $_GET['pass']);
    if (!$res) {
        $message .= "pogresno korisincko ime/sifra";
    } else {
        $_SESSION['user'] = $res['ime'];
        $_SESSION['rola'] = $res['uloga'];
      
       $_SESSION['pass'] = $res['prezime'];
       if(isset($_GET['pass'])){
           setcookie("pass",$pass, time()+86400*2);
       }
        header("Location:index.php");
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>

        <form>

            Ime<input type="text" name="user" placeholder="korisnicko ime" value="<?php if (isset($_COOKIE["user"]))echo $_COOKIE["user"];?>"><br><br>

            Sifra<input type="text" name="pass" placeholder="sifra" value="<?php if (isset($_COOKIE["pass"]))echo $_COOKIE["pass"];?>"><br><br>
            Zapamti <input type="checkbox" name="zapamti"><br><br>
            <input type="submit" name="logovanje" value="Login"><br><br>
            
            <?php echo $message;?>


        </form>
    </body>
</html>
