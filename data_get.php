<?php

require './db.php';
$db = new Db();
if (isset($_GET['Korisnici'])) {
    $res = $db->dajKorisnike();
    if (!$res) {
        echo 'false';
        return;
    } else {
        echo json_encode($res);
        return;
    }
}

if (isset($_GET['Prezime']) && isset($_GET['Ime'])) {


    $res1 = $db->dajListu($_GET['Ime'], $_GET['Prezime']);
    if (!$res1) {
        echo 'false';
        return;
    } else {
        echo json_encode($res1);
        return;
    }
}


if (isset($_GET['delete'])) {
    $res = $db->izbrisi($_GET['delete']);
    if (!$res) {
        echo "false";
        return;
    } else {
        echo "true";
        return;
    }
}

if (isset($_GET['ime'])) {
    $res = $db->dodajKorisnika($_GET['ime'], $_GET['prezime'], $_GET['brojIndeksa'], $_GET['godinaUpisa']);
    echo $res;
    return;
}

if (isset($_GET['ocena'])) {
    $res = $db->dodajPredmet($_GET['ime1'], $_GET['prezime1'], $_GET['brojIndeksa1'], $_GET['godinaUpisa1'], $_GET['predmet'], $_GET['ocena']);

    echo $res;
    return;
}
?>

