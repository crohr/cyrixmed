<?php
$titre_page="Administration des listes";
$url_relative="";
include_once "../config.inc.php";
include_once "fonctions.inc.php";
include_once "header.inc.php";
if (isset($_GET["q"])) { $q=$_GET["q"]; } elseif(isset($_POST["q"])) { $q=$_POST["q"]; } else { $q=""; }
if (isset($_GET["sq"])) { $sq=$_GET["sq"]; } elseif(isset($_POST["sq"])) { $sq=$_POST["sq"]; } else { $sq=""; }
?>
<table cellspacing="1" class="adminTable">
	<tr><td>CyrixMED : ADMINISTRATION</td></tr>
	<tr><td class="adminHeader">Bienvenue !</td></tr>
	<tr><td class="adminTD">Bienvenue dans l'espace d'administration de CyrixMED. A partir d'ici vous allez pouvoir gérer un tant soit peu le fonctionnement du logiciel
	en utilisant le menu de gauche.</td></tr>
</table>
<?php
include_once "footer.inc.php";
?>