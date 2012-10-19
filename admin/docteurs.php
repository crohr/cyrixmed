<?php
$titre_page="Administration des docteurs";
$url_relative="";
include_once "../config.inc.php";
include_once "fonctions.inc.php";
$insertIntoHead='
<script type="text/javascript">
  _editor_url = "./editeur";
  _editor_lang = "fr";
</script>
<script type="text/javascript" src="./editeur/htmlarea.js"></script>
<script type="text/javascript">
var editor = null;
function initEditor() {
  editor = new HTMLArea("entete");
  editor.generate();
  return false;
}
</script>';
include_once "header.inc.php";
$tabCouleurs=array("#F5BDBD","#FFE361","#B6ECB6","#F8F97F","#CBB795","#FFFF80","#FF4040");
if (isset($_GET["q"])) { $q=$_GET["q"]; } elseif(isset($_POST["q"])) { $q=$_POST["q"]; } else { $q=""; }
if (isset($_GET["sq"])) { $sq=$_GET["sq"]; } elseif(isset($_POST["sq"])) { $sq=$_POST["sq"]; } else { $sq=""; }

	// Champs de la table docteurs
	
	$champsSecretaire=array(
			"docteurs"=>array("id","mdp","nom","prenom","activation","statut")
			);
$champsDocteur=array(
		"docteurs"=>array("id","mdp","nom","prenom","entete","couleur","activation","statut")
		);
