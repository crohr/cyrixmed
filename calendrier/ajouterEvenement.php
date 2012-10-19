<?php
session_start();
$temps_debut = microtime();
if (!isset($_SESSION["id_doc"]) || !isset($_SESSION["mdp_doc"])) {
    header ("Location: ../index.php");
    exit();
} else {
    $id_doc = $_SESSION["id_doc"];
    $mdp_doc = $_SESSION["mdp_doc"];
    require_once "../config.inc.php";
    $infos_doc = mysql_query("select id from $table_docteurs where id=\"$id_doc\" AND mdp=\"$mdp_doc\" AND activation=\"Y\"");
    if (mysql_num_rows($infos_doc) != 1) {
        echo "<p class=\"erreur\" align=\"center\">Vos identifiants d'accès sont invalides. Veuillez réessayer.</p>";
        exit();
    } else {
        require_once "../fonctions.inc.php";
    } 
} 

$q=(isset($_GET["q"])) ? $_GET["q"] : "";
switch($q) {
	case "ajouterEvenement":
	
		$month1 		= substr($_POST["date1"], 3 ,2);
		$day1 		= substr($_POST["date1"], 0, 2);
		$year1		= substr($_POST["date1"], 6 ,4);
		$date1="".$year1."-".$month1."-".$day1."";
		$month2 		= substr($_POST["date2"], 3 ,2);
		$day2		= substr($_POST["date2"], 0, 2);
		$year2		= substr($_POST["date2"], 6 ,4);
		$date2="".$year2."-".$month2."-".$day2."";
		$dateDebut="$date1 ".$_POST["heure1"].":".$_POST["minute1"]."";
		$dateFin="$date2 ".$_POST["heure2"].":".$_POST["minute2"]."";
		$insert=mysql_query("insert into $table_planning set idDocteur='$id_doc', dateDebut='$dateDebut', dateFin='$dateFin', commentaires='".$_POST["commentaires"]."'");
		if ($insert==TRUE) {
			echo 'insertion OK. Actualisation en cours...
			<script language="javascript">
			opener.location.reload();
			this.close();
			</script>';
		} else {
			echo 'Erreur lors de l\'insertion des données !';
		}
	break;
	
	default:
	
	$dateRDV=(isset($_GET["date"])) ? $_GET["date"] : "0";
	//require_once 'calendrier.php';
	?>
	<html>
	<head>
	<title>Enregistrer un événement sur le planning</title>
	<script language="javascript">
	<!--
	// Script de comptage de caractères pour champs de date
	function Compter(champ1, champ2) {
	var max = 2;
	StrLen = champ1.value.length
	if (StrLen >= max) {
	champ1.value = champ1.value.substring(0,max);
	champ2.value="";
	champ2.focus();					
	}
	}
	//-->
	function verifierFormulaire(){
		var f = document.ajouterEvenement;	
		if(f.date1.value=="") {
			alert("Veuillez indiquer la date de début de l'événement !");
			f.date1.focus();
			return false;
		}
		if(f.date2.value=="") {
			alert("Veuillez indiquer la date de fin de l'événement !");
			f.date2.focus();
			return false;
		}
		if(f.commentaires.value=="") {
			alert("Veuillez indiquer la nature de l'événement");
			f.commentaires.focus();
			return false;
		}
		else { 
			f.submit();
		}
	}
	</script>
	
	
	<style type="text/css">
		.header { background-color: #A9B4B3; font-family:Verdana, Arial, Helvetica; font-size:12px; font-weight:bold;color:white;}
		.formulaireTD { background-color: #FFFFFF;  font-family:Verdana, Arial, Helvetica; font-size:10px;}
		.formulaireTable {  background-color: #3f6551; border: 1px #3f6551 solid}
		SELECT {font-family:Verdana, Arial, Helvetica; font-size:10px;}
		INPUT {font-family:Verdana, Arial, Helvetica; font-size:10px;}
		//#calendrier1 {background-color:#DBD7D7;visibility:hidden;}
		TD {font-family: Verdana, Arial, Helvetica; font-size: 10px;}
		.calendrierTable{
			color:white;border:0;padding:2;border-spacing:1;
		}
		.calendrierHeader {
			background-color:#A9B4B3;font-family: Verdana, Arial, Helvetica; font-size: 11px; font-weight:bold;color:black;
		}
		.calendrierTD {
			background-color:white;
		}
		.calendrierTH {
			background-color:#A9B4B3;
		}
		
	</style>
	
<script language="javascript" src="calendrierJavascript.js">
</script>
	</head>
	<body bgcolor="white">
	<?php
		$jour=date("d");
		$mois=date("m");
		$annee=date("Y");
	?>
	<form name="ajouterEvenement" action="<?=$_SERVER["PHP_SELF"]?>?q=ajouterEvenement" method="post">
	<table class="formulaireTable" cellpadding="2" cellspacing="1">
		<tr><td class="header">Date de début :</td></tr>
		<tr><td class="formulaireTD">
		<input type="text" id="date1" name="date1" size="12" value="<?=$jour?>-<?=$mois?>-<?=$annee?>">
		<a href="javascript:calendrier('calendrier1','date1','<?=$jour?>','<?=($mois-1)?>','<?=$annee?>');"><img src="../design/calendar.gif" border="0" /></a> à <input type="text" name="heure1" size="2" onclick="this.value='';" onkeypress="Compter(this,forms[0].minute1)">:<input type="text" name="minute1" size="2">
		<div id="calendrier1">
		</div>
		</td></tr>
		<tr><td class="header">Date de Fin :</td></tr>
		<tr><td class="formulaireTD">
		<input type="text" id="date2" name="date2" size="12" value="">
		<a href="javascript:calendrier('calendrier2','date2','<?=$jour?>','<?=($mois-1)?>','<?=$annee?>');"><img src="../design/calendar.gif" border="0" /></a> à <input type="text" name="heure2" size="2" onclick="this.value='';" onkeypress="Compter(this,forms[0].minute2)">:<input type="text" name="minute2" size="2">
		<div id="calendrier2">
		</div>
		</td></tr>
		<tr><td class="header">Commentaires :</td></tr>
		<tr><td class="formulaireTD"><textarea name="commentaires" cols="41" rows="5"></textarea></td></tr>
		<tr><td class="formulaireTD"><input type="button" value="Enregistrer l'événement" onclick="javascript:verifierFormulaire()"></td></tr>
	</table>
	
	<?php
	break;
}
?>
</body>
</html>
