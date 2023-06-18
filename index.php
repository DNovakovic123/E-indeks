<?php
require './db.php';
$db = new Db();
session_start();
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie("COOCIE", "", time() - 2);
}
if (!isset($_SESSION['user'])) {
    header("Location:login.php");
} else {
    $rola = $_SESSION['rola'];
    $user = $_SESSION['user'];
    $pass = $_SESSION['pass'];
}
?>

<script>

    function dajKorisnike() {



        let req = new XMLHttpRequest();
        req.open("get", "data_get.php?Korisnici=", true);
        req.send();
        req.onload = function () {

            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText != "false") {
                    var tabela1 = JSON.parse(this.responseText);
                    console.table(tabela1);

                    var tabela = "<table border='1' cellpadding='10'>";
                    tabela += "<tr><th>Ime</th> <th>Prezime</th><th>Broj indeksa</th><th>Godina upisa</th> <th></th></tr>";
                    tabela1.forEach(item => {
                        if (item.uloga != "admin")
                        {
                            tabela += "<tr>";
                            tabela += `<td>${item.ime}</td>`;
                            tabela += `<td>${item.prezime}</td>`
                            tabela += `<td>${item.brojIndeksa}</td>`
                            tabela += `<td>${item.godinaUpisa}</td>`
                            tabela += "<td><button id='" + item.id + "' onclick=obrisi(this.id)>Obrisi</button></td>"
                            tabela += "</tr>";

                        }

                    })
                    tabela += "</table>";
                    document.getElementById("prvaTabela").innerHTML = tabela;
                }
            }
        }
    }



    function obrisi(id) {
        let req = new XMLHttpRequest();
        req.open("get", "data_get.php?delete=" + id, true);
        req.send();
        req.onload = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "true") {
                    dajKorisnike();
                } else {
                    console.log("Greska");
                }
            }
        }
    }


    function  dodajKorisnika() {

        ime = document.getElementById("ime").value;
        prezime = document.getElementById("prezime").value;
        brojIndeksa = document.getElementById("brojIndeksa").value;
        godinaUpisa = document.getElementById("godinaUpisa").value;
        let req = new XMLHttpRequest();
        req.open("get", `data_get.php?ime=${ime}&prezime=${prezime}&brojIndeksa=${brojIndeksa}&godinaUpisa=${godinaUpisa}`, true);
        req.send();
        req.onload = function () {
            if (this.readyState == 4 && this.status == 200) {


                console.log(this.responseText);


            }
        }

    }


    function dajSvePredmete() {

        ime = "<?php echo $_SESSION['user']; ?>";
        prezime = "<?php echo $_SESSION['pass']; ?>";
        let req = new XMLHttpRequest();
        req.open("get", "data_get.php?Ime=" + ime + "&Prezime=" + prezime, true);
        req.send();
        req.onload = function () {

            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText != "false") {
                    var tabela1 = JSON.parse(this.responseText);
                    console.table(tabela1);

                    var tabela = "<table border='1' cellpadding='5'>";
                    tabela += "<tr><th>Ime</th> <th>Prezime</th> <th>Broj indeksa </th> <th>Godina upisa </th> <th>Predmet</th> <th>Ocena</th> </tr>";
                    tabela1.forEach(item => {


                        tabela += "<tr>";
                        tabela += `<td>${item.ime}</td>`;
                        tabela += `<td>${item.prezime}</td>`
                        tabela += `<td>${item.brojIndeksa}</td>`
                        tabela += `<td>${item.godinaUpisa}</td>`
                        tabela += `<td>${item.nazivPredmeta}</td>`
                        tabela += `<td>${item.ocena}</td>`
                        tabela += "</tr>";

                    })

                    tabela += "</table>";
                    document.getElementById("drugaTabela").innerHTML = tabela;
                }
            }
        }

    }

    function  DodajOcene() {
     ime = document.getElementById("ime1").value;
      prezime = document.getElementById("prezime1").value;
      brojIndeksa = document.getElementById("brojIndeksa1").value;
       godinaUpisa = document.getElementById("godinaUpisa1").value;
        
       nazivPredmeta = document.getElementById("predmet").value;
       ocena = document.getElementById("ocena").value;
        let req = new XMLHttpRequest();
        req.open("get",`data_get.php?ime1=${ime}&prezime1=${prezime}&brojIndeksa1=${brojIndeksa}&godinaUpisa1=${godinaUpisa}&predmet=${nazivPredmeta}&ocena=${ocena}`, true);
        req.send();
        req.onload = function () {
            if (this.readyState == 4 && this.status == 200) {
                
                console.log(this.responseText);


            }
        }


    }


</script>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body onload="dajKorisnike(), dajSvePredmete()">


        <?php
        if ($rola == "admin") {
            
            ?>

            <h1>Dobrodosli korisnice <?php echo $user . " " . $pass; ?> </h1><br><br>

            <div id="prvaTabela">


            </div>
            <br><br>
            <br><br>
            <h3>Dodajte korisnika</h3>
            <form id="myForm">
                Ime:<input type="text" id="ime"><br><br>
                Prezime: <input type="text" id="prezime" ><br><br>
                Indeks <input type="text" id="brojIndeksa" ><br><br>
                Godina <input type="text" id="godinaUpisa"><br><br>
                <input type="submit" value="Dodaj Korisnika" onclick="dodajKorisnika(this.id)">
            </form>

            <br>
            <br>
            <h3>Dodajte ocene</h3>
            <form id="myForm1">
                <br>
               
                <br><br>
                Ime:<input type="text" id="ime1" ><br><br>
                Prezime: <input type="text" id="prezime1" ><br><br>
                Indeks <input type="text" id="brojIndeksa1" ><br><br>
                Godina <input type="text" id="godinaUpisa1" ><br><br>
                Predmet <input type="text" id="predmet" ><br><br>
                Ocena <input type="text" id="ocena" ><br><br><br>
                <input type="submit" value="Dodaj Predmet" onclick="DodajOcene()">
            </form>
    <?php
      } 
      else 
          
       {
    ?>
            <h1>Dobrodosli korisnice <?php echo $user . " " . $pass; ?> </h1><br><br> 

            <div id="drugaTabela">


            </div><br><br>

    <?php
}
?>
        <br>  
        <a href="index.php?logout=">Logout</a><br>
    </body>
</html>
