<?php
// ----------------- CONNEXION MYSQL ------------------
$serveur='localhost';
$user='root';
$password='';
$base='cyrixmedv14';

//// Mettez ici l'entête principale de votre cabinet :
$entete_cabinet="<p align=\"center\"><font size=\"3\"><b>CABINET DE MEDECINE GENERALE</b></font><br>
<font size=\"2\">3 Quai Yves Barbier - 70000 VESOUL - Tél. : 03 84 76 14 55</font></p>";

///////////////////// NE PAS MODIFIER CI-DESSOUS /////////////////////////
$connexion = mysql_connect("$serveur","$user","$password") or die ("Impossible de se connecter à la base de données");
mysql_select_db("$base",$connexion);
// ---------------------- TABLES ----------------------------
$table_patients="idoc_infospatients";
$table_docteurs="idoc_docteurs";
$table_planning="idoc_planning";

// Date du jour
$DateJourEN=date("Y-m-d");
$DateJourFR=date("d-m-Y");

$nom_log="CyrixMed v1.4.1";
$email_admin="webmaster@web-creation-fr.com";
?>
