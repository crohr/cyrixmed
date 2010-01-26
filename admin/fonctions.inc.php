<?php
function Ajouter($table, $query) {
$insert=mysql_query("insert into $table set $query");
if ($insert==TRUE) {
echo "Les données ont été correctement ajoutées<br><br>";
}
else {
echo "Erreur lors de l'ajout des données<br><br>";
}
}
function Modifier($table, $query, $where) {
$update=mysql_query("update $table set $query where $where");
if ($update==TRUE) {
echo "Les données ont été correctement modifiées<br><br>";
}
else {
echo "Erreur lors de la modification des données<br><br>";
}
}
function Supprimer($table, $where) {
$delete=mysql_query("delete from $table where $where");
if ($delete==TRUE) {
echo "Les données ont été correctement effacées<br><br>";
}
else {
echo "Erreur lors de la suppression des données<br><br>";
}
}

function DateFR($date) {
$date_fr = substr("$date",8,2).substr("$date",4,4).substr("$date",0,4);
return $date_fr;
}
function JourDateFR($date) {
$jour = substr("$date",0,2);
return $jour;
}
function ecart_jours($date) {
$jour = substr($date,8,2);
$mois = substr($date,5,2);
$annee = substr($date,0,4);
$timestamp = mktime(0,0,0,$mois,$jour,$annee);
$maintenant = time();
$ecart_secondes = $maintenant - $timestamp; 
$ecart_jours = ceil($ecart_secondes / (60*60*24));
return $ecart_jours;
}
function EcartJours($date1,$date2) {
$jour1 = substr($date1,8,2);
$mois1 = substr($date1,5,2);
$annee1 = substr($date1,0,4);
$timestamp1 = mktime(0,0,0,$mois1,$jour1,$annee1);
$jour2 = substr($date2,8,2);
$mois2 = substr($date2,5,2);
$annee2 = substr($date2,0,4);
$timestamp2 = mktime(0,0,0,$mois2,$jour2,$annee2);
$ecart_secondes = $timestamp2 - $timestamp1; 
$ecart_jours = ceil($ecart_secondes / (60*60*24));
return $ecart_jours;
}
/*
function titre_partie($titre)
{
$titre=strtoupper($titre);
echo "<p class=\"titre_partie\" align=\"center\"><u>$titre</u></p>\n";
}
function titre_souspartie($titre)
{
echo "&raquo; <b><font color=\"#D06467\">$titre</font></b><br>\n";
}
*/
function SousTitre($sous_titre) {
global $url_relative;
	echo "<div class=\"sous_titre\">&raquo; $sous_titre<br>
	<img src=\"".$url_relative."design/sous_titre.gif\"></div>\n";
}
function Titre($titre) {
global $url_relative;
	echo "<p align=\"center\" class=\"titre\">
	<img src=\"".$url_relative."design/titre.gif\" width=\"10\" height=\"10\">&nbsp;
	$titre
	</p>";
}
function Tableau($titre,$contenu,$largeur,$alignement) {
	echo "<table border=\"0\" width=\"$largeur\" align=\"$alignement\" cellpadding=1 cellspacing=0 bgcolor=\"#DDDEE7\">
			<tr>
				<td>$titre</td>
			</tr>
			<tr>
				<td>
				<table border=\"0\" width=\"100%\" bgcolor=\"white\">
					<tr>
						<td>$contenu</td>
					</tr>
				</table>
				</td>
			</tr>
		</table>";
}
?>