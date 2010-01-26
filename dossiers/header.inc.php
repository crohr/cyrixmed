<?php
session_start();
$temps_debut = microtime();
if (!isset($_SESSION["id_doc"]) || !isset($_SESSION["mdp_doc"]))  {
    header ("Location: ../index.php");
    exit();
} else {
    $idp = $_SESSION["idp"];
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

?>
<html>
<head>
<title><?=$titre_page?> - <?=$nom_log?> - <?=$id_doc?></title>

<link href="../style.css" rel="stylesheet" type="text/css">
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
</script>

<script language="javascript">
function popup(liste)
// on ouvre dans une fenêtre le fichier passé en paramètre.
// cette ouverture peut être améliorée en passant comme
// autres paramètres la taille et la position de la fenêtre
{ 
wchoix=window.open(liste,"Liste","top=0, left=0, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0");

}
</script>

<script language="javascript">
function popupcentree(page,largeur,hauteur,options)
{
window.open(page,"","top="+top+",left="+left+",width="+largeur+",height="+hauteur+","+options);
var top=(screen.height-hauteur)/2;
var left=(screen.width-largeur)/2;
}
function popup_infos(url) {
var hauteur=250;
var largeur=500;
var top=(screen.height-hauteur)/2;
var left=(screen.width-largeur)/2;
fen = window.open (""+url+"","popup","top="+top+", left="+left+", toolbar=0, location=0, directories=0, status=1, scrollbars=1, resizable=1, copyhistory=0, menuBar=0, width="+largeur+", height="+hauteur+"");
if (self.focus) {
fen.focus();
}
}
</script>
</head>
<body bgcolor="white" LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0>
