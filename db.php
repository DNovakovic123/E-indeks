<?php

class Db {

    private $db;

    public function __construct() {
        $Conn = "sqlite:sluzba1.db";
        $this->db = new PDO($Conn);
    }

    public function logovanje($user, $pass) {
        $sql = "select * from korisnik1  where ime='$user' and prezime='$pass'";

        $res = $this->db->query($sql);

        if (!$res) {
            return FALSE;
        } else {
            return $res->fetch(PDO::FETCH_ASSOC);
        }
    }
    
    public function dajKorisnike(){
        
        $sql="select * from korisnik1";
        $res= $this->db->query($sql);
        if (!$res) {
            return FALSE;
        } else {
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }
    
    public function dajListu($ime,$prezime){
        $sql="select * from lista where ime='$ime' and prezime='$prezime'";
        $res= $this->db->query($sql);
        if (!$res) {
            return FALSE;
        } else {
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }


    public function  dajSvePodatke($ime=null,$prezime=null){
        $sql1="select * from korisnik1";
        $res1= $this->db->query($sql1);
        $sviKorisnici=$res1->fetchAll(PDO::FETCH_ASSOC);
        
         $sql2="select * from lista";
        $res2= $this->db->query($sql2);
        $sviPodaci=$res2->fetchAll(PDO::FETCH_ASSOC);
        $sve=[];
       
           
             foreach ($sviPodaci as $podatak) {
                 
                   $noviKorisnik['ime']=$podatak['ime'];
                    $noviKorisnik['prezime']=$podatak['prezime'];
                     $noviKorisnik['brojIndeksa']=$podatak['brojIndeksa'];
                     $noviKorisnik['godinaUpisa']=$podatak['godinaUpisa'];
                foreach ($sviKorisnici as $korisnik) {
                    if($korisnik['ime']==$noviKorisnik['ime'] && $korisnik['prezime']==$noviKorisnik['prezime'] && $korisnik['brojIndeksa']==$noviKorisnik['brojIndeksa'] && $korisnik['godinaUpisa']==$noviKorisnik['godinaUpisa'])
                        $noviKorisnik['brojIndeksa']=$korisnik['brojIndeksa'];
                     $noviKorisnik['godinaUpisa']=$korisnik['godinaUpisa'];
                     
                     $noviKorisnik['nazivPredmeta']=$podatak['nazivPredmeta'];
                     $noviKorisnik['ocena']=$podatak['ocena'];
                     
              }
            
            if(isset($ime) && isset($prezime)){
                if($ime==$noviKorisnik['ime'] && $prezime==$noviKorisnik['prezime']){
                    return $noviKorisnik;
                }
            }
            $sve[]=$noviKorisnik;
        }
        if(!$sve){
            return FALSE;
        }
        else{
            return $sve;
        }

    }
    
    
     public function  izbrisi($id){
        
        $sql="delete from korisnik1 where id=$id";
        $res= $this->db->exec($sql);
        if(!$res){
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    
    public function dodajKorisnika($ime,$prezime,$brojIndeksa,$godinaUpisa){
        $sql="insert into korisnik1(ime,prezime,brojIndeksa,godinaUpisa,uloga)values('$ime','$prezime',$brojIndeksa,$godinaUpisa,'user')";
        $res= $this->db->exec($sql);
        return $res;
    }
    
    
     public function dodajPredmet($ime,$prezime,$brojIndeksa,$godinaUpisa,$predmet,$ocena){
        $sql="insert into lista(ime,prezime,brojIndeksa,godinaUpisa,nazivPredmeta,ocena)values('$ime','$prezime',$brojIndeksa,$godinaUpisa,'$predmet',$ocena)";
        $res= $this->db->exec($sql);
        return $res;
    }
   
}
?>