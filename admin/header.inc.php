<?php
$temps_debut=microtime();
session_start();
if (!isset($_SESSION["id_doc"]) || !isset($_SESSION["mdp_doc"])) {
    header ("Location: ../index.php?msg_erreur=2");
    exit();
} else {
    $id_doc = $_SESSION["id_doc"];
    $mdp_doc = $_SESSION["mdp_doc"];
    require_once "../config.inc.php";
    $infos_doc = mysql_query("select id from $table_docteurs where id=\"$id_doc\" AND mdp=\"$mdp_doc\" AND activation=\"Y\" AND statut=\"docteur\"");
    if (mysql_num_rows($infos_doc) != 1) {
        echo "<p class=\"erreur\" align=\"center\">Vos identifiants d'accès sont invalides. Veuillez réessayer.</p>";
        exit();
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>ADMIN CyrixMED / <?=$titre_page?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="style.css" rel="stylesheet" type="text/css">
<script language="Javascript">
function confirmation(url)
{
if(confirm('Voulez-vous vraiment supprimer ?'))
document.location.href=url
}
</script>
<?php
if (isset($insertIntoHead)) {
	echo $insertIntoHead;
}
?>
</head>
<body bgcolor="white">
<div style="margin:20px;"><img src="design/admin.jpg"></div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tr>
<td valign="top" width="250" style="border-right:1px #545454 dotted;padding:20px">
<br />
	<table border="0" cellspacing="1" class="adminTable">
		<tr><td>CONFIGURATION</td></tr>
		<tr><td class="adminHeader">Utilisateurs</td></tr>
		<tr><td class="adminTD">
		<a href="docteurs.php?table=docteurs">Liste des utilisateurs (docteurs + secrétaires)</a><br />
		<a href="docteurs.php?table=docteurs&q=Ajouter">Ajouter un utilisateur</a>
		</td></tr>
	</table>
	<br />
	<table border="0" cellspacing="1" class="adminTable">
		<tr><td>LISTES</td></tr>
		<tr><td class="adminHeader">ATCD Médicaux</td></tr>
		<tr><td class="adminTD">
		<a href="listes.php?liste=atcd_medicaux">Voir la liste</a><br />
		<a href="listes.php?liste=atcd_medicaux&q=Ajouter">Ajouter une entrée</a>
		</td></tr>
		<tr><td class="adminHeader">Correspondants</td></tr>
		<tr><td class="adminTD">
		<a href="listes.php?liste=correspondants">Voir la liste</a><br />
		<a href="listes.php?liste=correspondants&q=Ajouter">Ajouter une entrée</a>
		</td></tr>
		<tr><td class="adminHeader">Médicaments</td></tr>
		<tr><td class="adminTD">
		<a href="listes.php?liste=medicaments">Voir la liste</a><br />
		<a href="listes.php?liste=medicaments&q=Ajouter">Ajouter une entrée</a>
		</td></tr>
		<tr><td class="adminHeader">Signes cliniques</td></tr>
		<tr><td class="adminTD">
		<a href="listes.php?liste=signes_cliniques">Voir la liste</a><br />
		<a href="listes.php?liste=signes_cliniques&q=Ajouter">Ajouter une entrée</a>
		</td></tr>
		<tr><td class="adminHeader">Surveillance</td></tr>
		<tr><td class="adminTD">
		<a href="listes.php?liste=surveillance">Voir la liste</a><br />
		<a href="listes.php?liste=surveillance&q=Ajouter">Ajouter une entrée</a>
		</td></tr>
		<tr><td class="adminHeader">Traitements locaux</td></tr>
		<tr><td class="adminTD">
		<a href="listes.php?liste=traitements_locaux">Voir la liste</a><br />
		<a href="listes.php?liste=traitements_locaux&q=Ajouter">Ajouter une entrée</a>
		</td></tr>
		<tr><td class="adminHeader">Trucs</td></tr>
		<tr><td class="adminTD">
		<a href="listes.php?liste=trucs">Voir la liste</a><br />
		<a href="listes.php?liste=trucs&q=Ajouter">Ajouter une entrée</a>
		</td></tr>
		<tr><td class="adminHeader">Vaccins</td></tr>
		<tr><td class="adminTD">
		<a href="listes.php?liste=vaccins">Voir la liste</a><br />
		<a href="listes.php?liste=vaccins&q=Ajouter">Ajouter une entrée</a>
		</td></tr>
	</table>
	<br />

</td>
<td valign="top">
<br>
	<table border="0" style="margin:20px;">
		<tr><td valign="top">