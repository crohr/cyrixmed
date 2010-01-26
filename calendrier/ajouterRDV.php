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
	case "ajouterRDV":
	
		$month1 		= substr($_POST["dateRDV"], 3 ,2);
		$day1 		= substr($_POST["dateRDV"], 0, 2);
		$year1		= substr($_POST["dateRDV"], 6 ,4);
		$dateRDV="".$year1."-".$month1."-".$day1." ".$_POST["heureRDV"].":".$_POST["minuteRDV"]."";
		$commentaires=isset($_POST["commentaires"])?$_POST["commentaires"]:"";
		if ($_SESSION["statut"]=="secretaire") {
			$idDocteur=$_POST["docteur"];
		} else {
			$idDocteur=$id_doc;
		}
		$insert=mysql_query("insert into $table_planning set idDocteur='$idDocteur', idPatient='".$_POST["idPatient"]."', dateDebut='$dateRDV', dateFin='$dateRDV', commentaires='".$commentaires."'");
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
	?>
	<html>
	<head>
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
		var f = document.ajouterRDV;	
		if(f.dateRDV.value=="") {
			alert("Veuillez indiquer la date du RDV !");
			f.date1.focus();
			return false;
		}
		if(f.idPatient.value=="") {
			alert("Veuillez choisir le patient concerné !");
			f.date2.focus();
			return false;
		}
		else { 
			f.submit();
		}
	}
	function nouveauPatient(url) {
		var fen = window.open(""+url+"","nouveauPatient","top=0, left=0, toolbar=0, location=0, directories=0, status=1, scrollbars=1, resizable=1, copyhistory=0, menuBar=0, width=800, height=600");
		if (self.focus) {
			fen.focus();
		}
	}
	</script>
	<?php
	require_once 'calendrier.php';
	
	if ($dateRDV==0) { 
		echo '<title>Erreur : date RDV indéfinie</title>'; 
	}
	else { 		
		$month 		= substr($dateRDV, 4 ,2);
		$day 		= substr($dateRDV, 6, 2);
		$year		= substr($dateRDV, 0 ,4);
		$timestamp 	= mktime(0, 0, 0, $month, $day, $year);
		$numeroJour=date("w",$timestamp)-1;// tient compte du fait que le 1er jour des anglais est le dimanche et non le lundi
		$numeroMois=date("n",$timestamp);
		echo '<title>Ajouter un RDV pour le '.$calendar_txt['french']['days'][$numeroJour].' '.$day.' '.$calendar_txt['french']['monthes'][$numeroMois].' '.$year.'</title>'; 
	}
	?>
	<style type="text/css">
		.header { background-color: #A9B4B3; font-family:Verdana, Arial, Helvetica; font-size:12px; font-weight:bold;color:white;}
		TD { background-color: #FFFFFF;  font-family:Verdana, Arial, Helvetica; font-size:10px;}
		TABLE {  background-color: #3f6551; border: 1px #3f6551 solid}
		SELECT {font-family:Verdana, Arial, Helvetica; font-size:10px;}
		INPUT {font-family:Verdana, Arial, Helvetica; font-size:10px;}
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
	</head>
	<body bgcolor="white">
	
	<script language="javascript" src="calendrierJavascript.js">
	</script>
	<script language="Javascript" src="../choix_patient.js"></script>
	<form name="ajouterRDV" action="<?=$_SERVER["PHP_SELF"]?>?q=ajouterRDV" method="post">
	<table class="calendarTable" cellpadding="2" cellspacing="1">
		<?php
		if ($_SESSION["statut"]=="secretaire") {
		?>
		<tr><td class="header">Docteur concerné :</td></tr>
		<tr><td><select name="docteur">
		<?php
		$selectDocteurs=mysql_query("select id, nom, prenom, couleur from $table_docteurs where activation=\"Y\" AND statut=\"docteur\" order by nom ASC");
		if (mysql_num_rows($selectDocteurs)<=0) {
			echo "Erreur : aucun docteur n'est activé pour recevoir des RDV. Vérifiez les utilisateurs autorisés à accéder à CyrixMED";
			exit();
		} else {
			while ($resDocteurs=mysql_fetch_array($selectDocteurs)) {
				echo '<option value="'.$resDocteurs['id'].'" style="background-color:'.$resDocteurs['couleur'].';">'.$resDocteurs['nom'].' '.$resDocteurs['prenom'].'</option>';
			}
		}
		echo '</td></tr>';
		}
		?>
		<tr><td class="header">Date du RDV :</td></tr>
		<tr><td><input type="text" name="dateRDV" size="12" value="<?=$day?>-<?=$month?>-<?=$year?>">
		<a href="javascript:calendrier('calendrier','dateRDV','<?=$day?>','<?=($month-1)?>','<?=$year?>');"><img src="../design/calendar.gif" border="0" /></a>
		<div id="calendrier">
		</div>
		</td></tr>
		<tr><td class="header">Heure :</td></tr>
		<tr><td><input type="text" name="heureRDV" size="2" onclick="this.value='';" onkeypress="Compter(this,forms[0].minuteRDV)">:<input type="text" name="minuteRDV" size="2"></td></tr>
		<tr><td class="header">Patient concerné :</td></tr>
		<tr><td>
		<a href="javascript:nouveauPatient('../dossiers/ajouter.php?provenance=ajouterRDV');">Nouveau patient</a><br />
		ou :<br />
		Entrez les premières lettres... :<br />
		<input type="text" name="entree" size="20" onKeyUp="javascript:lettre.maj();">	
		<br />
		...puis/ou sélectionnez le patient dans la liste ci-dessous :<br>
		<select name="idPatient" size="20" style="width:350px;">
		<?php
		$select_patients = mysql_query("select id, nom, nom_jf, prenom from $table_patients order by nom ASC");
		if (mysql_num_rows($select_patients) > 0) {
			while ($res = mysql_fetch_array($select_patients)) {
				echo "<option value=\"".$res["id"]."\">";
				if (!$res["nom"]) {
					echo $res["nom_jf"];
				} else {
					echo $res["nom"];
				} 
				echo " ".$res["prenom"]."</option>\n";
			} 
		} 
								
		?>
		</select>	
		</td></tr>
		<tr><td class="header">Commentaires :</td></tr>
		<tr><td><textarea name="commentaires" cols="41" rows="4"></textarea></td></tr>
		<tr><td><input type="button" value="Enregistrer le RDV" onclick="verifierFormulaire();"></td></tr>
	</table>
	
	<script language="javascript">
	lettre = new NomObjets('ajouterRDV','idPatient','entree');
	lettre.bldInitial(); 
	ajouterRDV.heureRDV.focus();
	</script>
	<?php
	break;
}
?>
</body>
</html>