if (!isset($_GET["table"])) {
	echo "<p class=\"erreur\">Erreur ! La page n'a pas été appelée avec les bons paramètres.</p>";
} else {
	$table=$_GET["table"];
	$table_utilisee="idoc_"."$table"."";
			
	switch($q) {
		case "Ajouter";
			$champs=$champsSecretaire;
			$nb_champs=sizeof($champs["$table"]);
			if ($sq=="Valider") {
				$valeurs="";
				$i=0;	
				while($i<$nb_champs) {
					$nom_champ=$champs["$table"]["$i"];	
					if ($i!=0) {
						$valeurs.=" ,";
					}
					$valeurs.="$nom_champ=\"$_POST[$nom_champ]\"";				
				$i++;
				}
				Ajouter("$table_utilisee",$valeurs);
				?>				
				<script language="Javascript">
				window.location="<? echo "".$_SERVER["PHP_SELF"]."?table=$table&msg=1"; ?>";
				</script>
				<?php
			} else {
			
				echo "
				<form action=\"".$_SERVER["PHP_SELF"]."?table=$table&q=Ajouter&sq=Valider\" method=\"post\">
				<table class=\"adminTable\" style=\"width:350px\" cellspacing=1>
				<tr><td>Ajout d'un nouvel utilisateur</td></tr>";
				$i=0;	
				while($i<$nb_champs) {
					$nom_champ=$champs["$table"]["$i"];
					$nom_champ_maj=strtoupper($nom_champ);
					echo '
					<tr>
						<td valign="top" class="adminHeader"><b>'.$nom_champ_maj.'</b></td></tr><tr><td class="adminTD">';
						switch($nom_champ) {
							case "id":
							echo '<input type="text" name="id" /><br />Choisissez un login';
							break;
							case "mdp":
							echo '<input type="text" name="mdp" /><br />Composez votre Mot De Passe à l\'écart des regards indiscrets';
							break;
							case "couleur":
							$selectCouleursUtilisees=mysql_query("select couleur from $table_docteurs");
								$tabCouleursUtilisees=array();
								while ($resCU=mysql_fetch_array($selectCouleursUtilisees)) {
									$tabCouleursUtilisees[]=$resCU['couleur'];
								}
							echo '<select name="couleur" style="width:100px;">';
							for ($j=0;$j<sizeof($tabCouleurs);$j++) {
								if (!in_array ($tabCouleurs[$j], $tabCouleursUtilisees)) {
									echo '<option value="'.$tabCouleurs[$j].'" style="background-color:'.$tabCouleurs[$j].'"></option>';
								}
							}
							echo '</select><br />Choisissez une couleur qui vous "représentera" dans les plannings (les couleurs déjà utilisées ne sont pas affichées)';
							
							break;
							case "activation":
							echo '<input type="radio" name="activation" value="Y" checked>Activé</input><input type="radio" name="activation" value="N">Désactivé</input>';
							break;
							case "statut":
							echo '<select name="statut">
							<option value="docteur">Docteur</option>
							<option value="secretaire">Secrétaire</option>
							</select><br />
							Si vous choisissez "Docteur", n\'oubliez pas, après validation, d\'aller choisir une couleur et de créer votre entête en modifiant le profil nouvellement créé !';
							break;
							default:
							echo "<textarea name=\"$nom_champ\" cols=\"40\" rows=\"3\"></textarea>";
							break;
						}
						echo "
					</td>
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
		$selectStatut=mysql_query("select statut from $table_utilisee where id=\"$_GET[id]\"");
		$resStatut=mysql_fetch_array($selectStatut);
		if ($resStatut["statut"]=="docteur") {
			$champs=$champsDocteur;
		} else {
			$champs=$champsSecretaire;
		}
			$nb_champs=sizeof($champs["$table"]);
			$id=$_GET["id"];			
			if ($sq=="Valider") {
				$valeurs="";
				$i=0;	
				while($i<$nb_champs) {
					$nom_champ=$champs["$table"]["$i"];	
					if ($i!=0) {
						$valeurs.=" ,";
					}
					$valeurs.="$nom_champ=\"$_POST[$nom_champ]\"";				
				$i++;
				}
				Modifier("$table_utilisee",$valeurs,"id=\"$id\"");
				?>				
				<script language="Javascript">
				window.location="<? echo "".$_SERVER["PHP_SELF"]."?table=$table&msg=2"; ?>";
				</script>
				<?php
			} else {
			
			$select=mysql_query("select * from $table_utilisee where id=\"$id\"");
			$res=mysql_fetch_array($select);
			echo "
			<form action=\"".$_SERVER["PHP_SELF"]."?table=$table&q=Modifier&sq=Valider&id=$id\" method=\"post\">
			<table border=\"0\" class=\"adminTable\" cellspacing=\"1\" style=\"width:350px\">
				<tr><td>Modification d'une entrée de la table \"$table\"</td></tr>";
			$i=0;	
			while($i<$nb_champs) {
				$nom_champ=$champs["$table"]["$i"];
				$nom_champ_maj=strtoupper($nom_champ);
				echo '
					<tr>
						<td valign="top" class="adminHeader"><b>'.$nom_champ_maj.'</b></td></tr><tr><td class="adminTD">';
						switch($nom_champ) {
							case "id":
							echo '<input type="text" name="id" value="'.$res[$nom_champ].'" /><br />Choisissez un login';
							break;
							case "mdp":
							echo '<input type="text" name="mdp" value="'.$res[$nom_champ].'" /><br />Composez votre Mot De Passe à l\'écart des regards indiscrets';
							break;
							case "couleur":
							$selectCouleursUtilisees=mysql_query("select couleur from $table_docteurs where id!=\"$id\"");
								$tabCouleursUtilisees=array();
								while ($resCU=mysql_fetch_array($selectCouleursUtilisees)) {
									$tabCouleursUtilisees[]=$resCU['couleur'];
								}
							echo '<select name="couleur" style="width:100px;">';
							for ($j=0;$j<sizeof($tabCouleurs);$j++) {
								if ($tabCouleurs[$j]==$res['$nom_champ']) {
									$c_selected=" selected";
								} else {
									$c_selected="";
								}
								if (!in_array ($tabCouleurs[$j], $tabCouleursUtilisees)) {
									echo '<option value="'.$tabCouleurs[$j].'" style="background-color:'.$tabCouleurs[$j].'"'.$c_selected.'></option>';
								}
							}
							echo '</select><br />Choisissez une couleur qui vous "représentera" dans les plannings (les couleurs déjà utilisées ne sont pas affichées)';
							break;
							case "activation":
							$y_selected=($res[$nom_champ]=='Y') ? ' checked' : '';
							$n_selected=($res[$nom_champ]=='N') ? ' checked' : '';
							echo '<input type="radio" name="activation" value="Y"'.$y_selected.'>Activé</input><input type="radio" name="activation" value="N"'.$n_selected.'>Désactivé</input>';
							break;
							case "entete":
							echo '
							<textarea id="entete" name="entete" style="width:100%" rows="20">'.htmlentities($res['entete']).'</textarea>
							Cette entête apparaitra lors de l\'impression des ordonnances
							';
							break;
							case "statut":
							$docteur_selected=($res[$nom_champ]=='docteur') ? ' selected' : '';
							$secretaire_selected=($res[$nom_champ]=='secretaire') ? ' selected' : '';
							echo '<select name="statut">
							<option value="docteur"'.$docteur_selected.'>Docteur</option>
							<option value="secretaire"'.$secretaire_selected.'>Secrétaire</option>
							</select>';
							break;
							default:
							echo "<textarea name=\"$nom_champ\" cols=\"40\" rows=\"3\">".$res["$nom_champ"]."</textarea>";
							break;
						}
						echo "
					</td>
					</tr>";
				$i++;
			}
			echo "
			<tr valign=\"top\">
				<td colspan=\"2\" align=\"center\" class=\"adminHeader\"><input type=\"submit\" value=\"Valider\"></td>
			</tr>
			</table>
			</form>
			";
			$insertIntoFoot='
			<script language="javascript">
							initEditor();
							</script>
							';
			}
		break;
		
		case "Supprimer";
		SousTitre("Suppression d'une entrée de la table \"$table\"");
		Supprimer("$table_utilisee","id=\"$_GET[id]\"");
		?>				
		<script language="Javascript">
		window.location="<? echo "".$_SERVER["PHP_SELF"]."?table=$table&msg=3"; ?>";
		</script>
		<?php
		break;
	
		
		default:
		$champs=$champsDocteur;
		$ordre=$champs["$table"]["0"];
		$select=mysql_query("select * from $table_utilisee order by $ordre ASC");
		$nb_enregistrements=mysql_num_rows($select);
		$tab_msg=array(
						"1"=>"Les données ont été correctement ajoutées !",
						"2"=>"Les données ont été correctement modifiées !",
						"3"=>"Suppression de l'enregistrement effectué !");
		if (isset($_GET["msg"])) {
			echo "<p class=\"erreur\">".$tab_msg[$_GET["msg"]]."</p>";
		}
		?>
		<table border="0" cellspacing="1" class="adminTable">
			<tr><td colspan="<?=(sizeof($champs[$table])+1)?>">Enregistrements de la table <?=$table?> :</td></tr>
			<tr align="center"><td class="adminHeader"><b>ACTIONS</b></td>
			<?php	
			$nb_champs=sizeof($champs["$table"]);
			while(list($k,$nom_champ)=each($champs["$table"])) {
				$nom_champ_maj=strtoupper($nom_champ);
				echo "<td class=\"adminHeader\"><b>$nom_champ_maj</b></td>"; 
			}
			?>
			</tr>
		<?php
		while ($res=mysql_fetch_array($select)) {
			echo "<tr><td class=\"adminTD\">[<a href=\"".$_SERVER["PHP_SELF"]."?table=$table&q=Modifier&id=$res[id]\">M</a>] - [<a href=\"javascript:confirmation('".$_SERVER["PHP_SELF"]."?table=$table&q=Supprimer&id=$res[id]');\">S</a>]</td>";
			$i=0;	
			while($i<$nb_champs) {
				$nom_champ=$champs["$table"]["$i"];
				if ($nom_champ=="mdp") {
					echo "<td class=\"adminTD\">********</td>";
				} else {
					echo "<td class=\"adminTD\">".$res["$nom_champ"]."</td>"; 
				}
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