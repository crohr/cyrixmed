<?php
$titre_page="Administration des listes";
$url_relative="";
include_once "../config.inc.php";
include_once "fonctions.inc.php";
include_once "header.inc.php";

if (isset($_GET["q"])) { $q=$_GET["q"]; } elseif(isset($_POST["q"])) { $q=$_POST["q"]; } else { $q=""; }
if (isset($_GET["sq"])) { $sq=$_GET["sq"]; } elseif(isset($_POST["sq"])) { $sq=$_POST["sq"]; } else { $sq=""; }

	// Champs des listes
	$champs=array(
		"atcd_medicaux"=>array("atcd","precisions"),
		"correspondants"=>array("specialite","nom","adresse","tel"),
		"medicaments"=>array("nom","posologie","indications"),
		"signes_cliniques"=>array("nom","commentaire"),
		"surveillance"=>array("examen","commentaire"),
		"traitements_locaux"=>array("nom","posologie","indications"),
		"trucs"=>array("truc","explication"),
		"vaccins"=>array("nom","quantite","renseignements")
	);

if (!isset($_GET["liste"])) {
	echo "<p class=\"erreur\">Erreur ! La page n'a pas été appelée avec les bons paramètres.</p>";
} else {
	$liste=$_GET["liste"];
	$table_liste="idoc_liste_"."$liste"."";
			
	switch($q) {
		case "Ajouter";
			$nb_champs=sizeof($champs["$liste"]);
			if ($sq=="Valider") {
				$valeurs="";
				$i=0;	
				while($i<$nb_champs) {
					$nom_champ=$champs["$liste"]["$i"];	
					if ($i!=0) {
						$valeurs.=" ,";
					}
					$valeurs.="$nom_champ=\"".$_POST["$nom_champ"]."\"";				
				$i++;
				}
				Ajouter("$table_liste",$valeurs);
				?>				
				<script language="Javascript">
				window.location="<? echo "".$_SERVER["PHP_SELF"]."?liste=$liste&msg=1"; ?>";
				</script>
				<?php
			} else {
				echo "
				<form action=\"".$_SERVER["PHP_SELF"]."?liste=$liste&q=Ajouter&sq=Valider\" method=\"post\">
				<table border=\"0\" cellspacing=\"1\" class=\"adminTable\" style=\"width:350px;\">
					<tr><td>Ajout d'une entrée dans la liste \"$liste\"</td></tr>";
				$i=0;	
				while($i<$nb_champs) {
					$nom_champ=$champs["$liste"]["$i"];
					$nom_champ_maj=strtoupper($nom_champ);
					echo "
					<tr>
						<td class=\"adminHeader\">$nom_champ_maj</td>
					</tr>
					<tr>
						<td class=\"adminTD\"><textarea name=\"$nom_champ\" cols=\"40\" rows=\"3\"></textarea></td>
					</tr>";
					$i++;
				}
				echo "
				<tr valign=\"top\">
					<td colspan=\"2\" align=\"center\" class=\"adminHeader\"><input type=\"submit\" value=\"Valider\"></td>
				</tr>
				</table>
				</form>";
			}
		break;
		
		case "Modifier";
			$nb_champs=sizeof($champs[$liste]);
			$id=$_GET["id"];			
			if ($sq=="Valider") {
				$valeurs="";
				$i=0;	
				while($i<$nb_champs) {
					$nom_champ=$champs["$liste"]["$i"];	
					if ($i!=0) {
						$valeurs.=" ,";
					}
					$valeurs.="$nom_champ=\"".$_POST["$nom_champ"]."\"";				
				$i++;
				}
				Modifier("$table_liste",$valeurs,"id=\"$id\"");
				?>				
				<script language="Javascript">
				window.location="<? echo "".$_SERVER["PHP_SELF"]."?liste=$liste&msg=2"; ?>";
				</script>
				<?php
			} else {
			
			$select=mysql_query("select * from $table_liste where id=\"$id\"");
			$res=mysql_fetch_array($select);
			echo "
			<form action=\"".$_SERVER["PHP_SELF"]."?liste=$liste&q=Modifier&sq=Valider&id=$id\" method=\"post\">
			<table border=\"0\" cellspacing=\"1\" class=\"adminTable\" style=\"width:350px;\">
				<tr><td>Modification d'une entrée de la liste \"$liste\"</td></tr>";
			$i=0;	
			while($i<$nb_champs) {
				$nom_champ=$champs["$liste"]["$i"];
				$nom_champ_maj=strtoupper($nom_champ);
				echo "
				<tr>
					<td class=\"adminHeader\">$nom_champ_maj</td>
				</tr>
				<tr>
					<td class=\"adminTD\"><textarea name=\"$nom_champ\" cols=\"40\" rows=\"3\">".$res["$nom_champ"]."</textarea></td>
				</tr>";
				$i++;
			}
			echo "
			<tr valign=\"top\">
				<td colspan=\"2\" align=\"center\" class=\"adminHeader\"><input type=\"submit\" value=\"Valider\"></td>
			</tr>
			</table>
			</form>";
			
			}
		break;
		
		case "Supprimer";
		SousTitre("Suppression d'une entrée de la liste \"$liste\"");
		Supprimer("$table_liste","id=\"$_GET[id]\"");
		?>				
		<script language="Javascript">
		window.location="<? echo "".$_SERVER["PHP_SELF"]."?liste=$liste&msg=3"; ?>";
		</script>
		<?php
		break;
	
		
		default:
		$ordre=$champs["$liste"]["0"];
		$select=mysql_query("select * from $table_liste order by $ordre ASC");
		$nb_enregistrements=mysql_num_rows($select);
		$tab_msg=array(
						"1"=>"Les données ont été correctement ajoutées !",
						"2"=>"Les données ont été correctement modifiées !",
						"3"=>"Suppression de l'enregistrement effectué !");
		if (isset($_GET["msg"])) {
			echo "<p class=\"erreur\">".$tab_msg[$_GET["msg"]]."</p>";
		}
		?>
		<table border="0" class="adminTable" cellspacing="1">
			<tr><td colspan="<?=(sizeof($champs[$liste])+1)?>">Enregistrements de la liste <?=$liste?> :</td></tr>
			<tr align="center"><td class="adminHeader">ACTIONS</td>
			<?php	
			$nb_champs=sizeof($champs["$liste"]);
			while(list($k,$nom_champ)=each($champs["$liste"])) {
				$nom_champ_maj=strtoupper($nom_champ);
				echo "<td class=\"adminHeader\">$nom_champ_maj</td>"; 
			}
			?>
			</tr>
		<?php
		while ($res=mysql_fetch_array($select)) {
			echo "<tr><td class=\"adminTD\">[<a href=\"".$_SERVER["PHP_SELF"]."?liste=$liste&q=Modifier&id=$res[id]\">M</a>] - [<a href=\"javascript:confirmation('".$_SERVER["PHP_SELF"]."?liste=$liste&q=Supprimer&id=$res[id]');\">S</a>]</td>";
			$i=0;	
			while($i<$nb_champs) {
				$nom_champ=$champs["$liste"]["$i"];
				echo "<td class=\"adminTD\">".$res["$nom_champ"]."</td>"; 
				$i++;
			}
			echo "</tr>";
		}		
		?>
		</table>
		(<?=$nb_enregistrements?> enregistrements)
		<?php
		break;
	}
}
include_once "footer.inc.php";
?>