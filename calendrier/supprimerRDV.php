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
        if (isset($_GET["id"])) {
	        $date=(isset($_GET["date"]))?$_GET["date"]:"";
	        $calendrier=(isset($_GET["calendrier"]))?$_GET["calendrier"]:"journalier";
	        $delete=mysql_query('delete from '.$table_planning.' where id="'.$_GET['id'].'"');
	        if ($delete==TRUE) {
		        header("location:../index.php?date=".$date."&calendrier=".$calendrier."");
		        exit();
	        } else {
		        echo "erreur lors de la suppression";
	        }
        } else {
	        echo "pas d'ID indiquée !";
        }
    } 
} 


?>