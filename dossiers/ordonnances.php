<?php
session_start();
if (!isset($_SESSION["id_doc"]) || !isset($_SESSION["mdp_doc"]) || !isset($_SESSION["idp"])) {
    header ("Location: ../index.php");
    exit();
} else {
    $idp = $_SESSION["idp"];
    $id_doc = $_SESSION["id_doc"];
    $mdp_doc = $_SESSION["mdp_doc"];
    require_once "../config.inc.php";
    $infos_doc = mysql_query("select * from $table_docteurs where id=\"$id_doc\" AND mdp=\"$mdp_doc\" AND activation=\"Y\"");
    if (mysql_num_rows($infos_doc) != 1) {
        echo "<p class=\"erreur\" align=\"center\">Vos identifiants d'accès sont invalides. Veuillez réessayer.</p>";
        exit();
    } else {
        require_once "../fonctions.inc.php";

        $res_doc = mysql_fetch_array($infos_doc);
        // Sélection infos patient
        $select_patient = mysql_query("select nom, nom_jf, prenom, titre, date_naissance from $table_patients where id=\"$idp\"");
        $res_patient = mysql_fetch_array($select_patient);

        $age = calcul_age(DateFR($res_patient["date_naissance"]));
        $medicaments = nl2br($res_doc["sauv_medic"]);
        $medicaments_ald = nl2br($res_doc["sauv_medicald"]);
		if (isset($_GET["type"])) { $type=$_GET["type"]; } elseif(isset($_POST["type"])) { $type=$_POST["type"]; } else { $type=""; }

        ?>
<html>
<head>
<title>Ordonnance - <?=$nom_log?></title>
<link href="../style.css" rel="stylesheet" type="text/css">
<SCRIPT LANGUAGE="JavaScript">
<!--
function printit() {
window.print() ;
}
// -->
</SCRIPT>
</head>

<body<?php
        if (isset($_GET["duplicata"]) && $_GET["duplicata"]== "oui") {
            echo " background=\"duplicata.jpg\" onLoad=\"printit();\"";
        } 
        echo ">";

        ?>
<table width="650" border="0" cellspacing="0" align="center">
	<tr>
		<td colspan="2" align="center">		
		<?=$entete_cabinet?>
		</td>
	</tr>
	<tr valign="top">
		<td width="400" align="center"><br>
		<?=$res_doc["entete"]?>
		</td>
		<td width="250" align="center">
		<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="black">
			<tr valign="top">
				<td bgcolor="white">
				<font size="2"><br>
				<?php
        $select_docs = mysql_query("select id, nom, prenom from $table_docteurs where activation=\"Y\" AND statut=\"docteur\" AND id!=\"$id_doc\" order by nom ASC");
        while ($res = mysql_fetch_array($select_docs)) {
               echo "- Docteur ".$res["prenom"]." ".$res["nom"]."<br>";
        } 

        ?>
				</font>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right"><br><br><b><font size="2"><?php
        echo "$DateJourFR";

        ?></font></b></td>
		
	</tr>
	<tr>
		<td colspan="2" align="right"><font size="2"><b>
		<?php
        echo "<br>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		".$res_patient["titre"]." ";
        if (!$res_patient["nom"]) {
            echo $res_patient["nom_jf"];
        } else {
            echo $res_patient["nom"];
        } 
        echo " ".$res_patient["prenom"]."";
        if ($age < 18) {
            echo "&nbsp;&nbsp;&nbsp;$age ans";
        } 

        ?></b></font></td>
	</tr>
</table>
<br/>
<table width="650" border="0" align="center">
<?php 
        // Si ordonnance ALD
        if ($type == "ald") {

            ?>
	<tr>
		<td align="center">
		<hr size="1" width="100%" color="black">
		<b>Prescriptions relatives au traitement de l'affection de longue durée reconnue (liste ou hors liste)<br>
(AFFECTION EXONERANTE)</b>
		<hr size="1" width="100%" color="black">
		</td>
	</tr>
	<tr>
		<td height="200" valign="top">
		<font size="2">
		<?=$medicaments_ald?>
		</font>
		<br/><br/>
		</td>
	</tr>
	<tr>
		<td align="center">
		<hr size="1" width="100%" color="black">
		<b>Prescriptions SANS RAPPORT avec l'affection de longue durée<br>
(MALADIES INTERCURRENTES)</b>
		<hr size="1" width="100%" color="black">
		</td>
	</tr>
	<tr>
		<td height="200" valign="top">
		<font size="2">
		<?=$medicaments?>
		</font>
		</td>
	</tr>
<?php
        } 
        // Si ordonnance normale
        else {

            ?>
	<tr>
		<td height="200" valign="top">
		<font size="2">
		<?=$medicaments?>
		</font>
		<br/><br/>
		</td>
	</tr>
<?php
        } 

        ?>
</table>
</body>
</head>
</html>

<?php
    } 
} 

?>